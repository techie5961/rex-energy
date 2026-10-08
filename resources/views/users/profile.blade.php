@extends('layout.users.app')
@section('title')
    Dashboard
@endsection
@section('header')
    <div x-data="{ 
      MarginBottom : 0
     }" style="min-height:fit-content;" class="w-full pos-relative">
      <img style="max-height:100%;" src="{{ asset('banners/89B412FD-DB24-4225-87BF-362A6C04FCE6-compressed.jpeg') }}" alt="" class="w-full no-select pos-absolute inset-0 z-index-3000 no-pointer">
  <div style="min-height:100%" class="pos-relative z-index-5000 p-20px column p-bottom-0 p-top-30px g-10px  top-0 left-0 right-0 backdrop-blur-5px z-index-500">
<div class="w-full row g-10px">
  <div class="h-100px pos-relative w-100px bg-primary-lighter circle p-5px">
  <img src="{{ asset(config('settings.logo')) }}" alt="" class="w-full br-inherit h-full">
  <div style="top:100%;left:50%;transform:translate(-50%,-100%);" class="bg-primary-lighter ws-nowrap w-fit pos-absolute no-select primary-text box-shadow p-3px p-x-15px font-size-06rem font-weight-900 br-1000px">
    VIP {{ Auth::guard('users')->user()->vip_level }}
  </div>
</div>
<div class="column g-5px">
  <strong class="font-size-1-3rem text-shadow c-white font-weight-800">
    {{ '234'.ltrim(Auth::guard('users')->user()->phone,'0') }}
  </strong>
  <div class="bg-primary-lighter no-select w-fit primary-text p-5px p-x-10px font-size-07rem font-weight-900 br-1000px">
    ID: {{ Auth::guard('users')->user()->uniqid }}
  </div>
</div>
</div>
 <div style="background:linear-gradient(to bottom,var(--primary-light),var(--primary));transform:translateY(20%)" class="w-full balance-div box-shadow m-top-auto primary-text p-20px br-10px row">
{{-- new --}}
<div style="border-right:1px solid var(--primary-text)" class="column text-align-center overflow-hidden p-10px w-full align-center">
<strong class="font-size-1rem ws-nowrap text-overflow-ellipsis font-weight-900">{{ Auth::guard('users')->user()->currency.number_format(Auth::guard('users')->user()->main_balance) }}</strong>
<span class="font-size-07rem ws-nowrap text-overflow-ellipsis">Main</span>
</div>
{{-- new --}}
<div style="border-right:1px solid var(--primary-text)" class="column text-align-center overflow-hidden p-10px w-full align-center">
<strong class="font-size-1rem ws-nowrap text-overflow-ellipsis font-weight-900">{{ Auth::guard('users')->user()->currency.number_format(Auth::guard('users')->user()->deposit_balance) }}</strong>
<span class="font-size-07rem ws-nowrap text-overflow-ellipsis">Deposit</span>
</div>
{{-- new --}}
<div class="column overflow-hidden text-align-center w-full align-center p-10px">
<strong class="font-size-1rem ws-nowrap text-overflow-ellipsis font-weight-900">{{ Auth::guard('users')->user()->currency.number_format($total_earnings) }}</strong>
<span class="font-size-07rem ws-nowrap text-overflow-ellipsis">Income</span>
</div>
  </div>
  </div>
 
    </div>
@endsection
@section('main')
  <section x-data="{ 
    Prompt : false,
  
   }" x-init="
   $watch('Prompt', (value) => {
    if(value){
      document.body.classList.add('overflow-hidden');
    }else{
      document.body.classList.remove('overflow-hidden');
    }
   })
  " x-bind:style="{
    'margin-top' : (20 * document.querySelector('header .balance-div').offsetHeight)/100 + 'px'
  }" class="w-full g-10px column">
 <div class="w-full p-15px column bg-light br-10px box-shadow">
  {{-- new --}}
 @php
     $link = url('users/bank')
 @endphp
  <div x-on:click="Vitecss.navigate('{{ $link }}')" class="w-full border-bottom-width-1px border-bottom-style-solid border-bottom-color-rgt-01 p-bottom-10px row align-center space-between g-10px">
  <div style="background:var(--secondary-005);color:var(--secondary);" class="h-40px w-40px circle column no-shrink align-center justify-center">
