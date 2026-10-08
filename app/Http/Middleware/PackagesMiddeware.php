<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class PackagesMiddeware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      if(Cache::add('processing_packages',true,30)){
          $packages=DB::table('purchased_packages')->where('updated','<',Carbon::now()->subDay())->where('cycle','>',0)->where('status','active')->limit(100)->get();
      foreach($packages as $package){
        DB::transaction(function() use($package){
            $package->package=json_decode($package->package);
            DB::table('users')->where('id',$package->user_id)->increment('main_balance',$package->package->earning);
            DB::table('purchased_packages')->where('id',$package->id)->decrement('cycle',1,[
                'updated' => Carbon::now(),
                'status' => DB::raw("CASE WHEN cycle <= 0 THEN 'completed' ELSE status END")
            ]);
             DB::table('transactions')->insert([
    'uniqid' => GenerateID(),
    'user_id' => $package->user_id,
    'title' => 'Daily Income',
    'class' => 'credit',
    'fee' => 0,
    'icon' => '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M6 3C4.34315 3 3 4.34315 3 6V18C3 19.6569 4.34315 21 6 21H18C19.6569 21 21 19.6569 21 18V6C21 4.34315 19.6569 3 18 3H6ZM16 11L11 18V13H8L13 6V11H16Z"></path></svg>',
    'type' => 'package_earning',
    'amount' => $package->package->earning,
    'wallet' => json_encode([
        'from' => 'package',
        'to' => 'main_balance',

    ]),
    'data' => json_encode([
        'Package' => $package->package->name,
        'Purchase Price' => DB::table('users')->where('id',$package->user_id)->first()->currency.number_format($package->package->cost,2),
        'Daily Earning' => DB::table('users')->where('id',$package->user_id)->first()->currency.number_format($package->package->earning,2),
        ]),
     'json' => json_encode([
    'balance' => [
        'before' => DB::table('users')->where('id',$package->user_id)->first()->main_balance,
        'after' => DB::table('users')->where('id',$package->user_id)->first()->main_balance + $package->package->earning
    ],
    'primary_wallet' => 'Main Wallet',
    'investment_id' => $package->id

    ]),
    'status' => 'success',
    'updated' => Carbon::now(),
    'date' => Carbon::now()
    ]);
        });
      }
      }
      
        return $next($request);
    }
}
