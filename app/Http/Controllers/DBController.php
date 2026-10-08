<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DBController extends Controller
{
    // db queries
    public function DBQueries(){
    if(!Schema::hasTable('packages')){
        Schema::create('packages',function($table){
            $table->id();
            $table->string('uniqid');
            $table->string('photo')->nullable();
            $table->string('name')->nullable();
            $table->float('cost')->default(0)->comment('package cost/purchase price');
            $table->float('earning')->default(0)->comment('daily earning amount');
            $table->bigInteger('validity')->default(1000)->comment('How long the package last befire expiry');
            $table->bigInteger('available')->defult(1000)->comment('the units of thei pacakage available');
            $table->string('status')->default('active');
            $table->timestamp('updated')->useCurrent();
            $table->timestamp('date')->useCurrent();
            
        });
    }

    if(!Schema::hasTable('purchased_packages')){
        Schema::create('purchased_packages',function($table){
                $table->id();
                $table->string('uniqid');
                $table->bigInteger('user_id')->comment('The id of the user who purchased the package');
                $table->json('package')->comment('The package purchased in json format,usually fetched from package table based of package id');
                $table->string('status')->default('active')->comment('Sets to inactive if not active');
                $table->timestamp('updated')->useCurrent()->comment('updated date(updates for last rewarded time)');
                $table->timestamp('date')->useCurrent()->comment('purchase date');
        });
    }

    if(!Schema::hasColumn('users','bank')){
        Schema::table('users',function($table){
            $table->json('bank')->nullable()->comment('The user bank details in json_format with keys(bank_name,account_number & account_name)');
            
        });
    }


    return response()->json([
        'message' => 'All queries ran successfull',
        'status' => 'success'
    ]);
    }
}
