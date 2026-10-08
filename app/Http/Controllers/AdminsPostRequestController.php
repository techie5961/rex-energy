<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Generator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AdminsPostRequestController extends Controller
{
    // login
    public function Login(){
         
        if(!DB::table('admins')->where('tag',request('id'))->exists()){
            return response()->json([
                'message' => 'Admin not found',
                'status' => 'error'
            ]);
        }
       $admin= DB::table('admins')->where('tag',request('id'))->first();
       if(!Hash::check(request('password'),$admin->password)){
        return response()->json([
            'message' => 'Incorrect password',
            'status' => 'error'
        ]);
       }
       Auth::guard('admins')->loginUsingId($admin->id,true);
       return response()->json([
        'message' => 'Login successfull,redirecting....',
        'status' => 'success'
       ]);
    }

    // credit user
    public function CreditUser(){
        $user=DB::table('users')->where('id',request('user_id'))->first();
        DB::table('users')->where('id',request('user_id'))->update([
            request('wallet') => DB::raw(''.request('wallet').'  + '.request('amount').''),
            'updated' => Carbon::now()
        ]);
        
        if(request()->has('title')){
             DB::table('transactions')->insert([
    'uniqid' => strtoupper(Str::random(10)),
    'user_id' => request('user_id'),
    'title' => ucwords(strtolower(request('title'))),
    'class' => 'credit',
    'type' => 'credit_alert',
    'amount' => request('amount'),
    'wallet' => json_encode([
        'from' => 'admin',
        'to' => request('wallet'),

    ]),
     'json' => json_encode([
    'balance' => [
        'before' => $user->{request('wallet')},
        'after' => $user->{request('wallet')} + request('amount')
    ],
    'primary_wallet' => collect(Wallets())->where('key',request('wallet'))->first()->name

    ]),
    'status' => 'success',
    'updated' => Carbon::now(),
    'date' => Carbon::now()
    ]);
   
        }

         return response()->json([
        'message' => 'User Creditted Successfully',
        'status' => 'success'
    ]);
    }

    // debit user
    public function DebitUser(){
        $user=DB::table('users')->where('id',request('user_id'))->first();
        DB::table('users')->where('id',request('user_id'))->update([
            request('wallet') => DB::raw(''.request('wallet').'  - '.request('amount').''),
            'updated' => Carbon::now()
        ]);
        
        if(request()->has('title')){
             DB::table('transactions')->insert([
    'uniqid' => strtoupper(Str::random(10)),
    'user_id' => request('user_id'),
    'title' => ucwords(strtolower(request('title'))),
    'class' => 'debit',
    'type' => 'debit_alert',
    'amount' => request('amount'),
    'wallet' => json_encode([
        'from' => request('wallet'),
        'to' => '',

    ]),
     'json' => json_encode([
    'balance' => [
        'before' => $user->{request('wallet')},
        'after' => $user->{request('wallet')} - request('amount')
    ],
    'primary_wallet' => collect(Wallets())->where('key',request('wallet'))->first()->name

    ]),
    'status' => 'success',
    'updated' => Carbon::now(),
    'date' => Carbon::now()
    ]);
   
        }

         return response()->json([
        'message' => 'User Creditted Successfully',
        'status' => 'success'
    ]);
    }
    // general settings
    public function GeneralSettings(){
        $message='General settings updated success';
        $key='general_settings';
        $value=[
        'email_verification' => request('email_verification'),
        'maintenance_mode' => request('maintenance_mode')
        ];
       if(DB::table('settings')->where('key',$key)->exists()){
     DB::table('settings')->where('key',$key)->update([
             'value' => json_encode($value),
            'updated' => Carbon::now()
        ]);
       }else{
         DB::table('settings')->insert([
            'key' => $key,
            'value' => json_encode($value),
            'status' => 'active',
            'updated' => Carbon::now(),
            'date' => Carbon::now()
        ]);
       }
        

        return response()->json([
            'message' => $message,
            'status' => 'success'
        ]);
    }
     // social settings
    public function SocialSettings(){
        $message='Social settings updated success';
        $key='social_settings';
        $value=[
        'whatsapp_community' => request('whatsapp_community') ?? '',
        'telegram_community' => request('telegram_community') ?? '',
        'site_notification' => request('site_notification') ?? '',
        'whatsapp_number' => request('whatsapp_number') ?? '',
        'telegram_username' => request('telegram_username') ?? '',
        'customer_service' => request('customer_service') ?? '',
        'marquee_notification' => request('marquee_notification','')
        ];
       if(DB::table('settings')->where('key',$key)->exists()){
     DB::table('settings')->where('key',$key)->update([
             'value' => json_encode($value),
            'updated' => Carbon::now()
        ]);
       }else{
         DB::table('settings')->insert([
            'key' => $key,
            'value' => json_encode($value),
            'status' => 'active',
            'updated' => Carbon::now(),
            'date' => Carbon::now()
        ]);
       }
        

        return response()->json([
            'message' => $message,
            'status' => 'success'
        ]);
    }
    
   // finance settings
    public function FinanceSettings(){
        $validator=Validator::make(request()->all(),[
            'welcome_bonus' => 'required|regex:/^[1-9][0-9]*$/',
            'minimum_withdrawal' => 'required|regex:/^[1-9][0-9]*$/',
            'maximum_withdrawal' => 'required|regex:/^[1-9][0-9]*$/',
            'withdrawal_start_time' => 'required',
            'withdrawal_end_time' => 'required',
            'withdrawal_fee' => 'required|regex:/^[1-9][0-9]*$/',
            'withdrawal_portal' => 'required|string',
            'max_daily_withdrawal' => 'required|regex:/^[1-9][0-9]*$/'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }
        $message='Finance settings updated success';
        $key='finance_settings';
        $value=[
            'welcome_bonus' => request('welcome_bonus'),
        'withdrawal' => [
            'minimum' => request('minimum_withdrawal'),
            'maximum' => request('maximum_withdrawal'),
            'fee' => request('withdrawal_fee'),
            'portal' => request('withdrawal_portal'),
            'daily' => request('max_daily_withdrawal'),
            'start_time' => request('withdrawal_start_time'),
            'end_time' => request('withdrawal_end_time'),
        ]
        ];
       if(DB::table('settings')->where('key',$key)->exists()){
     DB::table('settings')->where('key',$key)->update([
             'value' => json_encode($value),
            'updated' => Carbon::now()
        ]);
       }else{
         DB::table('settings')->insert([
            'key' => $key,
            'value' => json_encode($value),
            'status' => 'active',
            'updated' => Carbon::now(),
            'date' => Carbon::now()
        ]);
       }
        

        return response()->json([
            'message' => $message,
            'status' => 'success'
        ]);
    }

    // add package
    public function AddPackage(){
        $photo=strtolower(GenerateID()).'.'.request()->file('photo')->getClientOriginalExtension();
        if(request()->file('photo')->move(public_path('packages'),$photo)){
             DB::table('packages')->insert([
            'uniqid' => GenerateID(),
            'photo' => $photo,
            'name' => request('name'),
            'cost' => request('cost'),
            'earning' => request('earning'),
            'validity' => request('validity'),
            'available' => request('available'),
            'vip_level' => request('vip_level'),
            'purchase_limit' => request('purchase_limit'),
            'status' => 'active',
            'updated' => Carbon::now(),
            'date' => Carbon::now()
        ]);
        return response()->json([
            'message' => 'Product added successfully',
            'status' => 'success'
        ]);
        } 
       
        
    }

     // add package
    public function EditPackage(){
        $photo=request('initial_photo');
        if(request()->hasFile('photo')){
         $photo=strtolower(GenerateID()).'.'.request()->file('photo')->getClientOriginalExtension();
         request()->file('photo')->move(public_path('packages'),$photo);
        }
       
        
             DB::table('packages')->where('id',request('id'))->update([
            'photo' => $photo,
            'name' => request('name'),
            'cost' => request('cost'),
            'earning' => request('earning'),
            'validity' => request('validity'),
            'available' => request('available'),
            'vip_level' => request('vip_level'),
            'purchase_limit' => request('purchase_limit'),'status' => 'active',
            'updated' => Carbon::now()
        ]);
        return response()->json([
            'message' => 'Product editted successfully',
            'status' => 'success'
        ]);
        
       
    }

    // referral settings
    public function ReferralSettings(){
         $message='Referral settings updated success';
        $key='referral_settings';
        $value=[
        'level_1' => request('level_1') ?? 0,
        'level_2' => request('level_2') ?? 0,
        'level_3' => request('level_3') ?? 0
        ];
       if(DB::table('settings')->where('key',$key)->exists()){
     DB::table('settings')->where('key',$key)->update([
             'value' => json_encode($value),
            'updated' => Carbon::now()
        ]);
       }else{
         DB::table('settings')->insert([
            'key' => $key,
            'value' => json_encode($value),
            'status' => 'active',
            'updated' => Carbon::now(),
            'date' => Carbon::now()
        ]);
       }
        

        return response()->json([
            'message' => $message,
            'status' => 'success'
        ]);
    }
    
    // create gift code
    public function CreateGiftCode(){
        $code=Str::ulid();
        $reward=request('reward');
        $limit=request('limit');
        if($reward <= 0){
            return response()->json([
                'message' => 'Code Reward must be greater than &#8358;0',
                'status' => 'error'
            ]);
        }
         if($limit <= 0){
            return response()->json([
                'message' => 'Code limit must be greater than 0 users',
                'status' => 'error'
            ]);
        }
        DB::table('giftcodes')->insert([
            'code' => $code,
            'reward' => $reward,
            'limit' => $limit,
            'invest_before_redeeming' => request('invest_before_redeeming'),
            'updated' => Carbon::now(),
            'date' => Carbon::now()
        ]);
        return response()->json([
            'message' => 'Gift code created successfully',
            'status' => 'success'
        ]);
    }
    // edit gift code
    public function EditGiftCode(){
        $reward=request('reward');
        $limit=request('limit');
        if($reward <= 0){
            return response()->json([
                'message' => 'Code Reward must be greater than &#8358;0',
                'status' => 'error'
            ]);
        }
         if($limit <= 0){
            return response()->json([
                'message' => 'Code limit must be greater than 0 users',
                'status' => 'error'
            ]);
        }
        DB::table('giftcodes')->where('id',request('id'))->update([
            'reward' => $reward,
            'limit' => $limit,
            'invest_before_redeeming' => request('invest_before_redeeming'),
            'updated' => Carbon::now(),
        ]);
        return response()->json([
            'message' => 'Gift code editted successfully',
            'status' => 'success'
        ]);
    }

    // credit all promoters
    public function CreditAllPromoters(){
        $promoters=DB::table('users')->where('type','promoter')->limit(50)->get();
        foreach($promoters as $promoter){
            DB::transaction(function() use($promoter){
                DB::table('users')->where('id',$promoter->id)->increment(request('wallet'),request('amount'));
                 DB::table('transactions')->insert([
    'uniqid' => GenerateID(),
    'user_id' => $promoter->id,
    'title' => request('wallet') == 'deposit_balance' ? 'Deposit' : 'Credit from Admin',
    'class' => 'credit',
    'type' => 'admin_bonus',
    'amount' => request('amount'),
    'fee' => 0,
    'wallet' => json_encode([
        'from' => 'admin',
        'to' => request('wallet'),

    ]),
     'json' => json_encode([
    'balance' => [
        'before' => 0,
        'after' => 500
    ],
    'primary_wallet' => str_replace('_balance',' Wallet',request('wallet'))

    ]),
    'data' => json_encode([
        'Message' => 'Creditted by admin'
    ]),
    'status' => 'success',
    'updated' => Carbon::now(),
    'date' => Carbon::now()
    ]);

            });
        }

        return response()->json([
            'message' => 'All promoters creditted successfully',
            'status' => 'success'
        ]);
    }
     // credit all promoters
    public function DebitAllPromoters(){
        $promoters=DB::table('users')->where('type','promoter')->limit(50)->get();
        foreach($promoters as $promoter){
            DB::transaction(function() use($promoter){
                DB::table('users')->where('id',$promoter->id)->decrement(request('wallet'),request('amount'));
                 DB::table('transactions')->insert([
    'uniqid' => GenerateID(),
    'user_id' => $promoter->id,
    'title' => 'Debit from Admin',
    'class' => 'debit',
    'type' => 'admin_debit',
    'amount' => request('amount'),
    'fee' => 0,
    'wallet' => json_encode([
        'from' => request('wallet'),
        'to' => 'admin',

    ]),
     'json' => json_encode([
    'balance' => [
        'before' => 0,
        'after' => 500
    ],
    'primary_wallet' => str_replace('_balance',' Wallet',request('wallet'))

    ]),
    'data' => json_encode([
        'Message' => 'Debitted by admin'
    ]),
    'status' => 'success',
    'updated' => Carbon::now(),
    'date' => Carbon::now()
    ]);

            });
        }

        return response()->json([
            'message' => 'All promoters debitted successfully',
            'status' => 'success'
        ]);
    }

    // login settings
    public function LoginSettings(){
        try{
             $validator=Validator::make(request()->all(),[
            'tag' => 'required|string|unique:admins,tag',
            'current_password' => 'required|string',
            'new_password' => 'required|string',
            'confirm_password' => 'required|string|same:new_password'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }

        if(!Hash::check(request('current_password'),Auth::guard('admins')->user()->password)){
            return response()->json([
                'message' => 'Invalid current password',
                'status' => 'error'
            ]);
        }

        DB::table('admins')->where('id',Auth::guard('users')->user()->id)->update([
            'password' => Hash::make(request('new_password'))
        ]);
        return response()->json([
            'message' => 'Login settings updated successfully',
            'status' => 'success'
        ]);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ]);
        }
       
    }

    // create salary
    public function CreateSalary(){
        request()->merge(array_map('trim',request()->all()));
        $validator=Validator::make(request()->all(),[
            'referrals' => 'required|numeric|min:1|regex:/^[0-9]+$/',
            'reward' => 'required|numeric|min:1|regex:/^[0-9]+$/'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }

        DB::table('salary')->insert([
            'uniqid' => GenerateID(),
            'referrals' => request('referrals'),
            'reward' => request('reward'),
            'completed' => 0,
            'status' => 'active',
            'updated' => Carbon::now(),
            'date' => Carbon::now()
        ]);
        return response()->json([
            'message' => 'Salary created successfully',
            'status' => 'success'
        ]);
    }

    //  edit salary
    public function EditSalary(){
           request()->merge(array_map('trim',request()->all()));
        $validator=Validator::make(request()->all(),[
            'id' => 'required|regex:/^[0-9]+$/',
            'referrals' => 'required|numeric|min:1|regex:/^[0-9]+$/',
            'reward' => 'required|numeric|min:1|regex:/^[0-9]+$/'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }
         DB::table('salary')->where('id',request('id'))->update([
            'referrals' => request('referrals'),
            'reward' => request('reward'),
            'updated' => Carbon::now(),
        ]);
        return response()->json([
            'message' => 'Salary editted successfully',
            'status' => 'success'
        ]);
    }

     // manual deposit bank
    public function ManualDepositBankSettings(){
         $message='Bank settings updated success';
        $key='bank_settings';
        $value=[
        'account_number' => request('account_number'),
        'account_name' => request('account_name'),
        'bank_name' => request('bank_name')
        ];
       if(DB::table('settings')->where('key',$key)->exists()){
     DB::table('settings')->where('key',$key)->update([
             'value' => json_encode($value),
            'updated' => Carbon::now()
        ]);
       }else{
         DB::table('settings')->insert([
            'key' => $key,
            'value' => json_encode($value),
            'status' => 'active',
            'updated' => Carbon::now(),
            'date' => Carbon::now()
        ]);
       }
        

        return response()->json([
            'message' => $message,
            'status' => 'success'
        ]);
    }

     // manual deposit crypto
    public function CryptoSettings(){
         $message='Crypto settings updated success';
        $key='crypto_settings';
        $value=[
        'address' => request('address'),
        'network' => request('network')
        ];
       if(DB::table('settings')->where('key',$key)->exists()){
     DB::table('settings')->where('key',$key)->update([
             'value' => json_encode($value),
            'updated' => Carbon::now()
        ]);
       }else{
         DB::table('settings')->insert([
            'key' => $key,
            'value' => json_encode($value),
            'status' => 'active',
            'updated' => Carbon::now(),
            'date' => Carbon::now()
        ]);
       }
        

        return response()->json([
            'message' => $message,
            'status' => 'success'
        ]);
    }

    // change withdrawal gateway
    public function ChangeWithdrawalGateway(){
        $gateways=json_decode(file_get_contents(database_path('data/gateways.json')));
        $gateways->withdrawal=request('gateway');
        file_put_contents(database_path('data/gateways.json'),json_encode($gateways));
        return response()->json([
            'message' => 'Withdrawal gateway updated successfully',
            'status' => 'success'
        ]);
    }

    // change deposit gateway
    public function ChangeDepositGateway(){
          $gateways=json_decode(file_get_contents(database_path('data/gateways.json')));
        $gateways->deposit->{request('gateway')}=request('status');
        file_put_contents(database_path('data/gateways.json'),json_encode($gateways));
        return response()->json([
            'message' => 'Deposit gateway updated successfully',
            'status' => 'success'
        ]);
    }

    // reset user password
    public function ResetUserPassword(){
        $validator=Validator::make(request()->all(),[
            'user_id' => 'required|numeric|exists:users,id'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }

        DB::table('users')->where('id',Auth::guard('users')->user()->id)->update([
            'password' => Hash::make('123456')
        ]);
        return response()->json([
            'message' => 'User pasword reset successfully',
            'status' => 'success'
        ]);
    }
}
