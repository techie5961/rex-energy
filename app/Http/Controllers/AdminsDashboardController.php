<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AdminsDashboardController extends Controller
{
    // login
    public function Login(){
        return view('admins.auth.login');
    }
    // dashboard
    public function DashBoard(){
        return view('admins.dashboard',[
            'total_users' => DB::table('users')->count(),
            'total_promoters' => DB::table('users')->where('type','promoter')->count(),
            'total_packages' => DB::table('packages')->count(),
            'today_users' => DB::table('users')->whereDate('date',Carbon::now())->count(),
            'pending_withdrawals' => DB::table('transactions')->where('type','withdrawal')->where('class','debit')->where('status','pending')->sum('amount'),
            'successfull_withdrawals' => DB::table('transactions')->where('type','withdrawal')->where('class','debit')->where('status','success')->sum('amount'),
            'rejected_withdrawals' => DB::table('transactions')->where('type','withdrawal')->where('class','debit')->where('status','rejected')->sum('amount'),
            'pending_deposits' => DB::table('transactions')->where('type','deposit')->where('class','credit')->where('status','pending')->sum('amount'),
            'successfull_deposits' => DB::table('transactions')->where('type','deposit')->where('class','credit')->where('status','success')->sum('amount'),
            'rejected_deposits' => DB::table('transactions')->where('type','deposit')->where('class','credit')->where('status','rejected')->sum('amount'),


        ]);
    }
    // transactions
    public function Transactions(){
     
        // variables
        $data=DB::table('transactions');
        if(!request()->has('initiated')){
            $data->whereNot('status','initiated');
        }

// pending

        if(request()->has('type')){
            $data=$data->where('type',request('type'));

        }
        if(request()->has('status')){
            $data=$data->where('status',request('status'));
          
        }
        if(request()->has('user_id')){
             $data=$data->where('user_id',request('user_id'));
            
        }
        if(request()->has('giftcode')){
             $data=$data->where('type','giftcode')->where('json->giftcode_id',request('giftcode_id'));
          
        }

        if(request()->has('investment_id')){
            $data=$data->where('json->investment_id',request('investment_id'));
        }
       $transactions=$data->orderBy('date','desc')->paginate(10);
       $transactions->getCollection()->transform(function($each){
    $each->day=Carbon::parse($each->date)->format('M d, Y');
    $each->time=Carbon::parse($each->date)->format('H:i');
    $each->frame=Carbon::parse($each->date)->diffForHumans();
    return $each;
       });
      
       
        return view('admins.transactions',[
            'total' => $data->count(),
            'today' => $data->whereDate('date',Carbon::today())->count(),
            'sum' => $data->sum('amount'),
            'trx' => $transactions,
            'type' => request('type'),
            'status' => request('status') == 'success' ? 'successful' : request('status')
        ]);
    }
    // transaction receipt
    public function TransactionReceipt(){
        $trx=DB::table('transactions')->where('id',request('id'))->first();
        $trx->day=Carbon::parse($trx->date)->format('M d, Y');
        $trx->time=Carbon::parse($trx->date)->format('H:i');
        $trx->user=DB::table('users')->where('id',$trx->user_id)->first();
        $trx->user->frame=Carbon::parse($trx->user->date)->diffForHumans();
        return view('admins.receipt',[
            'data' => $trx,
            'gateways' => json_decode(file_get_contents(database_path('data/gateways.json'))),

        ]);
    }

    // all users
    public function AllUsers(){
      
        $users=DB::table('users');
        if(request()->has('status')){
            $users=$users->where('status',request('status'));
        }
        if(request()->has('type')){
            $users=$users->where('type',request('type'));
        }
        if(request()->has('new')){
            $users=$users->where('date',Carbon::today());
        }
        $users=$users->orderBy('date','desc')->paginate(10);
        $users->getCollection()->transform(function($each){
    $each->frame=Carbon::parse($each->date)->diffForHumans();
    $each->upline=DB::table('users')->where('id',$each->ref)->first()->phone ?? 'None';
    $each->downlines=DB::table('users')->where('ref',$each->id)->count();
    return $each;
        });
        return view('admins.users',[
            'users' => $users,
            'status' => request()->has('status') ? request('status') : 'All',
            'total_users' => DB::table('users')->count(),
            'active_users' => DB::table('users')->where('status','active')->count(),
            'today_signups' => DB::table('users')->whereDate('date',Carbon::today())->count(),
            'type' => request('type','User')
        ]);
    }
    // user 
    public function User(){
        $user=DB::table('users')->where('id',request('id'))->first();
         $user->frame=Carbon::parse($user->date)->diffForHumans();
    $user->upline=DB::table('users')->where('id',$user->ref)->first()->phone ?? 'None';
    $user->downlines=DB::table('users')->where('ref',$user->id)->count();
    $user->investment_count=DB::table('purchased_packages')->where('user_id',$user->id)->count();
    $user->investment_amount=DB::table('purchased_packages')->where('user_id',$user->id)->sum('package->cost');
    $user->active_investments=DB::table('purchased_packages')->where('user_id',$user->id)->where('cycle','>',0)->count();
    $user->active_investments_amount=DB::table('purchased_packages')->where('user_id',$user->id)->where('cycle','>',0)->sum('package->cost');
    $user->total_daily_income=DB::table('purchased_packages')->where('user_id',$user->id)->where('cycle','>',0)->sum('package->earning');
    $user->total_deposit=DB::table('transactions')->where('user_id',$user->id)->where('type','deposit')->where('status','success')->sum('amount');
    $user->total_withdrawn=DB::table('transactions')->where('user_id',$user->id)->where('type','withdrawal')->where('status','success')->sum('amount');
    $user->last_deposit=DB::table('transactions')->where('user_id',$user->id)->where('type','deposit')->where('status','success')->orderBy('date','desc')->first()->amount ?? 0;
    $user->last_login=DB::table('logs')->where('user_id',$user->id)->exists() ? Carbon::parse(DB::table('logs')->where('user_id',$user->id)->first()->date)->diffForHumans() : 'Not yet logged in';
        return view('admins.user',[
           'data' => $user
        ]);

    }
    // site settings
    public function SiteSettings(){
        return view('admins.settings',[
            'general_settings' => json_decode(DB::table('settings')->where('key','general_settings')->first()->value ?? '{}'),
            'finance_settings' => json_decode(DB::table('settings')->where('key','finance_settings')->first()->value ?? '{}'),
            'social_settings' => json_decode(DB::table('settings')->where('key','social_settings')->first()->value ?? '{}'),
            'referral_settings' => json_decode(DB::table('settings')->where('key','referral_settings')->first()->value ?? '{}'),

        ]);
    }
    // notifications
    public function Notifications(){
      
    $notifications=DB::table('notifications');
    $notifications=$notifications->orderBy('date','desc')->paginate(10);
    $notifications->getCollection()->transform(function($each){
        $each->frame=Carbon::parse($each->date)->diffForHumans();
        return $each;
    });
        return view('admins.notifications',[
        'total' => DB::table('notifications')->count(),
        'read' => DB::table('notifications')->where('status->admins','read')->count(),
        'unread' => DB::table('notifications')->where('status->admins','unread')->count(),
        'notifications' => $notifications
        ]);
    }

    // logout
    public function Logout(){
       Auth::guard('admins')->logout();
       return redirect('admins/login');
    }

 // add package
    public function AddPackage(){
        return view('admins.packages.add');
    }

    // manage packages
    public function ManagePackages(){
        $packages=DB::table('packages');

       $packages=$packages->orderBy('updated','desc')->paginate(10);
       $packages->getCollection()->transform(function($each){
          $each->updated_frame=Carbon::parse($each->updated)->diffForHumans();
          $each->date_frame=Carbon::parse($each->date)->diffForHumans();
          $each->purchased=DB::table('purchased_packages')->where('package->id',$each->id)->count();
;          return $each;
       });
        return view('admins.packages.manage',[
            'total' => DB::table('packages')->count(),
            'packages' => $packages
        ]);
    }

    // delete package
    public function DeletePackage(){
        DB::table('packages')->where('id',request('id'))->delete();
        return redirect(url()->previous());
    }
    
    // edit package
    public function EditPackage(){
        $package=DB::table('packages')->where('id',request('id'))->first();
        return view('admins.packages.edit',[
            'data' => $package
        ]);
    }

    // mark as promoter
    public function MarkAsPromoter(){
        DB::table('users')->where('id',request('user_id'))->update([
            'type' => DB::raw("CASE WHEN type = 'promoter' THEN 'user' ELSE 'promoter' END")
        ]);
        return redirect(url()->previous());
    }

    // add gift code
    public function CreateGiftCode(){
        return view('admins.giftcode.create');
    }

    // manage gift codes
    public function ManageGiftCodes(){
       try{
        $codes=DB::table('giftcodes')->orderBy('updated','desc')->paginate(10);
        $codes->getCollection()->transform(function($each){
            $each->date=Carbon::parse($each->date)->diffForHumans();
            $each->updated=Carbon::parse($each->updated)->diffForHumans();
            $each->status=($each->redeemed >= $each->limit) ? 'completed' : 'active';
            return $each;
        });
         return view('admins.giftcode.manage',[
            'total' => DB::table('giftcodes')->count(),
            'total_active' => DB::table('giftcodes')->whereColumn('redeemed','<','limit')->count(),
            'total_redeemed' => DB::table('giftcodes')->whereColumn('redeemed','>=','limit')->count(),
            'codes' => $codes
        ]);
       }catch(\Exception $e){
        return $e->getMessage();
       }
    }

    // edit gift code
    public function EditGiftCode(){
        return view('admins.giftcode.edit',[
            'code' => DB::table('giftcodes')->where('id',request('id'))->first()
        ]);
    }
   
    // delete gift code
    public function DeleteGiftCode(){
            DB::table('giftcodes')->where('id',request('id'))->delete();
            return redirect(url()->previous());
    }

    // investment records
    public function InvestmentRecords(){
        $data=DB::table('purchased_packages');

        if(request()->has('user_id')){
            $data=$data->where('user_id',request('user_id'));
        }

        if(request()->has('package_id')){
            $data=$data->where('package->id',request('package_id'));
        }
       


        $investments=$data->orderBy('date','desc')->paginate(10);
        $investments->getCollection()->transform(function($each){
                $each->package=json_decode($each->package);
                $each->date=Carbon::parse($each->date)->diffForHumans();
                $each->user=DB::table('users')->where('id',$each->user_id)->first();
                $each->cycle=$each->cycle < 0 ? 0 : $each->cycle;
                $each->time_format=Carbon::parse($each->updated)->format('h:i');
                $each->meridian=Carbon::parse($each->updated)->format('H') > 12 ? 'PM' : 'AM';
                return $each;
        });
        return view('admins.packages.investments',[
            'investments' => $investments,
            'total' => $data->count(),
            'active' => $data->where('cycle','>',0)->where('status','active')->count(),
            'sum' => $data->sum('package->cost')
        ]);
    }

    // action investment earning
    public function ActionEarning(){
        DB::table('purchased_packages')->where('id',request('id'))->update([
            'status' => DB::raw("CASE WHEN status = 'active' THEN 'paused' ELSE 'active' END")
        ]);
        return redirect(url()->previous());
    }

    // delete investment
    public function DeleteInvestment(){
        DB::table('purchased_packages')->where('id',request('id'))->delete();
        return redirect(url()->previous());
    }

    // login settings
    public function LoginSettings(){
        return view('admins.loginsettings');
    }
    
    // add salary
    public function AddSalary(){
        return view('admins.salary.add');
    }

     // edit salary
    public function EditSalary(){
        return view('admins.salary.edit',[
            'salary' => DB::table('salary')->where('id',request('id'))->first()
        ]);
    }

    // manage salary
    public function ManageSalary(){
        $salary=DB::table('salary')->orderBy('date','desc')->paginate(10);
        $salary->getCollection()->transform(function($each){
            $each->added=Carbon::parse($each->date)->diffForHumans();
            return $each;
        });
       return view('admins.salary.manage',[
        'total' => DB::table('salary')->count(),
        'salary' => $salary
       ]);
    }

    // api manage
    public function APIManage(){
    $balance=Http::withToken(env('KORAPAY_SECRET_KEY'))->get('https://api.korapay.com/merchant/api/v1/balances')->json()['data']['NGN']['available_balance'];
    $history=Http::withToken(env('KORAPAY_SECRET_KEY'))->get('https://api.korapay.com/merchant/api/v1/balances/history',[
        'limit' => 50
    ]);
    if($history->successful()){
        $data=$history->json();
       $history=$data['data']['history'];
    }
        return view('admins.api',[
            'balance' => $balance,
            'history' => $history
        ]);
    }
    
       // deposit settings
    public function ManualDepositSettings(){
        return view('admins.settings.deposit',[
            'ip' => Http::get('https://api.ipify.org')->body(),
            'gateways' => json_decode(file_get_contents(database_path('data/gateways.json'))),
            'bank_settings' => json_decode(DB::table('settings')->where('key','bank_settings')->first()->value ?? '{}'),
            'crypto_settings' => json_decode(DB::table('settings')->where('key','crypto_settings')->first()->value ?? '{}'),
        ]);
    }
}
