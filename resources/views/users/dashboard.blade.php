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
    {{ '234****'.substr(ltrim(Auth::guard('users')->user()->phone,'0'),5,6) }}
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
    Package : {
      ID : ''
    }
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
  <div class="w-full br-10px p-15px bg-light box-shadow row align-center space-between">
   {{-- new link --}}
   @php
       $link = url('users/recharge')
   @endphp
    <div x-on:click="Vitecss.navigate('{{  $link }}')" class="column pointer p-5px c-secondary align-center">
      <i>
      <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path d="M2.273 5.625A4.483 4.483 0 0 1 5.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0 0 18.75 3H5.25a3 3 0 0 0-2.977 2.625ZM2.273 8.625A4.483 4.483 0 0 1 5.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0 0 18.75 6H5.25a3 3 0 0 0-2.977 2.625ZM5.25 9a3 3 0 0 0-3 3v6a3 3 0 0 0 3 3h13.5a3 3 0 0 0 3-3v-6a3 3 0 0 0-3-3H15a.75.75 0 0 0-.75.75 2.25 2.25 0 0 1-4.5 0A.75.75 0 0 0 9 9H5.25Z" />
</svg>

      </i>
      <span>Deposit</span>
    </div>
     {{-- new link --}}
   @php
       $link = url('users/withdraw')
   @endphp
    <div x-on:click="Vitecss.navigate('{{  $link }}')" class="column pointer p-5px c-secondary align-center">
      <i>
    <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z" />
  <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" clip-rule="evenodd" />
</svg>

      </i>
      <span>Withdraw</span>
    </div>
     {{-- new link --}}
   @php
       $link = $social_settings->customer_service;
   @endphp
    <div x-on:click="window.open('{{  $link }}')" class="column pointer p-5px c-secondary align-center">
      <i>
   <svg height="25" width="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.409 1.025 4.587 2.674 6.192.232.226.277.428.254.543a3.73 3.73 0 0 1-.814 1.686.75.75 0 0 0 .44 1.223ZM8.25 10.875a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25ZM10.875 12a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm4.875-1.125a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z" clip-rule="evenodd" />
</svg>


      </i>
      <span>Support</span>
    </div>
     {{-- new link --}}
   @php
       $link = $social_settings->telegram_community;
   @endphp
    <div x-on:click="window.open('{{  $link }}')" class="column pointer p-5px c-secondary align-center">
      <i>
     <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="25" width="25"><path d="M2.14753 11.8099C7.3949 9.52374 10.894 8.01654 12.6447 7.28833C17.6435 5.20916 18.6822 4.84799 19.3592 4.83606C19.5081 4.83344 19.8411 4.87034 20.0567 5.04534C20.2388 5.1931 20.2889 5.39271 20.3129 5.5328C20.3369 5.6729 20.3667 5.99204 20.343 6.2414C20.0721 9.08763 18.9 15.9947 18.3037 19.1825C18.0514 20.5314 17.5546 20.9836 17.0736 21.0279C16.0283 21.1241 15.2345 20.3371 14.2221 19.6735C12.6379 18.635 11.7429 17.9885 10.2051 16.9751C8.42795 15.804 9.58001 15.1603 10.5928 14.1084C10.8579 13.8331 15.4635 9.64397 15.5526 9.26395C15.5637 9.21642 15.5741 9.03926 15.4688 8.94571C15.3636 8.85216 15.2083 8.88415 15.0962 8.9096C14.9373 8.94566 12.4064 10.6184 7.50365 13.928C6.78528 14.4212 6.13461 14.6616 5.55163 14.649C4.90893 14.6351 3.67265 14.2856 2.7536 13.9869C1.62635 13.6204 0.730432 13.4267 0.808447 12.8044C0.849081 12.4803 1.29544 12.1488 2.14753 11.8099Z"></path></svg>

      </i>
      <span>Group</span>
    </div>
  </div>
  {{-- products --}}
  @if (!$packages->isEmpty())
    <div style="grid-template-columns: repeat(auto-fit,minmax(min(50%,150px),1fr))" class="w-full grid g-10px place-center">
        @foreach ($packages as $data)
          <div class="w-full bg-light box-shadow br-10px p-5px column g-10px">
            <div class="w-full br-inherit pos-relative">
              <div class="pos-absolute p-5px font-size-07rem br-top-right-10px br-bottom-left-10px top-0 right-0 bg-secondary secondary-text">
                Times : {{ $data->purchased }} / {{ $data->purchase_limit }}
              </div>
              <img src="{{ asset('packages/'.$data->photo.'') }}" alt="" class="w-full br-inherit no-select no-pointer">
           <div style="background:linear-gradient(to bottom,rgba(0,0,0,0),rgba(0,0,0,0.5),rgba(0,0,0,0.9))" class="p-10px c-white pos-absolute br-bottom-right-10px br-bottom-left-10px bottom-0 w-full z-index-200">
            <span class="font-size-1rem font-weight-700">{{ $data->name }}</span>
           </div>
            </div>
            {{-- new row --}}
            <div class="row w-full g-5px">
              <div class="w-full bg-rgt-005 overflow-auto c-secondary p-5px align-center br-5px column g-2px">
                <strong class="font-weight-900 ws-nowrap">&#8358;{{ number_format($data->cost) }}</strong>
                <small>Price</small>
              </div>
              <div class="w-full bg-rgt-005 overflow-auto c-secondary p-5px align-center br-5px column g-2px">
                <strong class="font-weight-900 ws-nowrap">&#8358;{{ number_format($data->earning) }}</strong>
                <small>Daily Profit</small>
              </div>
            </div>
               {{-- new row --}}
            <div class="row w-full g-5px">
              <div class="w-full bg-rgt-005 overflow-auto c-secondary p-5px align-center br-5px column g-2px">
                <strong class="font-weight-900 ws-nowrap">{{ number_format($data->validity) }}</strong>
                <small>Days</small>
              </div>
              <div class="w-full bg-rgt-005 overflow-auto c-secondary p-5px align-center br-5px column g-2px">
                <strong class="font-weight-900 ws-nowrap">&#8358;{{ number_format($data->earning * $data->validity) }}</strong>
                <small>Total Profit</small>
              </div>
            </div>
           @if ($data->purchased >= $data->purchase_limit)
                <button style="color:white;background:#999;" class="w-full disabled row align-center g-5px justify-center font-weight-700 font-size-07rem br-1000 bg-primary primary-text p-5px border-none">
            
              <span>Limit reached</span>
            </button>
           @else
                <button x-on:click="
                Package.ID = '{{ $data->id }}';
                Prompt = true;
                " class="w-full row align-center g-5px justify-center font-weight-700 font-size-07rem br-1000 bg-primary primary-text p-5px border-none">
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 18 18">
  <g fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.93471 1.02242C1.53288 0.921888 1.12564 1.16614 1.0251 1.56797C0.924574 1.9698 1.16882 2.37704 1.57065 2.47757L2.92222 2.81571C3.01968 2.84001 3.09381 2.92126 3.10866 3.02216C3.43138 5.21599 3.75405 7.40943 4.07678 9.6033C3.16441 9.8903 2.50269 10.7429 2.50269 11.75C2.50269 12.9926 3.51007 14 4.75269 14H15.2527C15.6669 14 16.0027 13.6642 16.0027 13.25C16.0027 12.8358 15.6669 12.5 15.2527 12.5H4.75269C4.3385 12.5 4.00269 12.1642 4.00269 11.75C4.00269 11.3358 4.3385 11 4.75269 11C7.51908 11 10.2857 11 13.0522 11C13.788 11 14.4455 10.5397 14.697 9.848L15.9694 6.34796C16.3843 5.20655 15.5389 4 14.3246 4H4.76865L4.59268 2.80381C4.48956 2.10291 3.97341 1.53215 3.28516 1.36028L1.93471 1.02242Z" fill="currentColor"></path> <path d="M4.00269 17C4.55469 17 5.00269 16.552 5.00269 16C5.00269 15.448 4.55469 15 4.00269 15C3.45069 15 3.00269 15.448 3.00269 16C3.00269 16.552 3.45069 17 4.00269 17Z" fill="currentColor"></path> <path d="M14.0027 17C14.5547 17 15.0027 16.552 15.0027 16C15.0027 15.448 14.5547 15 14.0027 15C13.4507 15 13.0027 15.448 13.0027 16C13.0027 16.552 13.4507 17 14.0027 17Z" fill="currentColor"></path></g>
