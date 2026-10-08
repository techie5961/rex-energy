<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class UserGetRequestController extends Controller
{
    // switch currency
    public function SwitchCurrency(){
       DB::table('users')->where('id',Auth::guard('users')->user()->id)->update([
        'display_currency' => request('currency')
       ]);
       return redirect('users/dashboard');
    }

    // claim salary
    public function Claimsalary(){
        $validator=Validator::make(request()->all(),[
            'id' => 'required|regex:/^[0-9]+$/'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ]);
        }
        $salary=DB::table('salary')->where('id',request('id'))->first();
        if(DB::table('salaries')->where('user_id',Auth::guard('users')->user()->id)->where('salary->id',request('id'))->exists()){
            return response()->json([
                'message' => 'You have already claimed this salary',
                'status' => 'error'
            ]);
        }
        
            $refs=DB::table('users')->where('ref',Auth::guard('users')->user()->id)->whereIn('id',function($q){
                $q->select('user_id')->from('purchased_packages')->distinct();
            })->count();
            // $refs=100;
        if($refs < $salary->referrals){
            return response()->json([
                'message' => 'You are not yet qualified for this salary, keep inviting to earn this salary',
                'status' => 'error'
            ]);
        }
        DB::transaction(function() use($salary){
            DB::table('users')->where('id',Auth::guard('users')->user()->id)->increment('main_balance',$salary->reward);
        
             DB::table('transactions')->insert([
    'uniqid' => GenerateID(),
    'user_id' => Auth::guard('users')->user()->id,
    'title' => 'Salary earning',
    'class' => 'credit',
    'type' => 'salary',
    'amount' => $salary->reward,
    'fee' => 0,
    'icon' => '',
    'wallet' => json_encode([
        'from' => 'admin',
        'to' => 'main_balance',

    ]),
     'json' => json_encode([
    'balance' => [
        'before' => 0,
        'after' => 0
    ],
    'primary_wallet' => 'Main Wallet'

    ]),
    'status' => 'success',
    'updated' => Carbon::now(),
    'date' => Carbon::now()
    ]);

    DB::table('salaries')->insert([
        'uniqid' => GenerateID(),
        'user_id' => Auth::guard('users')->user()->id,
        'salary' => json_encode($salary),
        'status' => 'success',
        'updated' => Carbon::now(),
        'date' => Carbon::now()
    ]);
            });
        return response()->json([
            'message' => 'Salary received succesfully',
            'status' => 'success'
        ]);
    }

    
}