<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
  <g fill="currentColor">
    <line x1="1.75" y1="7.25" x2="16.25" y2="7.25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></line>
    <rect x="1.75" y="3.75" width="14.5" height="10.5" rx="2" ry="2" transform="translate(18 18) rotate(180)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></rect>
    <line x1="4.25" y1="11.25" x2="7.25" y2="11.25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></line>
    <line x1="12.75" y1="11.25" x2="13.75" y2="11.25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></line>
  </g>
</svg>
  </div>
  <span class="font-weight-700 m-right-auto">Bind bank card</span>
  <i>
    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 18 18">
  <g fill="currentColor">
    <path d="M13.28,8.47L7.03,2.22c-.293-.293-.768-.293-1.061,0s-.293,.768,0,1.061l5.72,5.72-5.72,5.72c-.293,.293-.293,.768,0,1.061,.146,.146,.338,.22,.53,.22s.384-.073,.53-.22l6.25-6.25c.293-.293,.293-.768,0-1.061Z" fill="currentColor"></path>
  </g>
</svg>
  </i>
 </div>
 {{-- new --}}
  @php
     $link = url('users/password/update')
 @endphp
  <div x-on:click="Vitecss.navigate('{{ $link }}')" class="w-full border-bottom-width-1px border-bottom-style-solid border-bottom-color-rgt-01 p-y-10px row align-center space-between g-10px">
  <div style="background:var(--secondary-005);color:var(--secondary);" class="h-40px w-40px circle column no-shrink align-center justify-center">
<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
  <g fill="currentColor"><path d="M20.3777 12.9014L21 4.5L20.4499 4.445C17.508 4.1508 14.6445 3.32223 12 2C9.35553 3.32223 6.49199 4.1508 3.55006 4.44499L3 4.5L3.62236 12.9014C3.85658 16.0632 5.73712 18.8685 8.57285 20.2864L12.0001 22L15.4272 20.2864C18.263 18.8685 20.1435 16.0632 20.3777 12.9014Z" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square" fill="none"></path> <path d="M9 12L11 14L16 9" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square" fill="none"></path> <path d="M9 12L11 14L16 9" stroke="currentColor" stroke-opacity="0.2" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square" fill="none"></path> <path d="M9 12L11 14L16 9" stroke="currentColor" stroke-opacity="0.2" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square" fill="none"></path> <path d="M9 12L11 14L16 9" stroke="currentColor" stroke-opacity="0.2" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square" fill="none"></path></g>
</svg>
  </div>
  <span class="font-weight-700 m-right-auto">Change Password</span>
  <i>
    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 18 18">
  <g fill="currentColor">
    <path d="M13.28,8.47L7.03,2.22c-.293-.293-.768-.293-1.061,0s-.293,.768,0,1.061l5.72,5.72-5.72,5.72c-.293,.293-.293,.768,0,1.061,.146,.146,.338,.22,.53,.22s.384-.073,.53-.22l6.25-6.25c.293-.293,.293-.768,0-1.061Z" fill="currentColor"></path>
  </g>
</svg>
  </i>
 </div>
 {{-- new --}}
  @php
     $link = url('users/transactions')
 @endphp
  <div x-on:click="Vitecss.navigate('{{ $link }}')" class="w-full border-bottom-width-1px border-bottom-style-solid border-bottom-color-rgt-01 p-y-10px row align-center space-between g-10px">
  <div style="background:var(--secondary-005);color:var(--secondary);" class="h-40px w-40px circle column no-shrink align-center justify-center">
<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
  <g fill="currentColor"><path d="M10.25 12.75L12.75 15.25L15.25 12.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path> <path d="M12.75 15.25V6.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path> <path d="M2.75 9.75H9.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path> <path d="M2.75 6.25H9.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path> <path d="M2.75 2.75H12.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path></g>
</svg>
  </div>
  <span class="font-weight-700 m-right-auto">Transaction Records</span>
  <i>
    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 18 18">
  <g fill="currentColor">
    <path d="M13.28,8.47L7.03,2.22c-.293-.293-.768-.293-1.061,0s-.293,.768,0,1.061l5.72,5.72-5.72,5.72c-.293,.293-.293,.768,0,1.061,.146,.146,.338,.22,.53,.22s.384-.073,.53-.22l6.25-6.25c.293-.293,.293-.768,0-1.061Z" fill="currentColor"></path>
  </g>
