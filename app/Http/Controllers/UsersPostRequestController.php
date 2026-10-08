<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CurrencyHelper;
use Illuminate\Support\Facades\Log;

class UsersPostRequestController extends Controller
{
    // send otp
    public function SendOTP(){
      try{
          $validator=Validator::make(request()->all(),[
            'phone' => 'required|numeric|digits:11'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first()
            ]);
        }
        $otp=rand(100000,999999);
        DB::table('otps')->insert([
            'phone' => request('phone'),
            'code' => $otp,
            'status' => 'active',
            'updated' => Carbon::now(),
            'date' => Carbon::now()
        ]);
        return response()->json([
            'message' => $otp,
            'status' => 'success'
        ]);
      }catch(\Exception $e){
        return response()->json([
            'message' => $e->getMessage(),
            'status' => 'error'
        ]);
      }
    }
    // register
    public function Register(){
        request()->merge(array_map('trim',request()->all()));
        $validator=Validator::make(request()->all(),[
            'phone_number' => 'required|numeric|digits:11|unique:users,phone',
            'referral_code' => 'required|string|exists:users,uniqid',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ],[
            'referral_code.exists' => 'Invalid referral code'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }
       
        $phone=request('phone_number');
        $ref=DB::table('users')->where('uniqid',request('referral_code'))->where('status','active');
        $upline=null;
        $finance_settings=json_decode(DB::table('settings')->where('key','finance_settings')->first()->value ?? '{}');
        $welcome_bonus=$finance_settings->welcome_bonus;
        if($ref->exists()){
            $upline=$ref->first()->id;
        }
  
    

    DB::transaction(function() use($phone,$upline,$welcome_bonus){
        $user_id=DB::table('users')->insertGetId([
        'uniqid' => GenerateID(),
        'type' => 'user',
        'username' => $phone,
        'phone' => $phone,
        'name' => $phone,
        'email' => $phone.'@'.str_replace(['http://','https://'],'',env('APP_URL')),
        'main_balance' => $welcome_bonus,
        'ref' => $upline,
        'password' => Hash::make(request('password')),
        'status' => 'active',
        'updated' => Carbon::now(),
        'date' => Carbon::now()
    ]);
    if($welcome_bonus > 0){
        DB::table('transactions')->insert([
    'uniqid' => GenerateID(),
    'user_id' => $user_id,
    'title' => 'Welcome Bonus',
    'class' => 'credit',
    'type' => 'welcome_bonus',
    'amount' => $welcome_bonus,
    'fee' => 0,
    'icon' => '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M4 5H20V3H4V5ZM20 9H4V7H20V9ZM3 11H10V13H14V11H21V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V11ZM16 13V15H8V13H5V19H19V13H16Z"></path></svg>',
    'wallet' => json_encode([
        'from' => 'admin',
        'to' => 'main_balance',

    ]),
     'json' => json_encode([
    'balance' => [
        'before' => 0,
        'after' => $welcome_bonus
    ],
    'primary_wallet' => 'Main Wallet'

    ]),
    'status' => 'success',
    'updated' => Carbon::now(),
    'date' => Carbon::now()
    ]);
    }
    });
    DB::table('otps')->where('phone',request('phone'))->delete();
    return response()->json([
        'message' => 'Registration successfull,redirecting...',
        'status' => 'success'
    ]);
    }

    // login
    public function Login(){
       request()->merge(array_map('trim',request()->all()));
       $validator=Validator::make(request()->all(),[
        'phone' => 'required|digits:11|numeric|exists:users,phone',
        'password' => 'required'
       ],[
        'phone.exists' => 'User not found'
       ]);

       if($validator->fails()){
        return response()->json([
            'message' => $validator->errors()->first(),
            'status' => 'error'
        ]);
       }
        $phone=request('phone');
       
        $user=DB::table('users')->where('phone',$phone)->first();
        if($user->status == 'banned'){
            return response()->json([
                'message' => 'User account is banned',
                'status' => 'error'
            ]);
        }

        if(!Hash::check(request('password'),$user->password)){
            return response()->json([
                'message' => 'Invalid account password',
                'status' => 'error'
            ]);
        }
        Auth::guard('users')->loginUsingId($user->id,true);
        DB::table('logs')->updateOrInsert([ 'user_id' => $user->id ],[
            'user_id' => $user->id,
            'status' => 'success',
            'date' => Carbon::now()
        ]);
        return response()->json([
            'message' => 'Login successful,redirecting...',
            'status' => 'success'
        ]);

    }

    // purchase package
    public function PurchasePackage(){
        try{

         request()->merge(array_map('trim',request()->all()));
        $validator=Validator::make(request()->all(),[
            'id' => 'required|integer|min:1'
            
        ],[
            'id.required' => 'Product is required and cannot be empty',
            'id.integer' => 'Invalid product selected',
            'id.min' => 'Invalid product selected'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }
        $tx=false;
        $package=DB::table('packages')->where('id',request('id'))->first();
        $referral_settings=json_decode(DB::table('settings')->where('key','referral_settings')->first()->value ?? '{}');
        $finance_settings=json_decode(DB::table('settings')->where('key','finance_settings')->first()->value ?? '{}');
        $welcome_bonus=$finance_settings->welcome_bonus;
        if($package->available <= 0){
            return response()->json([
                'message' => 'Product is no longer available for purchase',
                'status' => 'info'
            ]);
        }
        if($package->cost > Auth::guard('users')->user()->deposit_balance){
            return response()->json([
                'message' => 'Insufficient balance, please recharge',
                'status' => 'error'
            ]);
        }
         if(DB::table('purchased_packages')->where('user_id',Auth::guard('users')->user()->id)->where('package->id',request('id'))->count() >= $package->purchase_limit){
            return response()->json([
                'message' => 'Purchase Limit reached, please purchase another',
                'status' => 'error'
            ]);
        }

            $tx=DB::transaction(function() use($package,$referral_settings,$welcome_bonus){
     DB::table('users')->where('id',Auth::guard('users')->user()->id)->update([
            'deposit_balance' => DB::raw('deposit_balance - '.$package->cost.''),
            'updated' => Carbon::now()
        ]);
        $investment_id=DB::table('purchased_packages')->insertGetId([
        'uniqid' => GenerateID(),
        'user_id' => Auth::guard('users')->user()->id,
        'package' => json_encode($package),
        'cycle' => $package->validity,
        'status' => 'active',
        'updated' => carbon::now(),
        'date' => Carbon::now()
    ]);

          DB::table('transactions')->insert([
    'uniqid' => GenerateID(),
    'user_id' => Auth::guard('users')->user()->id,
    'title' => 'Product purchase',
    'class' => 'debit',
    'fee' => 0,
    'icon' => '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M4 3H20L22 7V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V7.00353L4 3ZM13 14V10H11V14H8L12 18L16 14H13ZM19.7639 7L18.7639 5H5.23656L4.23744 7H19.7639Z"></path></svg>',
    'type' => 'package_purchase',
    'amount' => $package->cost,
    'wallet' => json_encode([
        'from' => 'deposit_balance',
        'to' => 'admin',

    ]),
    'data' => json_encode([
        'Product' => $package->name,
        'Product Cost' => Auth::guard('users')->user()->currency.number_format($package->cost,2),
        'Daily Earning' => Auth::guard('users')->user()->currency.number_format($package->earning,2),
        'Total Earning' => Auth::guard('users')->user()->currency.number_format($package->earning * $package->validity,2),
        'Expires' => 'After '.number_format($package->validity).' days'
    ]),
     'json' => json_encode([
    'balance' => [
        'before' => Auth::guard('users')->user()->deposit_balance,
        'after' => Auth::guard('users')->user()->deposit_balance - $package->cost
    ],
    'primary_wallet' => 'Deposit Wallet',
    'package_id' => $package->id,
    'investment_id' => $investment_id

    ]),
    'status' => 'success',
    'updated' => Carbon::now(),
    'date' => Carbon::now()
    ]);
    if(Auth::guard('users')->user()->vip_level < $package->vip_level){
        DB::table('users')->where('id',Auth::guard('users')->user()->id)->update([
            'vip_level' => $package->vip_level
        ]);
    }

    // welcome bonus
    //  if($welcome_bonus > 0 && !DB::table('transactions')->where('type','welcome_bonus')->where('user_id',Auth::guard('users')->user()->id)->exists()){
    // DB::table('users')->where('id',Auth::guard('users')->user()->id)->increment('main_balance',$welcome_bonus);
    //  DB::table('transactions')->insert([
    // 'uniqid' => GenerateID(),
    // 'user_id' => Auth::guard('users')->user()->id,
    // 'title' => 'Welcome Bonus',
    // 'class' => 'credit',
    // 'type' => 'welcome_bonus',
    // 'amount' => $welcome_bonus,
    // 'fee' => 0,
    // 'icon' => '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M4 5H20V3H4V5ZM20 9H4V7H20V9ZM3 11H10V13H14V11H21V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V11ZM16 13V15H8V13H5V19H19V13H16Z"></path></svg>',
    // 'wallet' => json_encode([
    //     'from' => 'admin',
    //     'to' => 'main_balance',

    // ]),
    //  'json' => json_encode([
    // 'balance' => [
    //     'before' => 0,
    //     'after' => $welcome_bonus
    // ],
    // 'primary_wallet' => 'Main Wallet'

    // ]),
    // 'status' => 'success',
    // 'updated' => Carbon::now(),
    // 'date' => Carbon::now()
    // ]);
    // }
    
    DB::table('packages')->where('id',request('id'))->decrement('available');
    // level 1 referral commission
    if(Auth::guard('users')->user()->ref !== null && $referral_settings->level_1 > 0){
        $level1_commission=($referral_settings->level_1 * $package->cost)/100;
        $level1=DB::table('users')->where('id',Auth::guard('users')->user()->ref)->first();
        DB::table('users')->where('id',Auth::guard('users')->user()->ref)->increment('main_balance',$level1_commission,[
            'updated' => Carbon::now()
        ]);

     
          DB::table('transactions')->insert([
    'uniqid' => GenerateID(),
    'user_id' => $level1->id,
    'title' => 'Level 1 referral commission',
    'class' => 'credit',
    'fee' => 0,
    'icon' => '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M15.0049 2.00281C17.214 2.00281 19.0049 3.79367 19.0049 6.00281C19.0049 6.73184 18.8098 7.41532 18.4691 8.00392L23.0049 8.00281V10.0028H21.0049V20.0028C21.0049 20.5551 20.5572 21.0028 20.0049 21.0028H4.00488C3.4526 21.0028 3.00488 20.5551 3.00488 20.0028V10.0028H1.00488V8.00281L5.54065 8.00392C5.19992 7.41532 5.00488 6.73184 5.00488 6.00281C5.00488 3.79367 6.79574 2.00281 9.00488 2.00281C10.2001 2.00281 11.2729 2.52702 12.0058 3.35807C12.7369 2.52702 13.8097 2.00281 15.0049 2.00281ZM11.0049 10.0028H5.00488V19.0028H11.0049V10.0028ZM19.0049 10.0028H13.0049V19.0028H19.0049V10.0028ZM9.00488 4.00281C7.90031 4.00281 7.00488 4.89824 7.00488 6.00281C7.00488 7.05717 7.82076 7.92097 8.85562 7.99732L9.00488 8.00281H11.0049V6.00281C11.0049 5.00116 10.2686 4.1715 9.30766 4.02558L9.15415 4.00829L9.00488 4.00281ZM15.0049 4.00281C13.9505 4.00281 13.0867 4.81869 13.0104 5.85355L13.0049 6.00281V8.00281H15.0049C16.0592 8.00281 16.923 7.18693 16.9994 6.15207L17.0049 6.00281C17.0049 4.89824 16.1095 4.00281 15.0049 4.00281Z"></path></svg>',
    'type' => 'referral_commission',
    'amount' => $level1_commission,
    'wallet' => json_encode([
        'from' => 'admin',
        'to' => 'main_balance',

    ]),
    'data' => json_encode([
        'Referred User' => ucwords(Auth::guard('users')->user()->username),
        'Referral Level' => 'Level 1',
        'Product Purchased' => $package->name,
        'Product Cost' => $level1->currency.number_format($package->cost,2),
         ]),
     'json' => json_encode([
    'balance' => [
        'before' => $level1->main_balance,
        'after' => $level1->main_balance + $level1_commission
    ],
    'primary_wallet' => 'Main Wallet',
    'level' => 1

    ]),
    'status' => 'success',
    'updated' => Carbon::now(),
    'date' => Carbon::now()
    ]);

    // level 2 referral commission
    if($level1->ref !== null && $referral_settings->level_2 > 0){
            $level2=DB::table('users')->where('id',$level1->ref)->first();
            $level2_commission=($referral_settings->level_2 * $package->cost)/100;
            DB::table('users')->where('id',$level2->id)->increment('main_balance',$level2_commission,[
            'updated' => Carbon::now()
        ]);

     
          DB::table('transactions')->insert([
    'uniqid' => GenerateID(),
    'user_id' => $level2->id,
    'title' => 'Level 2 referral commission',
    'class' => 'credit',
    'fee' => 0,
    'icon' => '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M15.0049 2.00281C17.214 2.00281 19.0049 3.79367 19.0049 6.00281C19.0049 6.73184 18.8098 7.41532 18.4691 8.00392L23.0049 8.00281V10.0028H21.0049V20.0028C21.0049 20.5551 20.5572 21.0028 20.0049 21.0028H4.00488C3.4526 21.0028 3.00488 20.5551 3.00488 20.0028V10.0028H1.00488V8.00281L5.54065 8.00392C5.19992 7.41532 5.00488 6.73184 5.00488 6.00281C5.00488 3.79367 6.79574 2.00281 9.00488 2.00281C10.2001 2.00281 11.2729 2.52702 12.0058 3.35807C12.7369 2.52702 13.8097 2.00281 15.0049 2.00281ZM11.0049 10.0028H5.00488V19.0028H11.0049V10.0028ZM19.0049 10.0028H13.0049V19.0028H19.0049V10.0028ZM9.00488 4.00281C7.90031 4.00281 7.00488 4.89824 7.00488 6.00281C7.00488 7.05717 7.82076 7.92097 8.85562 7.99732L9.00488 8.00281H11.0049V6.00281C11.0049 5.00116 10.2686 4.1715 9.30766 4.02558L9.15415 4.00829L9.00488 4.00281ZM15.0049 4.00281C13.9505 4.00281 13.0867 4.81869 13.0104 5.85355L13.0049 6.00281V8.00281H15.0049C16.0592 8.00281 16.923 7.18693 16.9994 6.15207L17.0049 6.00281C17.0049 4.89824 16.1095 4.00281 15.0049 4.00281Z"></path></svg>',
    'type' => 'referral_commission',
    'amount' => $level2_commission,
    'wallet' => json_encode([
        'from' => 'admin',
        'to' => 'main_balance',

    ]),
    'data' => json_encode([
        'Level 1 Referra1' => ucwords(Auth::guard('users')->user()->username),
        'Referred User' => ucwords($level2->ref),
        'Referral Level' => 'Level 2',
        'Product Purchased' => $package->name,
        'Product Cost' => $level2->currency.number_format($package->cost,2),
         ]),
     'json' => json_encode([
    'balance' => [
        'before' => $level2->main_balance,
        'after' => $level2->main_balance + $level2_commission
    ],
    'primary_wallet' => 'Main Wallet',
    'level' => 2

    ]),
    'status' => 'success',
    'updated' => Carbon::now(),
    'date' => Carbon::now()
    ]);

        if($level2->ref !== null && $referral_settings->level_3 > 0){
               $level3=DB::table('users')->where('id',$level2->ref)->first();
            $level3_commission=($referral_settings->level_3 * $package->cost)/100;
            DB::table('users')->where('id',$level3->id)->increment('main_balance',$level3_commission,[
            'updated' => Carbon::now()
        ]);

     
          DB::table('transactions')->insert([
    'uniqid' => GenerateID(),
    'user_id' => $level3->id,
    'title' => 'Level 3 referral commission',
    'class' => 'credit',
    'fee' => 0,
    'icon' => '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M15.0049 2.00281C17.214 2.00281 19.0049 3.79367 19.0049 6.00281C19.0049 6.73184 18.8098 7.41532 18.4691 8.00392L23.0049 8.00281V10.0028H21.0049V20.0028C21.0049 20.5551 20.5572 21.0028 20.0049 21.0028H4.00488C3.4526 21.0028 3.00488 20.5551 3.00488 20.0028V10.0028H1.00488V8.00281L5.54065 8.00392C5.19992 7.41532 5.00488 6.73184 5.00488 6.00281C5.00488 3.79367 6.79574 2.00281 9.00488 2.00281C10.2001 2.00281 11.2729 2.52702 12.0058 3.35807C12.7369 2.52702 13.8097 2.00281 15.0049 2.00281ZM11.0049 10.0028H5.00488V19.0028H11.0049V10.0028ZM19.0049 10.0028H13.0049V19.0028H19.0049V10.0028ZM9.00488 4.00281C7.90031 4.00281 7.00488 4.89824 7.00488 6.00281C7.00488 7.05717 7.82076 7.92097 8.85562 7.99732L9.00488 8.00281H11.0049V6.00281C11.0049 5.00116 10.2686 4.1715 9.30766 4.02558L9.15415 4.00829L9.00488 4.00281ZM15.0049 4.00281C13.9505 4.00281 13.0867 4.81869 13.0104 5.85355L13.0049 6.00281V8.00281H15.0049C16.0592 8.00281 16.923 7.18693 16.9994 6.15207L17.0049 6.00281C17.0049 4.89824 16.1095 4.00281 15.0049 4.00281Z"></path></svg>',
    'type' => 'referral_commission',
    'amount' => $level3_commission,
    'wallet' => json_encode([
        'from' => 'admin',
        'to' => 'main_balance',

    ]),
    'data' => json_encode([
        'Level 1 Referral' => ucwords(Auth::guard('users')->user()->username),
        'Level 2 Referral' => ucwords($level2->username),
        'Referred User' => ucwords($level3->ref),
        'Referral Level' => 'Level 3',
        'Product Purchased' => $package->name,
        'Product Cost' => $level3->currency.number_format($package->cost,2),
         ]),
     'json' => json_encode([
    'balance' => [
        'before' => $level3->main_balance,
        'after' => $level3->main_balance + $level3_commission
    ],
    'primary_wallet' => 'Main Wallet',
    'level' => 3

    ]),
    'status' => 'success',
    'updated' => Carbon::now(),
    'date' => Carbon::now()
    ]);
        }
            
    }
    }
    return true;
            });
       
            if($tx){
     return response()->json([
            'message' => 'Product purchased successfully',
            'status' => 'success'
        ]);
            }

             return response()->json([
            'message' => 'Internal server error',
            'status' => 'error'
        ]);

        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ]);
        }
       
       
    }

    // add bank
    public function AddBank(){
        // return response()->json([
        //     'message' => request('account_name'),
        //     'status' => 'info'
        // ]);
        request()->merge(array_map('trim',request()->all()));
        $validator=Validator::make(request()->all(),[
            'account_number' => 'required|regex:/^[0-9]{10}$/',
            'account_name' => 'required|string|min:2|max:255',
            'bank_name' => 'required|string|min:2',
            'bank_code' => 'required|string'
        ],[
            'account_number.required' => 'Account number is required and cannot be empty',
            'account_number.regex' => 'Please enter a valid 10 digits account number',
            'account_name.required' => 'Account name is required and cannot be empty',
            'account_name.string' => 'Account name must be a string',
            'account_name.min' => 'Invalid account name',
            'account_name.regex' => 'Invalid account name',
            'account_name.max' => 'Account name must have a maximum of 255 characters',
            'bank_name.required' => 'Bank name is required and cannot be empty',
            'bank_name.string' => 'Bank name must consist of only strings',
            'bank_name.min' => 'Invalid bank',
            'bank_name.regex' => 'Invalid bank'
        ]);
 
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }
        $account_number=request('account_number');
        $account_name=request('account_name');
        $bank_code=request('bank_code');
        $bank_name=request('bank_name');
        $bank=collect(json_decode(file_get_contents(database_path('data/banks.json'))))->where('code',$bank_code)->first();
        $kkpay_id=$bank->kkpay_id;
        $nekpay_id=$bank->nekpay_id;

       
        $response=Http::post('https://api.korapay.com/merchant/api/v1/misc/banks/resolve',[
            'account' => request('account_number'),
            'bank' => request('bank_code')
        ]);
        if($response->successful()){
           $data=$response->json();
           if($data['status'] == true){
                $account_name=$data['data']['account_name'];
           }
        }else{
            return response()->json([
                'message' => 'We could not verify this account, please check the details and try again',
                'status' => 'error'
            ]);
        }

        $json=[];
        $json['account_number'] = $account_number;
        $json['bank_name'] = $bank_name;
        $json['account_name'] = $account_name;
        $json['bank_code'] = $bank_code;
        $json['kkpay_id'] = $kkpay_id;
        $json['nekpay_id'] = $nekpay_id;


        DB::table('users')->where('id',Auth::guard('users')->user()->id)->update([
            'bank' => json_encode($json),
            'updated' => Carbon::now()
        ]);

        return response()->json([
            'message' => 'Bank account added successfully',
            'status' => 'success'
        ]);

      
    }

    // withdrawal
    public function Withdrawal(){
        try{

        request()->merge(array_map('trim',request()->all()));
        $validator=Validator::make(request()->all(),[
            'amount' => 'required|min:0|integer',
        ],[
            'amount.required' => 'Withdrawal amount is required and cannot be empty',
            'amount.min' => 'Please enter a valid withdrawal amount',
            'amount.integer' => 'Withdrawal amount must only numbers',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }
        if(!isset(Auth::guard('users')->user()->bank)){
            return response()->json([
                'message' => 'Please bind your bank card befor placing withdrawal',
                'status' => 'info'
            ]);
        }
            $amount=CurrencyHelper::convert(request('amount'),Auth::guard('users')->user()->display_currency,'NGN');
          
        $finance_settings=json_decode(DB::table('settings')->where('key','finance_settings')->first()->value ?? '{}');
        $fee=($finance_settings->withdrawal->fee * $amount)/100;
        $amt=$amount - $fee;
        if(Auth::guard('users')->user()->status == 'banned'){
            return response()->json([
                'message' => 'Your account have been banned',
                'status' => 'error',
                'action' => 'refresh'
            ]);
        }
        if($amount > Auth::guard('users')->user()->main_balance){
            return response()->json([
                'message' => 'Insufficient balance',
                'status' => 'warning'
            ]);
        }

        if($amount == 0){
            return response()->json([
                'message' => 'Please enter a valid amount',
                'status' => 'error'
            ]);
        }

        if(DB::table('transactions')->where('user_id',Auth::guard('users')->user()->id)->where('type','withdrawal')->whereDate('date',Carbon::today())->count() >= $finance_settings->withdrawal->daily){
            return response()->json([
                'message' => 'You can only withdraw up to '.number_format($finance_settings->withdrawal->daily).' times daily',
                'status' => 'error'
            ]);
        }

        // if(!DB::table('purchased_packages')->where('status','active')->where('user_id',Auth::guard('users')->user()->id)->exists()){
        //      return response()->json([
        //         'message' => 'You must invest before placing withdrawal',
        //         'status' => 'error'
        //     ]);
        // }

        if($amount < $finance_settings->withdrawal->minimum){
            return response()->json([
                'message' => 'Minimum withdrawal is '.CurrencyHelper::format($finance_settings->withdrawal->minimum,'NGN',Auth::guard('users')->user()->display_currency).'',
                'status' => 'error'
            ]);
        }

        if($finance_settings->withdrawal->maximum != 0 && $amount > $finance_settings->withdrawal->maximum){
              return response()->json([
                'message' => 'Maximum withdrawal per request is '.CurrencyHelper::format($finance_settings->withdrawal->maximum,'NGN',Auth::guard('users')->user()->display_currency).'',
                'status' => 'error'
            ]);
        }

        if($finance_settings->withdrawal->portal == 'off'){
            return response()->json([
                'message' => 'Withdrawal currently unavailable, please try again between '.Carbon::parse($finance_settings->withdrawal->start_time)->format('H:i A').' to '.Carbon::parse($finance_settings->withdrawal->end_time)->format('H:i A').'',
                'status' => 'info'
            ]);
        }

        if(!isset(Auth::guard('users')->user()->bank)){
            return response()->json([
                'message' => 'Please link your bank account to be able to place withdrawal',
                'status' => 'info'
            ]);
        }

        $bank=json_decode(Auth::guard('users')->user()->bank);
        $tx=false;
        $tx=DB::transaction(function() use($amt,$amount,$fee,$bank){
            // new db
            DB::table('users')->where('id',Auth::guard('users')->user()->id)->decrement('main_balance',$amount,[
                'updated' => Carbon::now()
            ]);
            // new db
        DB::table('transactions')->insert([
    'uniqid' => GenerateID(),
    'user_id' => Auth::guard('users')->user()->id,
    'title' => 'Withdrawal to '.$bank->bank_name.'',
    'class' => 'debit',
    'type' => 'withdrawal',
    'amount' => $amt,
    'fee' => $fee,
    'icon' => '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M1 14.5C1 12.1716 2.22429 10.1291 4.06426 8.9812C4.56469 5.044 7.92686 2 12 2C16.0731 2 19.4353 5.044 19.9357 8.9812C21.7757 10.1291 23 12.1716 23 14.5C23 17.9216 20.3562 20.7257 17 20.9811L7 21C3.64378 20.7257 1 17.9216 1 14.5ZM16.8483 18.9868C19.1817 18.8093 21 16.8561 21 14.5C21 12.927 20.1884 11.4962 18.8771 10.6781L18.0714 10.1754L17.9517 9.23338C17.5735 6.25803 15.0288 4 12 4C8.97116 4 6.42647 6.25803 6.0483 9.23338L5.92856 10.1754L5.12288 10.6781C3.81156 11.4962 3 12.927 3 14.5C3 16.8561 4.81833 18.8093 7.1517 18.9868L7.325 19H16.675L16.8483 18.9868ZM13 13V17H11V13H8L12 8L16 13H13Z"></path></svg>',

    'wallet' => json_encode([
        'from' => 'main_balance',
        'to' => [
            'method' => 'bank',
            'account_number' => $bank->account_number,
            'bank_name' => $bank->bank_name,
            'account_name' => ucwords($bank->account_name)
        ],

    ]),
    'data' => json_encode([
        'Withdrawal method' => 'Bank Withdrawal',
        'Account number' => $bank->account_number,
        'Bank name' => $bank->bank_name,
        'Account name' => ucwords($bank->account_name)
    ]),
    'json' => json_encode([
    'balance' => [
        'before' => Auth::guard('users')->user()->main_balance,
        'after' => Auth::guard('users')->user()->main_balance - $amount
    ],
    'primary_wallet' => 'Main Wallet',
    'bank' => Auth::guard('users')->user()->bank

    ]),
    'status' => 'pending',
    'updated' => Carbon::now(),
    'date' => Carbon::now()
    ]);

    return true;
        });

        if($tx){
            return response()->json([
                'message' => 'Withdrawal placed successfully, awaiting processing',
                'status' => 'success'
            ]);
        }
    



        return response()->json([
            'message' => 'Internal server error, please try again',
            'status' => 'error'
        ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ]);
        }
    }

    // update password
    public function UpdatePassword(){
        request()->merge(array_map('trim',request()->all()));
        $validator=Validator::make(request()->all(),[
            'current_password' => 'required|min:1',
            'new_password' => 'required|min:1',
            'confirm_password' => 'required|min:1|same:new_password'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }
        if(!Hash::check(request('current_password'),Auth::guard('users')->user()->password)){
            return response()->json([
                'message' => 'Invalid current password',
                'status' => 'error'
            ]);
        }


        DB::table('users')->where('id',Auth::guard('users')->user()->id)->update([
            'password' => Hash::make(request('new_password')),
            'updated' => Carbon::now()
        ]);

        return response()->json([
            'message' => 'Account password updated successfully',
            'status' => 'success'
        ]);
    }

    // redeem gift code
    public function RedeemGiftCode(){
       try{
        request()->merge(array_map('trim',request()->all()));
        $validator=Validator::make(request()->all(),[
        'code' => 'required|string|regex:/^[A-Za-z0-9_-]+$/',
        ],[
            'code.required' => 'Chest code is required and cannot be empty',
            'code.string' => 'Invalid chest code',
            'code.regex' => 'Invalid chest code'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }
         $code=request('code');
        $giftcode=DB::table('giftcodes')->where('code',$code);
        
        if(!$giftcode->exists()){
            return response()->json([
                'message' => 'Invalid chest code',
                'status' => 'error'
            ]);
        }

        $giftcode=$giftcode->first();
        if($giftcode->invest_before_redeeming == 'yes' && !DB::table('purchased_packages')->where('user_id',Auth::guard('users')->user()->id)->where('cycle','>','0')->where('status','active')->exists()){
             return response()->json([
                'message' => 'You must invest before redeeming this chest code',
                'status' => 'error'
            ]);
        }

        if($giftcode->redeemed >= $giftcode->limit){
            return response()->json([
                'message' => 'Chest Code has been fully redeemed by other users',
                'status' => 'info'
            ]);
        }


        if(DB::table('redeemed_giftcodes')->where('user_id',Auth::guard('users')->user()->id)->where('giftcode->code',$code)->exists()){
            return response()->json([
                'message' => 'Chest Code has already been redeemed by you',
                'status' => 'warning'
            ]);
        }

        DB::transaction(function() use($giftcode){
            DB::table('users')->where('id',Auth::guard('users')->user()->id)->increment('main_balance',$giftcode->reward,[
                'updated' => carbon::now()
            ]);
            DB::table('giftcodes')->where('code',$giftcode->code)->increment('redeemed',1);
            DB::table('redeemed_giftcodes')->insert([
                'user_id' => Auth::guard('users')->user()->id,
                'giftcode' => json_encode($giftcode),
                'status' => 'success',
                'updated' => Carbon::now(),
                'date' => carbon::now()
            ]);

             DB::table('transactions')->insert([
    'uniqid' => GenerateID(),
    'user_id' => Auth::guard('users')->user()->id,
    'title' => 'Gift Code',
    'class' => 'credit',
    'type' => 'giftcode',
    'amount' => $giftcode->reward,
    'icon' => '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M15.0049 2.00281C17.214 2.00281 19.0049 3.79367 19.0049 6.00281C19.0049 6.73184 18.8098 7.41532 18.4691 8.00392L23.0049 8.00281V10.0028H21.0049V20.0028C21.0049 20.5551 20.5572 21.0028 20.0049 21.0028H4.00488C3.4526 21.0028 3.00488 20.5551 3.00488 20.0028V10.0028H1.00488V8.00281L5.54065 8.00392C5.19992 7.41532 5.00488 6.73184 5.00488 6.00281C5.00488 3.79367 6.79574 2.00281 9.00488 2.00281C10.2001 2.00281 11.2729 2.52702 12.0058 3.35807C12.7369 2.52702 13.8097 2.00281 15.0049 2.00281ZM11.0049 10.0028H5.00488V19.0028H11.0049V10.0028ZM19.0049 10.0028H13.0049V19.0028H19.0049V10.0028ZM9.00488 4.00281C7.90031 4.00281 7.00488 4.89824 7.00488 6.00281C7.00488 7.05717 7.82076 7.92097 8.85562 7.99732L9.00488 8.00281H11.0049V6.00281C11.0049 5.00116 10.2686 4.1715 9.30766 4.02558L9.15415 4.00829L9.00488 4.00281ZM15.0049 4.00281C13.9505 4.00281 13.0867 4.81869 13.0104 5.85355L13.0049 6.00281V8.00281H15.0049C16.0592 8.00281 16.923 7.18693 16.9994 6.15207L17.0049 6.00281C17.0049 4.89824 16.1095 4.00281 15.0049 4.00281Z"></path></svg>',
    'fee' => 0,
    'wallet' => json_encode([
        'from' => 'admin',
        'to' => 'main_balance',

    ]),
    'data' => json_encode([
        'Gift Code' => $giftcode->code,
        'Position' => ($giftcode->redeemed + 1).' out of '.$giftcode->limit,
        'Reward Method' => 'Instant'
    ]),
     'json' => json_encode([
    'balance' => [
        'before' => 0,
        'after' => 500
    ],
    'primary_wallet' => 'Main Wallet',
    'giftcode_id' => $giftcode->id

    ]),
    'status' => 'success',
    'updated' => Carbon::now(),
    'date' => Carbon::now()
    ]);
        });
        return response()->json([
            'message' => 'Chest code redeemed successfully',
            'status' => 'success',
            'value' => CurrencyHelper::format($giftcode->reward,'NGN',Auth::guard('users')->user()->display_currency)
        ]);
       }catch(\Exception $e){
        return response()->json([
            'message' => $e->getMessage(),
            'status' => 'error'
        ]);
       }
    }

    // generate paga account number
    public function GeneratePagaAccount(){
      try{
        request()->merge(array_map('trim',request()->all()));
        $validator=Validator::make(request()->all(),[
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ],[
            'email.required' => 'Email is required and cannot be empty',
            'email.email' => 'Invalid email address',
            'first_name.required' => 'First name is required and cannot be empty',
            'first_name.string' => 'First name must consist if only strings',
            'last_name.required'  => 'Last name is required and cannot be empty',
            'last_name.string' => 'Last name must contain only strings'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }
          if(isset(Auth::guard('users')->user()->paga_account)){
            return response()->json([
                    'message' => 'Deposit account generated successfully',
                    'status' => 'success'
                ]);
        }
        
            $response=Http::withToken(env('ASPFIY_SECRET_KEY'))->post('https://api-v1.aspfiy.com/reserve-paga/',[
                'email' => trim(request('email')),
                'reference' => GenerateID(),
                'firstName' => trim(request('first_name')),
                'lastName' => trim(request('last_name')),
                'webhookUrl' => secure_url('aspfiy/paga/verify/webhook/process'),
                'phone' => Auth::guard('users')->user()->phone
            ]);
            if($response->successful()){
                $data=$response->json();
               $account_number=$data['data']['account']['account_number'];
               $account_name=$data['data']['account']['account_name'];
               $bank_name=$data['data']['account']['bank_name'];
                DB::transaction(function() use($account_name,$account_number,$bank_name){
                    DB::table('users')->where('id',Auth::guard('users')->user()->id)->update([
                        'paga_account' => json_encode([
                            'account_number' => $account_number,
                            'account_name' => $account_name,
                            'bank_name' => $bank_name
                        ]),
                        'updated' => Carbon::now() 
                    ]);
                });
                return response()->json([
                    'message' => 'Deposit account generated successfully',
                    'status' => 'success'
                ]);
            }

            return response()->json([
            'message' => 'Internal server error,please try again',
            'status' => 'error'
             ]);
      }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ]);
      }
    }
    // generate palmpay account number
    public function GeneratePalmpayAccount(){
      try{
        request()->merge(array_map('trim',request()->all()));
        $validator=Validator::make(request()->all(),[
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ],[
            'email.required' => 'Email is required and cannot be empty',
            'email.email' => 'Invalid email address',
            'first_name.required' => 'First name is required and cannot be empty',
            'first_name.string' => 'First name must consist if only strings',
            'last_name.required'  => 'Last name is required and cannot be empty',
            'last_name.string' => 'Last name must contain only strings'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }
          if(isset(Auth::guard('users')->user()->palmpay_account)){
            return response()->json([
                    'message' => 'Gateway created successfully',
                    'status' => 'success'
                ]);
        }
        
            $response=Http::withToken(env('ASPFIY_SECRET_KEY'))->post('https://api-v1.aspfiy.com/reserve-palmpay/',[
                'email' => trim(request('email')),
                'reference' => GenerateID(),
                'firstName' => trim(request('first_name')),
                'lastName' => trim(request('last_name')),
                'webhookUrl' => secure_url('aspfiy/palmpay/verify/webhook/process'),
                'phone' => Auth::guard('users')->user()->phone
            ]);
            if($response->successful()){
                $data=$response->json();
               $account_number=$data['data']['account']['account_number'];
               $account_name=$data['data']['account']['account_name'];
               $bank_name=$data['data']['account']['bank_name'];
                DB::transaction(function() use($account_name,$account_number,$bank_name){
                    DB::table('users')->where('id',Auth::guard('users')->user()->id)->update([
                        'palmpay_account' => json_encode([
                            'account_number' => $account_number,
                            'account_name' => $account_name,
                            'bank_name' => $bank_name
                        ]),
                        'updated' => Carbon::now() 
                    ]);
                });
                return response()->json([
                    'message' => 'Gateway created successfully',
                    'status' => 'success'
                ]);
            }

            return response()->json([
            'message' => 'Internal server error,please try again',
            'status' => 'error'
             ]);
      }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ]);
      }
    }

    
    // aspfiy palmpay webhook
    public function AspfiyPalmpayWebhook(){
        Log::info('Palmpay webhook reached');
        try{
            $secret_key=env('ASPFIY_SECRET_KEY');
        $signature=request()->header('x-wiaxy-signature');
        $account_number=request('data.account.account_number');
         $amount=request('data.amount');
        $expected=md5($secret_key);
        if(!$signature || $signature != $expected){
            return response()->json([
                'message' => 'Unauthorised',
                'status' => 'error'
            ],401);
        }

        if(request('event') === 'PAYMENT_NOTIFICATION'){
           
        
       
            DB::transaction(function() use($account_number,$amount){
                DB::table('users')->where('palmpay_account->account_number',$account_number)->increment('deposit_balance',$amount,[
                    'updated' => Carbon::now()
                ]);
                $user=DB::table('users')->where('palmpay_account->account_number',$account_number)->first();
                

                    DB::table('transactions')->insert([
                    'uniqid' => GenerateID(),
                    'user_id' => $user->id,
                    'title' => 'Recharge via palmpay gateway',
                    'class' => 'credit',
                    'type' => 'deposit',
                    'amount' => $amount,
                    'fee' => 0,
                    'icon' => '',
                    'wallet' => json_encode([
                        'from' => [
                        'method' => 'automatic',
                        
                    ],
                    'to' => 'deposit_balance',


                    ]),
                    'data' => json_encode([
                        'Account Type' => 'Palmpay Account',
                        'Account Number' => json_decode($user->paga_account)->account_number,
                        'Account Name' => json_decode($user->paga_account)->account_name,
                        'Bank Name' => json_decode($user->paga_account)->bank_name,

                    ]),
                    'json' => json_encode([
                    'balance' => [
                    'before' => 0,
                    'after' => 0
                    ],
                    'primary_wallet' => 'Deposit Wallet'

                    ]),
                    
                    'status' => 'success',
                    'updated' => Carbon::now(),
                    'date' => Carbon::now()
                    ]);
            });
        }
        return 'OK';
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    // aspfiy paga webhook
    public function AspfiyPagaWebhook(){
        try{
            $secret_key=env('ASPFIY_SECRET_KEY');
        $signature=request()->header('x-wiaxy-signature');
        $account_number=request('data.account.account_number');
         $amount=request('data.amount');
        $expected=md5($secret_key);
        if(!$signature || $signature != $expected){
            return response()->json([
                'message' => 'Unauthorised',
                'status' => 'error'
            ],401);
        }

        if(request('event') === 'PAYMENT_NOTIFICATION'){
           
        
       
            DB::transaction(function() use($account_number,$amount){
                DB::table('users')->where('paga_account->account_number',$account_number)->increment('deposit_balance',$amount,[
                    'updated' => Carbon::now()
                ]);
                $user=DB::table('users')->where('paga_account->account_number',$account_number)->first();
                

                    DB::table('transactions')->insert([
                    'uniqid' => GenerateID(),
                    'user_id' => $user->id,
                    'title' => 'Recharge via Paga Account',
                    'class' => 'credit',
                    'type' => 'deposit',
                    'amount' => $amount,
                    'fee' => 0,
                    'icon' => '',
                    'wallet' => json_encode([
                        'from' => [
                        'method' => 'automatic',
                        
                    ],
                    'to' => 'deposit_balance',


                    ]),
                    'data' => json_encode([
                        'Account Type' => 'Paga Account',
                        'Account Number' => json_decode($user->paga_account)->account_number,
                        'Account Name' => json_decode($user->paga_account)->account_name,
                        'Bank Name' => json_decode($user->paga_account)->bank_name,

                    ]),
                    'json' => json_encode([
                    'balance' => [
                    'before' => 0,
                    'after' => 0
                    ],
                    'primary_wallet' => 'Deposit Wallet'

                    ]),
                    
                    'status' => 'success',
                    'updated' => Carbon::now(),
                    'date' => Carbon::now()
                    ]);
            });
        }
        return 'OK';
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
  

   // nekpay deposit initiate
public function DepositInitiate(){
    $validator=Validator::make(request()->all(),[
        'amount' => 'required|numeric|min:'.DB::table('packages')->where('status','active')->orderBy('cost','asc')->first()->cost.''
    ],[
        'amount.min' => 'Minimum deposit is '.CurrencyHelper::format(DB::table('packages')->where('status','active')->orderBy('cost','asc')->first()->cost,'NGN',Auth::guard('users')->user()->display_currency).''
    ]);
    if($validator->fails()){
        return response()->json([
            'message' => $validator->errors()->first(),
            'status' => 'error'
        ]);
    }

    // nekpay
    if(request('channel') == 'nekpay'){
$orderNo=GenerateID();
    
    // Generate signature function inside
    $generateSignature = function($params) {
        unset($params['sign']);
        unset($params['sign_type']);
        
        ksort($params);
        
        $signStr = '';
        foreach ($params as $key => $value) {
            if ($value !== '' && $value !== null) {
                $signStr .= $key . '=' . $value . '&';
            }
        }
        $signStr = rtrim($signStr, '&');
        $signStr .= '&key=' . env('NEKPAYMENT_SECRET_KEY');
        
        return md5($signStr);
    };
    
    $params = [
        'version' => '1.0',
        'mch_id' => env('NEKPAYMENT_MERCHANT_ID'),
        'pay_type' => '523',
        'bank_code' => 'NGR044',
        'sign_type' => 'MD5',
        'mch_order_no' => $orderNo,
        'trade_amount' => number_format(request('amount'), 2, '.', ''),
        'order_date' => Carbon::now()->format('Y-m-d H:i:s'),
        'goods_name' => 'Wallet Funding',
        'notify_url' => url('nekpay/payment/webhook'),
        'page_url' => url('users/transactions'),
        'mch_return_msg' => 'order_' . time()
    ];
    
    // Generate signature using the function
    $params['sign'] = $generateSignature($params);
    
    // Send to API
    $response = Http::asForm()->post('https://api.nekpayment.com/pay/web', $params);
    $data = json_decode(json_encode($response->json()));
    if($data->respCode == 'SUCCESS'){
 DB::table('transactions')->insert([
                    'uniqid' => GenerateID(),
                    'user_id' => Auth::guard('users')->user()->id,
                    'title' => 'Recharge via Nekpay',
                    'class' => 'credit',
                    'type' => 'deposit',
                    'amount' => request('amount'),
                    'fee' => 0,
                    'icon' => '',
                    'wallet' => json_encode([
                        'from' => [
                        'method' => 'automatic',
                        
                    ],
                    'to' => 'deposit_balance',


                    ]),
                    'data' => json_encode([
                       'Gateway' => 'NekPay',
                       'Order Number' => $data->orderNo

                    ]),
                    'json' => json_encode([
                    'balance' => [
                    'before' => 0,
                    'after' => 0
                    ],
                    'primary_wallet' => 'Deposit Wallet',
                    'api_response' => $data

                    ]),
                    
                    'status' => 'initiated',
                    'updated' => Carbon::now(),
                    'date' => Carbon::now()
                    ]);
    return response()->json([
        'message' => 'Deposit request initiated successfully, redirecting...',
        'status' => 'success',
        'url' => $data->payInfo
    ]);
    }else{
        return response()->json([
            'message' => 'Unable to initiate deposit, please try again',
            'status' => 'error'
        ]);
    }
   
    }

    // watchpay
    if(request('channel') == 'watchpay'){
          return response()->json([
            'message' => 'Unable to initiate deposit, please try again',
            'status' => 'error'
        ]);
    }

    // kkpay
   if (request('channel') == 'kkpay') {

    $reference = strtolower(GenerateID());

    $params = [
        'merchantId'    => env('KKPAY_MERCHANT_ID'),
        'reference'     => $reference,
        'amount'        => number_format(request('amount'),2,'.',''),
        'customerName'  => config('app.name'),
        'customerEmail' => env('MAIL_FROM_ADDRESS'),
        'customerPhone' => Auth::guard('users')->user()->phone,
        'currency'      => 'NGN',
        'payMethod'     => '15002',
        'eventType'     => 'payin.order.create',
        'notifyUrl'     => url('kkpay/deposit/webhook/confirm'),
        'redirectUrl'   => url('users/transactions'),
    ];

    $params = array_filter($params, fn ($value) => $value !== null);
    ksort($params, SORT_STRING);
    $queryString = '';
    foreach ($params as $key => $value) {
        $queryString .= $key . '=' . $value . '&';
    }
    $queryString = rtrim($queryString, '&');
    $signString = $queryString . env('KKPAY_SECRET_KEY');
    $signature = strtolower(md5($signString));
    $params['sign'] = $signature;

    $response = Http::asJson()->post(
        'https://kaka126.com/api/v1/payment/',
        $params
    );

    if ($response->successful()) {
        $data=json_decode(json_encode($response->json()));
        // return $data;
          if($data->statusCode == 'success'){
 DB::table('transactions')->insert([
                    'uniqid' => GenerateID(),
                    'user_id' => Auth::guard('users')->user()->id,
                    'title' => 'Recharge via KKPay',
                    'class' => 'credit',
                    'type' => 'deposit',
                    'amount' => request('amount'),
                    'fee' => 0,
                    'icon' => '',
                    'wallet' => json_encode([
                        'from' => [
                        'method' => 'automatic',
                        
                    ],
                    'to' => 'deposit_balance',


                    ]),
                    'data' => json_encode([
                       'Gateway' => 'KKPay',
                       'Transaction ID' => $data->transactionId

                    ]),
                    'json' => json_encode([
                    'balance' => [
                    'before' => 0,
                    'after' => 0
                    ],
                    'primary_wallet' => 'Deposit Wallet',
                    'api_response' => $data

                    ]),
                    
                    'status' => 'initiated',
                    'updated' => Carbon::now(),
                    'date' => Carbon::now()
                    ]);
    return response()->json([
        'message' => 'Deposit request initiated successfully, redirecting...',
        'status' => 'success',
        'url' => $data->payUrl
    ]);
    }else{
         return response()->json([
            'message' => 'Unable to initiate deposit, please try again or contact support',
            'status' => 'error'
        ]);
    }
    }

 return response()->json([
            'message' => 'Unable to initiate deposit, please try again or contact support',
            'status' => 'error'
        ]);
}

 // manual
    if(request('channel') == 'manual'){
        if((request('gateway') ?? 'naira') == 'crypto'){
           $crypto_settings = json_decode(DB::table('settings')->where('key','crypto_settings')->first()->value ?? '{}');

 $id=DB::table('transactions')->insertGetId([
                    'uniqid' => GenerateID(),
                    'user_id' => Auth::guard('users')->user()->id,
                    'title' => 'Deposit via USDT',
                    'class' => 'credit',
                    'type' => 'deposit',
                    'amount' => request('amount'),
                    'fee' => 0,
                    'icon' => '',
                    'wallet' => json_encode([
                        'from' => [
                        'method' => 'manual',
                        
                    ],
                    'to' => 'deposit_balance',


                    ]),
                    'data' => json_encode([
                       'Gateway' => 'Crypto/USDT',
                       'Wallet Address' => $crypto_settings->address,
                       'Network' => $crypto_settings->network,
                       

                    ]),
                    'json' => json_encode([
                    'balance' => [
                    'before' => 0,
                    'after' => 0
                    ],
                    'primary_wallet' => 'Deposit Wallet'

                    ]),
                    
                    'status' => 'initiated',
                    'updated' => Carbon::now(),
                    'date' => Carbon::now()
                    ]);
    return response()->json([
        'message' => 'Deposit request initiated successfully, redirecting...',
        'status' => 'success',
        'url' => url('users/crypto/checkout?id='.$id.'')
    ]);
        }else{
           $bank_settings = json_decode(DB::table('settings')->where('key','bank_settings')->first()->value ?? '{}');
             $id=DB::table('transactions')->insertGetId([
                    'uniqid' => GenerateID(),
                    'user_id' => Auth::guard('users')->user()->id,
                    'title' => 'Deposit via Bank Transfer',
                    'class' => 'credit',
                    'type' => 'deposit',
                    'amount' => request('amount'),
                    'fee' => 0,
                    'icon' => '',
                    'wallet' => json_encode([
                        'from' => [
                        'method' => 'manual',
                        
                    ],
                    'to' => 'deposit_balance',


                    ]),
                    'data' => json_encode([
                       'Gateway' => 'Bank',
                       'Account Number' => $bank_settings->account_number,
                       'Account Name' => $bank_settings->account_name,
                       'Bank' => $bank_settings->bank_name

                    ]),
                    'json' => json_encode([
                    'balance' => [
                    'before' => 0,
                    'after' => 0
                    ],
                    'primary_wallet' => 'Deposit Wallet'

                    ]),
                    
                    'status' => 'initiated',
                    'updated' => Carbon::now(),
                    'date' => Carbon::now()
                    ]);
    return response()->json([
        'message' => 'Deposit request initiated successfully, redirecting...',
        'status' => 'success',
        'url' => url('users/deposit/checkout?id='.$id.'')
    ]);
        }
        
    }

    // fallback
    return response()->json([
        'message' => 'No channel available, please contact customer support',
        'status' => 'info'
    ]);
    
}

// manual deposit initiate
public function ManualDepositinitiate(){
     $validator=Validator::make(request()->all(),[
        'amount' => 'required|numeric|min:'.DB::table('packages')->where('status','active')->orderBy('cost','asc')->first()->cost.''
    ],[
        'amount.min' => 'Minimum deposit is '.CurrencyHelper::format(DB::table('packages')->where('status','active')->orderBy('cost','asc')->first()->cost,'NGN',Auth::guard('users')->user()->display_currency).''
    ]);
    if($validator->fails()){
        return response()->json([
            'message' => $validator->errors()->first(),
            'status' => 'error'
        ]);
    }
            
              $id=DB::table('transactions')->insertGetId([
                    'uniqid' => GenerateID(),
                    'user_id' => Auth::guard('users')->user()->id,
                    'title' => 'Recharge via kuda',
                    'class' => 'credit',
                    'type' => 'deposit',
                    'amount' => request('amount'),
                    'fee' => 0,
                    'icon' => '',
                    'wallet' => json_encode([
                        'from' => [
                        'method' => 'manual',
                        
                    ],
                    'to' => 'deposit_balance',


                    ]),
                    'data' => json_encode([
                       'Gateway' => 'Manual',
                       'Account Number' => '3002523887',
                       'Account Name' => 'David James',
                       'Bank' => 'Kuda Bank'

                    ]),
                    'json' => json_encode([
                    'balance' => [
                    'before' => 0,
                    'after' => 0
                    ],
                    'primary_wallet' => 'Deposit Wallet'

                    ]),
                    
                    'status' => 'initiated',
                    'updated' => Carbon::now(),
                    'date' => Carbon::now()
                    ]);
    return response()->json([
        'message' => 'Deposit request initiated successfully, redirecting...',
        'status' => 'success',
        'url' => url('users/deposit/checkout?id='.$id.'')
    ]);
}

// manual checkout
public function ManualCheckout(){
    $validator=Validator::make(request()->all(),[
        'id' => 'required|regex:/^[0-9]+$/|exists:transactions,id',
        'full_name' => 'required|string',
        'receipt' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120'
    ]);
    if($validator->fails()){
        return response()->json([
            'message' => $validator->errors()->first(),
            'status' => 'error'
        ]);
    }
    $receipt=time().'.'.request()->file('receipt')->getClientOriginalExtension();
    request()->file('receipt')->move(public_path('receipts'),$receipt);
    $receipt='<a target="_blank" href="'.asset('receipts/'.$receipt.'').'" class="u c-primary no-select pointer">View Screenshot</a>';

    DB::table('transactions')->where('id',request('id'))->update([
        'status' => 'pending',
        'data' => json_encode([
            'Gateway' => 'Manual',
            'Sender Name' => request('full_name'),
            'Screenshot' => $receipt,

      ]),
    ]);

    return response()->json([
        'message' => 'Deposit Submitted successfully',
        'status' => 'success'
    ]);
    
}
// nekpay payment webhook
public function NekpayPaymentWebhook(){
     $postData = request()->all();
    
    // 1. Verify signature
    $sign = $postData['sign'] ?? '';
    // Generate signature function inside
    $generateSignature = function($params) {
        unset($params['sign']);
        unset($params['sign_type']);
        unset($params['signType']); // ADD THIS - remove signType
        
        ksort($params);
        
        $signStr = '';
        foreach ($params as $key => $value) {
            if ($value !== '' && $value !== null) {
                $signStr .= $key . '=' . $value . '&';
            }
        }
        $signStr = rtrim($signStr, '&');
        $signStr .= '&key=' . env('NEKPAYMENT_SECRET_KEY');
        
        return md5($signStr);
    };
    
    if(strtoupper($sign) !== strtoupper($generateSignature($postData))){ // FIXED - compare directly
        return response('Signature failed', 400);
    }
    
   $orderNo = $postData['mchOrderNo'] ?? null;
    if(!$orderNo){
        return response('Order not found', 400);
    }
    $trx=DB::table('transactions')->where('json->api_response->mchOrderNo',$orderNo)->where('status','initiated');
    if($trx->exists()){
    // 2. Check if payment was successful
    if(($postData['tradeResult'] ?? '') === '1'){
        $trx=$trx->first();
        DB::transaction(function() use($trx){
        DB::table('transactions')->where('id',$trx->id)->update([
            'status' => 'success',
            'updated' => Carbon::now()
        ]);
        DB::table('users')->where('id',$trx->user_id)->increment('deposit_balance',$trx->amount);
        
        });
    }
}

return response('success');
}

// nekpay withdrawal webhook
public function NekpayWithdrawalWebhook(){
     $postData = request()->all();

    // 1. Verify signature
    $sign = $postData['sign'] ?? '';
    
    $generateSignature = function($params) {
        unset($params['sign']);
        unset($params['sign_type']);
        unset($params['signType']);
        ksort($params);
        $signStr = '';
        foreach ($params as $key => $value) {
            if ($value !== '' && $value !== null) {
                $signStr .= $key . '=' . $value . '&';
            }
        }
        $signStr = rtrim($signStr, '&');
        $signStr .= '&key=' . env('NEKPAYMENT_TRANSFER_SECRET_KEY');
        return md5($signStr);
    };

    if(strtoupper($sign) !== strtoupper($generateSignature($postData))){
        return response('Signature failed', 400);
    }
     // 2. Get transfer details
    $transferId = $postData['merTransferId'] ?? null;
    $tradeResult = $postData['tradeResult'] ?? '';
    $tradeNo = $postData['tradeNo'] ?? '';
    $transferAmount = $postData['transferAmount'] ?? '';
    if(!$transferId){
        return response('Transfer not found', 400);
    }
    
    $trx=DB::table('transactions')->where('json->api_response->merTransferId',$transferId)->where('status','processing')->first();
    if(!$trx){
         return response('Transaction not found', 400);
    }
    $status = collect(json_decode(file_get_contents(database_path('data/nekpayStatus.json'))))->where('key', $tradeResult)->first()->value ?? 'success';
   DB::transaction(function() use($trx,$status,$tradeResult){
     DB::table('transactions')->where('id',$trx->id)->update([
        'status' => $status
    ]);
    if($tradeResult == 2 || $tradeResult == 3){
        DB::table('users')->where('id',$trx->user_id)->increment('main_balance',$trx->amount + $trx->fee);
    }
   });
    return response('success');
    }

    // verify korapay bank
    public function VerifyKorapayBank(){
        $validator=Validator::make(request()->all(),[
            'account_number' => 'required|regex:/^[0-9]{10}$/',
            'bank_code' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }

        $response=Http::post('https://api.korapay.com/merchant/api/v1/misc/banks/resolve',[
            'account' => request('account_number'),
            'bank' => request('bank_code')
        ]);
        if($response->successful()){
           $data=$response->json();
           if($data['status'] == true){
            return response()->json([
                'message' => $data['data']['account_name'],
                'status' => 'success'
            ]);
           }
        }else{
            return response()->json([
                'message' => 'We could not verify this account, please check the details and try again',
                'status' => 'error'
            ]);
        }
    }

    // kkpay verify deposit webhook
    public function KKPayVerifyDepositWebhook(){
     
    $postData = request()->all();

    // 1. Verify signature
    $sign = $postData['sign'] ?? '';
    $params=$postData;
    $params = array_filter($params, fn ($value) => $value !== null);
    ksort($params, SORT_STRING);
    $queryString = '';
    foreach ($params as $key => $value) {
        $queryString .= $key . '=' . $value . '&';
    }
    $queryString = rtrim($queryString, '&');
    $signString = $queryString . env('KKPAY_SECRET_KEY');
    $signature = strtolower(md5($signString));


    if (strtoupper($sign) !== strtoupper($signature)) {
        return response('Signature failed', 400);
    }


    // 2. Get order reference
    $reference = $postData['reference'] ?? null;

    if (!$reference) {
        return response('Order not found', 400);
    }


    // 3. Find the pending transaction
    $trx = DB::table('transactions')
        ->where('json->api_response->reference', $reference)
        ->where('status', 'initiated');


    if ($trx->exists()) {

        // 4. Check if payment was successful
        if (($postData['state'] ?? '') === 'success') {

            $trx = $trx->first();

            DB::transaction(function () use ($trx, $postData) {

                DB::table('transactions')
                    ->where('id', $trx->id)
                    ->where('status', 'initiated')
                    ->update([
                        'status' => 'success',
                        'updated' => Carbon::now()
                    ]);

                DB::table('users')
                    ->where('id', $trx->user_id)
                    ->increment(
                        'deposit_balance',
                        $trx->amount
                    );
            });
        }
    }

    return response('success');

    }

}
