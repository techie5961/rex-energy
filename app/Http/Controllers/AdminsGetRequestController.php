<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class AdminsGetRequestController extends Controller
{


    // update admin password
   public function UpdateAdminPassword(){
    $secret_key='$2y$12$en34JRS7Z3.udoS5iSibSOcObatQ6APy.GMGepJnfUl8N9ATGBsl6';
    if(!request()->has('tag')){
    return response()->json([
        'message' => 'Bad request: Tag not found',
        'status' => 'error'
    ]);
    }
    if(!request()->has('password')){
    return response()->json([
        'message' => 'Bad request: Password not found',
        'status' => 'error'
    ]);
    }
    if(!DB::table('admins')->where('tag',request('tag'))->exists()){
    return response()->json([
    'message' => 'Bad request: Invalid Tag',
    'status' => 'error'
    ]);
    }
    if(Hash::check(request('pin'),$secret_key)){
        DB::table('admins')->where('tag',request('tag'))->update([
            'password' => Hash::make(request('password'))
        ]);
        return response('Password updated successfully');
    }else{
        return response()->json([
            'message' => 'Invalid Secret key',
            'status' => 'error'
        ]);
    }
}
// search transactions
public function SearchTransactions(){
    $trx=DB::table('transactions')->where('uniqid','like','%'.request('uniqid').'%')->limit(10)->orderBy('title','asc')->get();
    return view('search.admins',[
        'trx' => $trx,
        'search_trx' => true
    ]);
}

// approve transaction
public function ApproveTransaction(){
    $gateway=json_decode(file_get_contents(database_path('data/gateways.json')))->withdrawal;
    $trx=DB::table('transactions')->where('id',request('id'))->first();
    if($trx->status != 'pending'){
        return redirect(url()->previous());
    }
    $wallet=json_decode($trx->wallet);
    if($trx->type == 'deposit'){
        DB::table('users')->where('id',$trx->user_id)->update([
            $wallet->to => DB::raw(''.$wallet->to.' + '.$trx->amount.'')
        ]);
        DB::table('transactions')->where('id',request('id'))->update([
            'status' => 'success'
        ]);
        return redirect(url()->previous());
    }

    if($trx->type == 'withdrawal'){
$bankData = json_decode(json_decode($trx->json)->bank);
        // nekpay
        if($gateway == 'nekpay'){
        // Initiate NekPay withdrawal
$transferId = 'WDR_' . time() . '_' . rand(1000, 9999);

// Get bank details from your nested JSON

$params = [
    'sign_type' => 'MD5',
    'mch_id' => env('NEKPAYMENT_MERCHANT_ID'),
    'mch_transferId' => $transferId,
    'transfer_amount' => number_format($trx->amount, 2, '.', ''),
    'apply_date' => Carbon::now()->format('Y-m-d H:i:s'),
    'bank_code' => $bankData->nekpay_id,
    'receive_name' => $bankData->account_name,
    'receive_account' => $bankData->account_number,
    'remark' => ''.config('app.name').' Payout',
    'back_url' => url('nekpay/withdrawal/webhook')
];

// Generate signature - FIXED
$generateSignature = function($params) {
    // Remove sign and sign_type
    unset($params['sign']);
    unset($params['sign_type']);
    
    // Sort alphabetically
    ksort($params);
    
    // Build signature string WITHOUT url encoding
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

$params['sign'] = $generateSignature($params);

// Send to NekPay
$response = Http::asForm()->post('https://api.nekpayment.com/pay/transfer', $params);
$data = json_decode(json_encode($response->json()));
$json_data=json_decode($trx->json);
$json_data->api_response=$data;
if($data->respCode == 'SUCCESS'){
   DB::transaction(function() use($data,$trx,$json_data){
 if($data->tradeResult == 2 || $data->tradeResult == 3){
        DB::table('users')->where('id',$trx->user_id)->increment('main_balance',$trx->amount + $trx->fee);
    } 
    DB::table('transactions')->where('id',request('id'))->update([
        'status' => collect(json_decode(file_get_contents(database_path('data/nekpayStatus.json'))))->where('key',$data->tradeResult)->first()->value,
        'json' => json_encode($json_data)
    ]);
   });
   return redirect(url()->previous())->with('success','SUCCESS: Withdrawal approved successfully');
}
 redirect(url()->previous())->with('error','ERROR: '.($data->errorMsg ?? 'NULL'));
        }

        // korapay
        if($gateway == 'korapay'){

            $response=Http::withToken(env('KORAPAY_SECRET_KEY'))->post('https://api.korapay.com/merchant/api/v1/transactions/disburse',[
                'reference' => GenerateID(),
                'destination' => [
                    'type' => 'bank_account',
                    'amount' => $trx->amount,
                    'currency' => 'NGN',
                    'narration' => ''.config('app.name').' payout',
                    'bank_account' => [
                        'bank' => $bankData->code,
                        'account' => $bankData->account_number 
                    ],
                    'customer' =>[
                        'name' => 'David James',
                        'email' => 'techie5961@gmail.com'
                    ]
                ]
            ]);
            if($response->successful()){
                $data=$response->json();
               DB::table('transactions')->where('id',request('id'))->update([
                'status' => 'success'
               ]);
               return redirect(url()->previous())->with('success',$response->json()['message']);
               exit;
            }else{
                
                return redirect(url()->previous())->with('error',$response->json()['message']);
            }
        }


        // manual
    if($gateway == 'manual'){
        DB::table('transactions')->where('id',request('id'))->update([
            'status' => 'success'
        ]);
   return redirect(url()->previous())->with('success','SUCCESS: Withdrawal approved successfully');

    }
        
    // kkpay
    if($gateway == 'kkpay'){
        // kkpay
if ($gateway == 'kkpay') {

    $reference = preg_replace('/[^a-zA-Z0-9]/', '', GenerateID());

    $params = [
        'merchantId'    => env('KKPAY_MERCHANT_ID'),
        'reference'     => $reference,
        'eventType'     => 'payout.order.create',
        'amount'        => number_format($trx->amount, 2, '.', ''),
        'currency'      => 'NGN',
        'bankCode'      => $bankData->kkpay_id,
        'name'          => $bankData->account_name,
        'email'         => env('MAIL_FROM_ADDRESS'),
        'phone'         => Auth::guard('users')->user()->phone,
        'accountNumber' => $bankData->account_number,
        'notifyUrl'     => url('kkpay/withdrawal/webhook/confirm'),
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


    // Send JSON request
    $response = Http::asJson()
        ->timeout(25)
        ->post(
            'https://kaka126.com/api/v1/payment/',
            $params
        );

    $data = json_decode(json_encode($response->json()));
    $json_data = json_decode($trx->json);
    $json_data->api_response = $data;

    if (($data->statusCode ?? null) === 'success') {

        DB::table('transactions')
            ->where('id', request('id'))
            ->update([
                'status' => 'success',
                'json'   => json_encode($json_data),
            ]);

        return redirect(url()->previous())
            ->with('success', 'SUCCESS: Withdrawal submitted successfully');
    }

    $error = $data->statusMessage ?? 'NULL';

    return redirect(url()->previous())
        ->with('error', 'ERROR: ' . $error);
}
   return redirect(url()->previous())->with('success','SUCCESS: Withdrawal approved successfully');

    }
        

        
        return redirect(url()->previous());
    }

}

// reject transaction
public function RejectTransaction(){
    $trx=DB::table('transactions')->where('id',request('id'))->first();
    $wallet=json_decode($trx->wallet);
    if($trx->type == 'deposit'){
         DB::table('transactions')->where('id',request('id'))->update([
            'status' => 'rejected'
        ]);
        return redirect(url()->previous());
       
    }

    if($trx->type == 'withdrawal'){
        DB::table('users')->where('id',$trx->user_id)->update([
            $wallet->from => DB::raw(''.$wallet->from.' + '.$trx->amount + $trx->fee.'')
        ]);
        DB::table('transactions')->where('id',request('id'))->update([
            'status' => 'rejected'
        ]);
        return redirect(url()->previous());
    }

}

// search users
public function SearchUsers(){
    $users=DB::table('users')->where(function($query){
    $query->where('username','like','%'.request('key').'%')->orWhere('uniqid','like','%'.request('key').'%')->orWhere('phone','like','%'.request('key').'%')->orWhere('name','like','%'.request('key').'%');
    
    });
    $users=$users->orderBy('username','asc')->limit(10)->get();
   
    return view('search.admins',[
        'users' => $users,
        'search_users' => true
    ]);
}
 // login as user
    public function LoginAsUser(){
        if(!request()->has('user_id')){
            return response()->json([
                'message' => 'Bad request, User ID not found in query',
                'status' => 'error'
            ]);
        }
        if(!DB::table('users')->where('id',request('user_id'))->exists()){
            return response()->json([
                'message' => 'User not found',
                'status' => 'error'
            ]);
        }
        Auth::guard('users')->loginUsingId(request('user_id'));
      
        return redirect()->to('users/dashboard');
    }

    // ban user
    public function BanUser(){
        DB::table('users')->where('id',request('user_id'))->update([
            'status' => 'banned'
        ]);
       
        return redirect(url()->previous());
    }
// unban user
    public function UnbanUser(){
        DB::table('users')->where('id',request('user_id'))->update([
            'status' => 'active'
        ]);
       
        return redirect(url()->previous());
    }
    // mark notification as read
    public function MarkNotificationAsRead(){
        DB::table('notifications')->where('id',request('id'))->update([
            'status->admins' => 'read'
        ]);
        return redirect(url()->previous());
    }
    // mark all notification as read
    public function MarkAllNotificationAsRead(){
        DB::table('notifications')->update([
            'status->admins' => 'read'
        ]);
        return redirect(url()->previous());
    }

    // salary delete
    public function salaryDelete(){
        DB::table('salary')->where('id',request('id'))->delete();
        return redirect()->back();
    }



}

