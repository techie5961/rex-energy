<?php

namespace App\Http\Controllers;

use App\Helpers\CurrencyHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class UserDashboardController extends Controller
{
    // register
    public function Register(){

        return view('users.auth.register',[
            'captcha' => rand(1000,9999),
            'ref' => request('ref') ?? '',
            'page' => 'register'
        ]);
    }
    // login
    public function Login(){

        return view('users.auth.login',[
            'page' => 'login'
        ]);
    }
   
    // dashboard
    public function Dashboard(){
        $packages=DB::table('packages')->where('available','>','0')->orderBy('cost','asc')->get();
        $packages->transform(function($each){
            $each->purchased=DB::table('purchased_packages')->where('user_id',Auth::guard('users')->user()->id)->where('package->id',$each->id)->count();
            return $each;
        });
        return view('users.dashboard',[
            'total_balance' => CurrencyHelper::format(Auth::guard('users')->user()->main_balance + Auth::guard('users')->user()->deposit_balance,'NGN',DB::table('users')->where('id',Auth::guard('users')->user()->id)->first()->display_currency),
            'main_balance' => CurrencyHelper::format(Auth::guard('users')->user()->main_balance,'NGN',DB::table('users')->where('id',Auth::guard('users')->user()->id)->first()->display_currency),
            'deposit_balance' => CurrencyHelper::format(Auth::guard('users')->user()->deposit_balance,'NGN',DB::table('users')->where('id',Auth::guard('users')->user()->id)->first()->display_currency),
            'packages' => $packages,
            'referral_settings' => json_decode(DB::table('settings')->where('key','referral_settings')->first()->value ?? '{}'),
            'social_settings' => json_decode(DB::table('settings')->where('key','social_settings')->first()->value ?? '{}'),
            'finance_settings' => json_decode(DB::table('settings')->where('key','finance_settings')->first()->value ?? '{}'),
            'active_plans' => DB::table('purchased_packages')->where('user_id',Auth::guard('users')->user()->id)->where('status','active')->count(),
            'total_earnings' => DB::table('purchased_packages')->where('user_id',Auth::guard('users')->user()->id)->where('status','active')->sum('package->earning'),
            'total_referrals' => DB::table('users')->where('ref',Auth::guard('users')->user()->id)->count(),
            'total_withdrawn' => DB::table('transactions')->where('user_id',Auth::guard('users')->user()->id)->where('type','withdrawal')->where('status','success')->sum('amount'),

        ]);
    }

    // active products
    public function ActiveProducts(){
        $packages=DB::table('purchased_packages')->where('user_id',Auth::guard('users')->user()->id)->where('status','active')->where('cycle','>','0');
       if(request()->has('status')){
        $packages=$packages->where('status',request('status'));
       }
        $packages=$packages->orderBy('date','desc')->paginate(50);
        $packages->getCollection()->transform(function($each){
            $each->package=json_decode($each->package);
            $each->next=Carbon::parse($each->updated)->addDay()->format(' h:i').(Carbon::parse($each->updated)->format('H') >= 12 ? ' PM' : ' AM');
            $each->frame=Carbon::parse($each->date)->diffForHumans();
            $each->income_time=Carbon::parse($each->updated)->format('j:i A');
            return $each;
        });
        return view('users.products.active',[
            'packages' => $packages,
        ]);
    }

    // profile
    public function Profile(){
        return view('users.profile',[
            'total_earnings' => DB::table('purchased_packages')->where('user_id',Auth::guard('users')->user()->id)->where('status','active')->sum('package->earning'),
            'social_settings' => json_decode(DB::table('settings')->where('key','social_settings')->first()->value ?? '{}'),

        ]);
    }

    // transactions
    public function Transactions(){
        $total=DB::table('transactions')->where('user_id',Auth::guard('users')->user()->id);
        $trx=DB::table('transactions')->where('user_id',Auth::guard('users')->user()->id);
        if(request()->has('type')){
            $trx=$trx->where('type',request('type'));
        }
        $trx=$trx->orderBy('date','desc')->paginate(100);
        $trx->getCollection()->transform(function($each){
            $each->frame=Carbon::parse($each->date)->format('jS M Y \a\t H:i A');
            return $each;
        });
        $total=$total->count();
        return view('users.transactions',[
            'total' => $total,
            'trx' => $trx
        ]);
    }

    // withdraw
    public function Withdraw(){
        $finance_settings=json_decode(DB::table('settings')->where('key','finance_settings')->first()->value ?? '{}');
        return view('users.withdraw',[
            'finance_settings' => $finance_settings,
        ]);
    }

    // add bank
    public function AddBank(){
      
        $banks=file_get_contents(database_path('data/banks.json'));
        $banks=json_decode($banks);
        $banks=collect($banks)->sortBy('name')->all();
     
        return view('users.bank',[
            'banks' => $banks,
            'next' => request('next') ?? null
        ]);
    }

    // password update
    public function PasswordUpdate(){
        return view('users.settings.password');
    }

    // logout
    public function Logout(){
        Auth::guard('users')->logout();
        return redirect('users/login');
    }

    // invite
    public function Invite(){
        return view('users.invite',[
            'total_referrals' => DB::table('users')->where('ref',Auth::guard('users')->user()->id)->count(),
            'total_reward' => DB::table('transactions')->where('user_id',Auth::guard('users')->user()->id)->where('type','referral_commission')->sum('amount'),
            'referral_settings' => json_decode(DB::table('settings')->where('key','referral_settings')->first()->value ?? '{}')
        ]);
    }

    // redeem gift code
    public function RedeemGiftCode(){
        return view('users.giftcode');
    }

    // recharge
    public function Recharge(){
        $gateways=collect((array) json_decode(file_get_contents(database_path('data/gateways.json')))->deposit)
    ->filter(fn ($status) => $status === 'active');
      
    $finance_settings=json_decode(DB::table('settings')->where('key','finance_settings')->first()->value ?? '{}');
    return view('users.recharge.general',[
        'finance_settings' => $finance_settings,
            'gateways' => $gateways,
            'packages' => DB::table('packages')->where('status','active')->orderBy('cost','asc')->limit(9)->get()
        ]);
    }

    // referrals
    public function Referrals(){
        $referrals=DB::table('users');
    if(!request()->has('level') && (request('level') == 1 || request('level') != 2 || request('level') != 3)){
        $referrals=$referrals->where('ref',Auth::guard('users')->user()->id);
        $team_deposit = DB::table('transactions')
    ->whereIn('user_id', function ($query) {
        $query->select('id')
            ->from('users')
            ->where('ref', Auth::guard('users')->id());
    })
    ->where('type','deposit')
    ->where('status', 'success')
    ->sum('amount');
    }

    if(request('level') == 2){
        $referrals=$referrals->whereIn('ref', function ($query) {
        $query->select('id')
            ->from('users')
            ->where('ref', Auth::guard('users')->user()->id);
    });

    $team_deposit = DB::table('transactions')
    ->whereIn('user_id', function ($query) {
        $query->select('id')
            ->from('users')
            ->whereIn('ref', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('ref', Auth::guard('users')->id());
            });
    })
    ->where('type','deposit')
    ->where('status', 'success')
    ->sum('amount');
    
    }
      if (request('level') == 3) {
    $referrals = $referrals->whereIn('ref', function ($query) {
        $query->select('id')
            ->from('users')
            ->whereIn('ref', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('ref', Auth::guard('users')->id());
            });
    });

    $team_deposit = DB::table('transactions')
    ->whereIn('user_id', function ($query) {
        $query->select('id')
            ->from('users')
            ->whereIn('ref', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->whereIn('ref', function ($query) {
                        $query->select('id')
                            ->from('users')
                            ->where('ref', Auth::guard('users')->id());
                    });
            });
    })
    ->where('type','deposit')
    ->where('status', 'success')
    ->sum('amount');
}

        $referrals=$referrals->orderBy('date','desc')->paginate(100);
        $team_size=$referrals->count();
        $referrals->getCollection()->transform(function($each){
            $each->deposits=DB::table('transactions')->where('type','deposit')->where('status','success')->where('user_id',$each->id)->sum('amount');
            $each->withdrawn=DB::table('transactions')->where('type','withdrawal')->where('status','success')->where('user_id',$each->id)->sum('amount');
            $each->products=DB::table('purchased_packages')->where('user_id',$each->id)->count();
            $each->commission=DB::table('transactions')->where('type','referral_commission')->where('user_id',$each->id)->where('status','success')->sum('amount');
            $each->time=Carbon::parse($each->date)->format('jS, M Y \a\t H:i A');
            return $each;
        });
        return view('users.referrals',[
            'referrals' => $referrals,
            'team_size' => $team_size,
            'team_deposit' => $team_deposit,
            'referral_settings' => json_decode(DB::table('settings')->where('key','referral_settings')->first()->value ?? '{}')
        ]);
    }

    // salary
    public function Salary(){
        $salary=DB::table('salary')->orderBy('referrals','asc')->limit(50)->get();
        $salary->transform(function($each){
            $each->earned=DB::table('salaries')->where('user_id',Auth::guard('users')->user()->id)->where('salary->id',$each->id)->exists() ? 1 : 0;
            return $each;
        });
       
        return view('users.salary',[
            'salary' => $salary,
            'ref' => DB::table('users')->where('ref',Auth::guard('users')->user()->id)->whereIn('id',function($q){
                $q->select('user_id')->from('purchased_packages')->distinct();
            })->count(),
        ]);
    }

      // manual deposit checkout
    public function ManualDepositCheckout(){
        $validator=Validator::make(request()->all(),[
            'id' => 'required|regex:/^[0-9]+$/|exists:transactions,id,status,initiated'
        ]);
        if($validator->fails()){
           return redirect('users/recharge');
        }
        return view('users.recharge.checkout',[
            'id' => request('id'),
            'trx' => DB::table('transactions')->where('id',request('id'))->first(),
            'bank_settings' => json_decode(DB::table('settings')->where('key','bank_settings')->first()->value ?? '{}'),
        ]);
    }

    
}