</svg>
              <span>Buy Now</span>
            </button>
           @endif
          </div>
      @endforeach
    </div>
  @endif
  {{-- prompt --}}
  <section x-show="Prompt" x-transition:enter-start="fade-enter" x-transition:enter-end="fade-enter-end" x-transition:leave-start="fade-leave" x-transition:leave-end="fade-leave-end" class="pos-fixed inset-0 no-select bg-black-transparent z-index-5000 p-50px column align-center justify-center transition-all">
    <div x-on:click.outside="Prompt=false;" class="w-full bg-white column br-5px max-w-500px">
<div class="w-full column align-center text-align-center g-10px p-15px">
  <strong class="font-weight-700 font-size-1rem">Confirm</strong>
  <span class="opacity-07">
    Are you sure you want to purchase this product?
  </span>
</div>
<div class="w-full font-size-1rem border-top-width-05px border-top-color-rgt-07 border-top-style-solid row align-center">
  <div x-on:click="Prompt = false;" class="w-full border-right-width-05px border-right-color-rgt-07 border-right-style-solid p-15px row align-center justify-center">
    Cancel
  </div>
    <div x-data="{ 
     }" x-on:click="
     Loading = true;
     $el.classList.add('disabled');
     SendPostRequest('{{ url('users/post/purchase/package/process') }}',{
        'id' : Package.ID,
        '_token' : '{{ @csrf_token() }}'
     },function(response,error){
        let data=JSON.parse(response);
       Inform.Status = data.status;
       Inform.Message = data.message;
        Loading = false;
        $el.classList.remove('disabled');
      if(data.status == 'success'){
        Vitecss.navigate('{{ url('users/products/active') }}')
          
      }

     })
     " class="w-full c-secondary font-weight-700 p-15px row align-center justify-center">
    Confirm
  </div>
</div>
    </div>
  </section>
  <div x-init="
  $el.style.bottom= document.querySelector('footer').offsetHeight + 10 + 'px'
  " class="pos-fixed right-10px z-index-5000 column align-center g-10px">
  <div x-on:click="Vitecss.navigate('{{ url('users/salary/tasks') }}')" class="h-50px w-50px p-2px circle bg-primary">
      <img src="{{ asset('banners/53BB17E0-ACC9-4C8D-A232-A8E72EE44FF2-compressed.jpeg') }}" alt="" class="w-full h-full br-inherit no-select">
    </div>
  <div x-on:click="Vitecss.navigate('{{ url('users/gift/code') }}')" class="h-50px w-50px p-2px circle bg-primary">
      <img src="{{ asset('banners/8A912FF0-6F88-4428-83F0-43F79DCDE99F-compressed.jpeg') }}" alt="" class="w-full h-full br-inherit no-select">
    </div>
  </div>
  </section>
@endsection