</svg>
  </i>
 </div>
 {{-- new --}}
  @php
     $link = url('users/transactions?type=deposit')
 @endphp
  <div x-on:click="Vitecss.navigate('{{ $link }}')" class="w-full border-bottom-width-1px border-bottom-style-solid border-bottom-color-rgt-01 p-y-10px row align-center space-between g-10px">
  <div style="background:var(--secondary-005);color:var(--secondary);" class="h-40px w-40px circle column no-shrink align-center justify-center">
<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
  <g fill="currentColor">
    <path d="M14.7505 7.25H9.49905L9.81065 1.9868C9.82325 1.7732 9.55085 1.6734 9.42255 1.8446L3.04965 10.3501C2.92615 10.5149 3.04376 10.75 3.24976 10.75H8.50115L8.18955 16.0132C8.17695 16.2268 8.44935 16.3266 8.57765 16.1554L14.9506 7.6499C15.0741 7.4851 14.9565 7.25 14.7505 7.25Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path>
  </g>
</svg>
  </div>
  <span class="font-weight-700 m-right-auto">Recharge Records</span>
  <i>
    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 18 18">
  <g fill="currentColor">
    <path d="M13.28,8.47L7.03,2.22c-.293-.293-.768-.293-1.061,0s-.293,.768,0,1.061l5.72,5.72-5.72,5.72c-.293,.293-.293,.768,0,1.061,.146,.146,.338,.22,.53,.22s.384-.073,.53-.22l6.25-6.25c.293-.293,.293-.768,0-1.061Z" fill="currentColor"></path>
  </g>
</svg>
  </i>
 </div>
 {{-- new --}}
  @php
     $link = url('users/transactions?type=withdrawal')
 @endphp
  <div x-on:click="Vitecss.navigate('{{ $link }}')" class="w-full border-bottom-width-1px border-bottom-style-solid border-bottom-color-rgt-01 p-y-10px row align-center space-between g-10px">
  <div style="background:var(--secondary-005);color:var(--secondary);" class="h-40px w-40px circle column no-shrink align-center justify-center">
<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
  <g fill="currentColor"><path d="M2.50002 11.661C2.75902 10.74 3.65202 10.236 4.61602 10.25C5.58102 10.264 6.48802 10.696 6.54502 11.661C6.60202 12.626 5.58002 13.273 4.52202 13.705C3.46402 14.137 2.58602 14.54 2.49902 15.749H6.54802" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path> <path d="M9.5 5.25H16.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path> <path d="M9.5 12.75H16.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path> <path d="M4.75002 7.5V2C4.75002 2 4.12002 3.108 2.78302 3.364" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path></g>
</svg>
  </div>
  <span class="font-weight-700 m-right-auto">Withdraw Records</span>
  <i>
    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 18 18">
  <g fill="currentColor">
    <path d="M13.28,8.47L7.03,2.22c-.293-.293-.768-.293-1.061,0s-.293,.768,0,1.061l5.72,5.72-5.72,5.72c-.293,.293-.293,.768,0,1.061,.146,.146,.338,.22,.53,.22s.384-.073,.53-.22l6.25-6.25c.293-.293,.293-.768,0-1.061Z" fill="currentColor"></path>
  </g>
</svg>
  </i>
 </div>
 {{-- new --}}
  @php
     $link = url('users/logout')
 @endphp
  <div x-on:click="window.location.href='{{ $link }}'" class="w-full p-top-10px row align-center space-between g-10px">
  <div style="background:rgba(255,0,0,0.1);color:red;" class="h-40px w-40px circle column no-shrink align-center justify-center">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="18" width="18"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C15.2713 2 18.1757 3.57078 20.0002 5.99923L17.2909 5.99931C15.8807 4.75499 14.0285 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C14.029 20 15.8816 19.2446 17.2919 17.9998L20.0009 17.9998C18.1765 20.4288 15.2717 22 12 22ZM19 16V13H11V11H19V8L24 12L19 16Z"></path></svg>

  </div>
  <span class="font-weight-700 m-right-auto">Logout</span>
  <i>
    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 18 18">
  <g fill="currentColor">
    <path d="M13.28,8.47L7.03,2.22c-.293-.293-.768-.293-1.061,0s-.293,.768,0,1.061l5.72,5.72-5.72,5.72c-.293,.293-.293,.768,0,1.061,.146,.146,.338,.22,.53,.22s.384-.073,.53-.22l6.25-6.25c.293-.293,.293-.768,0-1.061Z" fill="currentColor"></path>
  </g>
</svg>
  </i>
 </div>
 </div>
  
 
  </section>
@endsection