<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
// wallets
function Wallets(){
  $wallets= [
    [
        'key' => 'main_balance',
        'name' => 'Withdrawal Wallet',
        'class' => 'general'
    
    ],
    [
        'key' => 'deposit_balance',
        'name' => 'Deposit Wallet',
        'class' => 'credit'
    ],
    // [
    //     'key' => 'withdrawal_balance',
    //     'name' => 'Withdrawal Wallet',
    //     'class' => 'debit'
    // ],
    

  ];
  return json_decode(json_encode($wallets));
}

// notification amount
function TotalNotifications(){
  $total=DB::table('notifications')->where('status->admin','unread')->count();
  if($total >= 99){
    return '99+';
  }else{
    return $total;
  }

}


  // generate id
  function GenerateID(){
    return strtoupper(substr(Str::random(4).time(),0,14));

  }

?>