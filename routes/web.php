<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminsDashboardController;
use App\Http\Controllers\AdminsGetRequestController;
use App\Http\Controllers\AdminsPostRequestController;
use App\Http\Controllers\UsersPostRequestController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserGetRequestController;
use App\Http\Middleware\UsersAuthMiddleware;
use App\Http\Middleware\UsersDashboardMiddleware;
use App\Http\Middleware\AdminsAuthMiddleware;
use App\Http\Middleware\AdminsDashhboardMiddleware;
use App\Http\Controllers\DBController;
use App\Http\Middleware\PackagesMiddeware;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

Route::get('hash',function(){
    return Hash::make(request('password'));
});


// list korapay banks
Route::get('korapay/list/banks',function(){
    $response=Http::withToken(env('KORAPAY_PUBLIC_KEY'))->get('https://api.korapay.com/merchant/api/v1/misc/banks?countryCode=NG');
    if($response->successful()){
        return $response->json();
    }else{
       return $response->body();
    }
});

// aspfiy paga webhook
Route::post('aspfiy/paga/verify/webhook/process',[
    UsersPostRequestController::class,'AspfiyPagaWebhook'
]);
// palmpay webhook
Route::post('aspfiy/palmpay/verify/webhook/process',[
    UsersPostRequestController::class,'AspfiyPalmpayWebhook'
]);
// nekpay payment webhook
Route::post('nekpay/payment/webhook',[
    UsersPostRequestController::class,'NekpayPaymentWebhook'
]);
// nekpay withdrawal webhook
Route::post('nekpay/withdrawal/webhook',[
    UsersPostRequestController::class,'NekpayWithdrawalWebhook'
]);

Route::middleware([PackagesMiddeware::class])->group(function(){


// db controller
Route::get('db/queries',[
    DBController::class,'DBQueries'
]);

// users(not authenticated)
// register
Route::get('users/register',[
    UserDashboardController::class,'Register'
]);
Route::get('register',[
    UserDashboardController::class,'Register'
]);
// login
Route::get('users/login',[
    UserDashboardController::class,'Login'
]);
Route::get('/',[
    UserDashboardController::class,'Login'
]);
Route::get('login',[
    UserDashboardController::class,'Login'
]);
// users (aunthenticated)
Route::middleware([UsersDashboardMiddleware::class])->group(function(){
    // dashboard
    Route::get('users/dashboard',[
        UserDashboardController::class,'Dashboard'
    ]);
    // active packages
    Route::get('users/products/active',[
        UserDashboardController::class,'ActiveProducts'
    ]);
    // profile
    Route::get('users/profile',[
        UserDashboardController::class,'Profile'
    ]);
    // transactions
    Route::get('users/transactions',[
        UserDashboardController::class,'Transactions'
    ]);
    // withdraw
    Route::get('users/withdraw',[
        UserDashboardController::class,'Withdraw'
    ]);
    // add bank
    Route::get('users/bank',[
        UserDashboardController::class,'AddBank'
    ]);
    // password update
    Route::get('users/password/update',[
        UserDashboardController::class,'PasswordUpdate'
    ]);
    // logout
    Route::get('users/logout',[
        UserDashboardController::class,'Logout'
    ]);
    // invite
    Route::get('users/invite',[
        UserDashboardController::class,'Invite'
    ]);
    // gift code
    Route::get('users/gift/code',[
        UserDashboardController::class,'RedeemGiftCode'
    ]);
    // recharge
    Route::get('users/recharge',[
        UserDashboardController::class,'Recharge'
    ]);
    // referrals
    Route::get('users/referrals',[
        UserDashboardController::class,'Referrals'
    ]);
    // switch currency
    Route::get('users/dashboard/switch/currency',[
        UserGetRequestController::class,'SwitchCurrency'
    ]);
    // salary
    Route::get('users/salary/tasks',[
        UserDashboardController::class,'Salary'
    ]);
    // claim salary
    Route::get('users/get/claim/salary',[
        UserGetRequestController::class,'Claimsalary'
    ]);
    // deposit pay
    Route::get('users/deposit/checkout',[
        UserDashboardController::class,'ManualDepositCheckout'
    ]);
   

    // users post request(authenticated)
    // purchase package
    Route::post('users/post/purchase/package/process',[
        UsersPostRequestController::class,'PurchasePackage'
    ]);
    // add bank account
    Route::post('users/post/add/bank/process',[
        UsersPostRequestController::class,'AddBank'
    ]);
    // withdraw funds
    Route::post('users/post/withdraw/process',[
        UsersPostRequestController::class,'Withdrawal'
    ]);
    // update password
    Route::post('users/post/update/password/process',[
        UsersPostRequestController::class,'UpdatePassword'
    ]);
    // redeem gift code
    Route::post('users/post/redeem/gift/code/process',[
       UsersPostRequestController::class,'RedeemGiftCode'
    ]);
    // generate paga account
    Route::post('users/post/generate/paga/account/process',[
        UsersPostRequestController::class,'GeneratePagaAccount'
    ]);
     // generate palmpay account
    Route::post('users/post/generate/palmpay/account/process',[
        UsersPostRequestController::class,'GeneratePalmpayAccount'
    ]);

    // deposit
    Route::post('users/post/deposit/initiate/process',[
        UsersPostRequestController::class,'DepositInitiate'
    ]);
    Route::post('users/post/manual/deposit/initiate/process',[
        UsersPostRequestController::class,'ManualDepositInitiate'
    ]);
    // korapay bank verify
    Route::get('users/get/korapay/bank/verify',[
        UsersPostRequestController::class,'VerifyKorapayBank'
    ]);
    // manual checkout
    Route::post('users/post/deposit/checkout/process',[
        UsersPostRequestController::class,'ManualCheckout'
    ]);
    // kkpay verify deposit webhook
    Route::post('kkpay/deposit/webhook/confirm',[
        UsersPostRequestController::class,'KKPayVerifyDepositWebhook'
    ]);

});
// users post(not authenticated)
// send otp
Route::post('users/post/send/verification/code/process',[
    UsersPostRequestController::class,'SendOTP'
]);
// register
Route::post('users/post/register/process',[
    UsersPostRequestController::class,'Register'
]);
// login
Route::post('users/post/login/process',[
    UsersPostRequestController::class,'Login'
]);





// ADMINS GET REQUEST
// admin auth middleware
Route::middleware([AdminsAuthMiddleware::class])->group(function(){
// admins login
Route::get('admins/login',[
 AdminsDashboardController::class,'Login'
]);
});

// admin dashboard middleware
Route::middleware([AdminsDashhboardMiddleware::class])->group(function(){
    // admins dashboard
Route::get('admins/dashboard',[
    AdminsDashboardController::class,'Dashboard'
]);
// all transactions
Route::get('admins/transactions',[
    AdminsDashboardController::class,'Transactions'
]);
// transaction receipt
Route::get('admins/transaction/receipt',[
    AdminsDashboardController::class,'TransactionReceipt'
]);
// search transactions
Route::get('admins/search/transactions',[
    AdminsGetRequestController::class,'SearchTransactions'
]);

// approve transaction
Route::get('admins/approve/transaction/process',[
    AdminsGetRequestController::class,'ApproveTransaction'
]);
// reject transaction
Route::get('admins/reject/transaction/process',[
    AdminsGetRequestController::class,'RejectTransaction'
]);

// all users
Route::get('admins/users',[
    AdminsDashboardController::class,'AllUsers'
]);

// search users
Route::get('admins/search/users',[
    AdminsGetRequestController::class,'SearchUsers'
]);
// salary
Route::get('admins/salary/add',[
    AdminsDashboardController::class,'AddSalary'
]);
// manage salary
Route::get('admins/salary/manage',[
    AdminsDashboardController::class,'Managesalary'
]);
// delete salary
Route::get('admins/salary/delete',[
    AdminsGetRequestController::class,'salaryDelete'
]);
// edit salary
Route::get('admins/salary/edit',[
    AdminsDashboardController::class,'EditSalary'
]);

// user
Route::get('admins/user',[
    AdminsDashboardController::class,'User'
]);
// mark as promoter
Route::get('admins/user/mark/as/promoter',[
    AdminsDashboardController::class,'MarkAsPromoter'
]);
// manual deposit settings
Route::get('admins/manual/deposit/settings',[
    AdminsDashboardController::class,'ManualDepositSettings'
]);
// manual deposit bank settings
Route::post('admins/post/manual/deposit/bank/settings/process',[
    AdminsPostRequestController::class,'ManualDepositBankSettings'
]);

// login as user
Route::get('admins/login/as/user',[
   AdminsGetRequestController::class,'LoginAsUser'
]);
// ban user
Route::get('admins/ban/user',[
    AdminsGetRequestController::class,'BanUser'
]);
// unban user
Route::get('admins/unban/user',[
    AdminsGetRequestController::class,'UnbanUser'
]);
// site settings
Route::get('admins/settings',[
    AdminsDashboardController::class,'SiteSettings'
]);
// notifications
Route::get('admins/notifications',[
    AdminsDashboardController::class,'Notifications'
]);
// mark notofication as read
Route::get('admins/notification/mark/as/read',[
   AdminsGetRequestController::class,'MarkNotificationAsRead'
]);
// mark all as read
Route::get('admins/notifications/mark/all/as/read',[
    AdminsGetRequestController::class,'MarkAllNotificationAsRead'
]);
// login settings
Route::get('admins/login/settings',[
    AdminsDashboardController::class,'LoginSettings'
]);
// logout
Route::get('admins/logout',[
    AdminsDashboardController::class,'Logout'
]);
// add package
Route::get('admins/packages/add',[
    AdminsDashboardController::class,'AddPackage'
]);
// manage packages
Route::get('admins/packages/manage',[
    AdminsDashboardController::class,'ManagePackages'
]);
// delete package
Route::get('admins/package/delete',[
    AdminsDashboardController::class,'DeletePackage'
]);
// edit package
Route::get('admins/package/edit',[
    AdminsDashboardController::class,'EditPackage'
]);
// create gift code
Route::get('admins/gift/code/create',[
    AdminsDashboardController::class,'CreateGiftCode'
]);
// manage gift code
Route::get('admins/gift/codes/manage',[
    AdminsDashboardController::class,'ManageGiftCodes'
]);
// edit gift code
Route::get('users/gift/code/edit',[
   AdminsDashboardController::class,'EditGiftCode'
]);
// delete gift code
Route::get('admins/gift/code/delete',[
    AdminsDashboardController::class,'DeleteGiftCode'
]);
// investment records
Route::get('admins/packages/investment/records',[
    AdminsDashboardController::class,'InvestmentRecords'
]);
// action investment earning
Route::get('admins/action/investment',[
    AdminsDashboardController::class,'ActionEarning'
]);
// delete investment
Route::get('admins/delete/investment',[
    AdminsDashboardController::class,'DeleteInvestment'
]);
// manage api
Route::get('admins/api/manage',[
    AdminsDashboardController::class,'APIManage'
]);


// ADMINS POST REQUEST(authenticated)
// credit user
Route::post('admins/post/credit/user/process',[
    AdminsPostRequestController::class,'CreditUser'
]);
// debit user
Route::post('admins/post/debit/user/process',[
    AdminsPostRequestController::class,'DebitUser'
]);
// general settings
Route::post('admins/post/general/settings/process',[
    AdminsPostRequestController::class,'GeneralSettings'
]);
// change withdrawal gateway
Route::post('admins/post/change/withdrawal/gateway',[
    AdminsPostRequestController::class,'ChangeWithdrawalGateway'
]);
// change deposit gateway
Route::post('admins/post/change/deposit/gateway',[
    AdminsPostRequestController::class,'ChangeDepositGateway'
]);
// social settings
Route::post('admins/post/social/settings/process',[
    AdminsPostRequestController::class,'SocialSettings'
]);
// finance settings
Route::post('admins/post/finance/settings/process',[
    AdminsPostRequestController::class,'FinanceSettings'
]);
// add package
Route::post('admins/post/add/package/process',[
    AdminsPostRequestController::class,'AddPackage'
]);
// reset user password
Route::post('admins/post/reset/user/pasword',[
    AdminsPostRequestController::class,'ResetUserPassword'
]);
// edit package
Route::post('admins/post/edit/package/process',[
    AdminsPostRequestController::class,'EditPackage'
]);
// referral settings
Route::post('admins/post/referral/settings/process',[
    AdminsPostRequestController::class,'ReferralSettings'
]);
// create gift code
Route::post('admins/post/create/gift/code/process',[
    AdminsPostRequestController::class,'CreateGiftCode'
]);
// create gift code
Route::post('admins/post/edit/gift/code/process',[
    AdminsPostRequestController::class,'EditGiftCode'
]);
// credit all promoters
Route::post('admins/post/credit/all/promoters/process',[
    AdminsPostRequestController::class,'CreditAllPromoters'
]);
// debit all promoters
Route::post('admins/post/debit/all/promoters/process',[
    AdminsPostRequestController::class,'DebitAllPromoters'
]);
// update login password
Route::post('admins/post/login/settings/process',[
    AdminsPostRequestController::class,'LoginSettings'
]);
// create salary
Route::post('admins/post/add/salary/task/process',[
    AdminsPostRequestController::class,'CreateSalary'
]);
// edit salary
Route::post('admins/post/edit/salary/task/process',[
    AdminsPostRequestController::class,'EditSalary'
]);


// admins dashboard middleware close
});


// ADMINS POST REQUEST(Non-Authenticated)
Route::post('admins/post/login/process',[
    AdminsPostRequestController::class,'Login'
]);

});
