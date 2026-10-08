@extends('layout.admins.app')
@section('title')
    User
@endsection
@section('css')
    <style class="css">
         .balance-div{
        width:100%;
        display:flex;
        flex-direction:column;
        gap:4px;
        text-align:center;
        align-items:center;
        padding:10px;
        position: relative;
        border-radius:5px;
        background:var(--rgt-007);
        box-shadow:0 0 10px var(--rgt-01);
        border:1px solid var(--rgt-01);
        max-width:50%;

               
    }
       
       .wallet-heading.active .bar{
        height:4px;
        width:100%;
        background:black;
        border-radius:1000px;
        clip-path:inset(0 round 1000px);
        

       }
       .forms{
        display:none !important;
       }
       .forms .title{
        display:none !important;
       }
       .forms.log .title{
        display:flex !important;
       }
       .credit-form button.post{
        background:green !important;
       }
       .debit-form button.post{
        background:red !important;
       }
       .credit-form.active{
        display:flex !important;
       }
       .debit-form.active{
        display:flex !important;
       }
       button{
        clip-path:none !important;
        box-shadow:0 0 10px rgba(0,0,0,0.2);
       }
    </style>
@endsection
@section('main')
    <section x-data="{ 
        ResetOverlay : false
     }" x-init="
     $watch('ResetOverlay', (value) => {
        if(value){
            document.body.classList.add('overflow-hidden');
        }else{
            document.body.classList.remove('overflow-hidden');
        }
     })
     " class="w-full column g-10">
         <div style="max-width:100%;border:1px solid var(--rgt-01);overflow:hidden;" class="w-full p-20 br-10 column g-10 bg-light">
                    {{-- new row --}}
                    <div class="row w-full g-10">
                        {{-- new --}}
                        <div class="h-50 bg-primary p-10 primary-text w-50 circle column align-center justify-center no-shrink no-select pointer-none">
                            @isset(Auth::guard('users')->user()->photo)
                                <img src="{{ asset('photos/users/'.$data->photo.'') }}" alt="" class="h-full w-full circle">
                          @else
                          <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13Z"></path></svg>

                                @endisset
                        </div>
                        {{-- new column --}}
                        <div class="column g-3">
                            <strong class="font-weight-900 font-size-1">{{ $data->username }}</strong>
                          {{-- new row --}}
                            <div class="w-full row opacity-07 align-center g-2">
                                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3ZM12.0606 11.6829L5.64722 6.2377L4.35278 7.7623L12.0731 14.3171L19.6544 7.75616L18.3456 6.24384L12.0606 11.6829Z"></path></svg>
                                <small>{{ $data->email }}</small>
                            </div>
                            {{-- new row --}}
                             <div class="w-full row opacity-07 align-center g-2">
                            <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM13 12V7H11V14H17V12H13Z"></path></svg>
                                <small>Registered: {{ $data->frame }}</small>
                            </div>

                        </div>
                        {{-- new --}}
                        <div class="status m-left-auto {{ $data->status == 'active' ? 'green' : 'red' }}">{{ $data->status }}</div>
                    </div>
                    <hr>
                    {{-- new row --}}
                    <div class="row w-full g-10 align-center">
                        <div style="" class="balance-div">
                            <small>Main Balance</small>
                            <strong style="max-width:100%;" class="ws-nowrap font-weight-900 block text-overflow-ellipsis font-size-1">{{ $data->currency.number_format($data->main_balance,2) }}</strong>
                        </div>
                        <div class="balance-div">
                            <small>Deposit balance</small>
                            <strong style="max-width:100%;" class="ws-nowrap font-weight-900 block text-overflow-ellipsis font-size-1">{{ $data->currency.number_format($data->deposit_balance,2) }}</strong>
                        </div>
                    </div>
                    <hr>
                    {{-- new row --}}
                     <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">
                            <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M17.0839 15.812C19.6827 13.0691 19.6379 8.73845 16.9497 6.05025C14.2161 3.31658 9.78392 3.31658 7.05025 6.05025C4.36205 8.73845 4.31734 13.0691 6.91612 15.812C7.97763 14.1228 9.8577 13 12 13C14.1423 13 16.0224 14.1228 17.0839 15.812ZM12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364L12 23.7279ZM12 12C10.3431 12 9 10.6569 9 9C9 7.34315 10.3431 6 12 6C13.6569 6 15 7.34315 15 9C15 10.6569 13.6569 12 12 12Z"></path></svg>

                        <span>User ID:</span>
                        </div>
                        <strong class="text-overflow-ellipsis"> {{ $data->uniqid }}</strong>
                    </div>
                     {{-- new row --}}
                     <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">
                            <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M20 22H4V20C4 17.2386 6.23858 15 9 15H15C17.7614 15 20 17.2386 20 20V22ZM12 13C8.68629 13 6 10.3137 6 7C6 3.68629 8.68629 1 12 1C15.3137 1 18 3.68629 18 7C18 10.3137 15.3137 13 12 13Z"></path></svg>

                        <span>User Type:</span>
                        </div>
                        <strong class="text-overflow-ellipsis"> {{ ucwords($data->type) }}</strong>
                    </div>
                     {{-- new row --}}
                     <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">

                            <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M21 16.42V19.9561C21 20.4811 20.5941 20.9167 20.0705 20.9537C19.6331 20.9846 19.2763 21 19 21C10.1634 21 3 13.8366 3 5C3 4.72371 3.01545 4.36687 3.04635 3.9295C3.08337 3.40588 3.51894 3 4.04386 3H7.5801C7.83678 3 8.05176 3.19442 8.07753 3.4498C8.10067 3.67907 8.12218 3.86314 8.14207 4.00202C8.34435 5.41472 8.75753 6.75936 9.3487 8.00303C9.44359 8.20265 9.38171 8.44159 9.20185 8.57006L7.04355 10.1118C8.35752 13.1811 10.8189 15.6425 13.8882 16.9565L15.4271 14.8019C15.5572 14.6199 15.799 14.5573 16.001 14.6532C17.2446 15.2439 18.5891 15.6566 20.0016 15.8584C20.1396 15.8782 20.3225 15.8995 20.5502 15.9225C20.8056 15.9483 21 16.1633 21 16.42Z"></path></svg>

                        <span>Phone Number:</span>
                        </div>
                        <strong class="text-overflow-ellipsis"> {{ $data->phone }}</strong>
                    </div>
                     {{-- new row --}}
                     <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">

<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M2.04932 12.9999H7.52725C7.70624 16.2688 8.7574 19.3053 10.452 21.8809C5.98761 21.1871 2.5001 17.5402 2.04932 12.9999ZM2.04932 10.9999C2.5001 6.45968 5.98761 2.81276 10.452 2.11902C8.7574 4.69456 7.70624 7.73111 7.52725 10.9999H2.04932ZM21.9506 10.9999H16.4726C16.2936 7.73111 15.2425 4.69456 13.5479 2.11902C18.0123 2.81276 21.4998 6.45968 21.9506 10.9999ZM21.9506 12.9999C21.4998 17.5402 18.0123 21.1871 13.5479 21.8809C15.2425 19.3053 16.2936 16.2688 16.4726 12.9999H21.9506ZM9.53068 12.9999H14.4692C14.2976 15.7828 13.4146 18.3732 11.9999 20.5915C10.5852 18.3732 9.70229 15.7828 9.53068 12.9999ZM9.53068 10.9999C9.70229 8.21709 10.5852 5.62672 11.9999 3.40841C13.4146 5.62672 14.2976 8.21709 14.4692 10.9999H9.53068Z"></path></svg>

                        <span>Country:</span>
                        </div>
                        <strong class="text-overflow-ellipsis"> {{ ucwords($data->country) }}</strong>
                    </div>

                      {{-- new row --}}
                     <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">

<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M19.2914 5.99994H20.0002C20.5525 5.99994 21.0002 6.44766 21.0002 6.99994V13.9999C21.0002 14.5522 20.5525 14.9999 20.0002 14.9999H18.0002L13.8319 9.16427C13.3345 8.46797 12.4493 8.16522 11.6297 8.41109L9.14444 9.15668C8.43971 9.3681 7.6758 9.17551 7.15553 8.65524L6.86277 8.36247C6.41655 7.91626 6.49011 7.17336 7.01517 6.82332L12.4162 3.22262C13.0752 2.78333 13.9312 2.77422 14.5994 3.1994L18.7546 5.8436C18.915 5.94571 19.1013 5.99994 19.2914 5.99994ZM5.02708 14.2947L3.41132 15.7085C2.93991 16.1209 2.95945 16.8603 3.45201 17.2474L8.59277 21.2865C9.07284 21.6637 9.77592 21.5264 10.0788 20.9963L10.7827 19.7645C11.2127 19.012 11.1091 18.0682 10.5261 17.4269L7.82397 14.4545C7.09091 13.6481 5.84722 13.5771 5.02708 14.2947ZM7.04557 5H3C2.44772 5 2 5.44772 2 6V13.5158C2 13.9242 2.12475 14.3173 2.35019 14.6464C2.3741 14.6238 2.39856 14.6015 2.42357 14.5796L4.03933 13.1658C5.47457 11.91 7.65103 12.0343 8.93388 13.4455L11.6361 16.4179C12.6563 17.5401 12.8376 19.1918 12.0851 20.5087L11.4308 21.6538C11.9937 21.8671 12.635 21.819 13.169 21.4986L17.5782 18.8531C18.0786 18.5528 18.2166 17.8896 17.8776 17.4146L12.6109 10.0361C12.4865 9.86205 12.2652 9.78636 12.0603 9.84783L9.57505 10.5934C8.34176 10.9634 7.00492 10.6264 6.09446 9.7159L5.80169 9.42313C4.68615 8.30759 4.87005 6.45035 6.18271 5.57524L7.04557 5Z"></path></svg>

                        <span>Referred By:</span>
                        </div>
                        <strong onclick="window.location.href='{{ url('admins/user?id='.$data->ref ?? ''.'') }}'" class="{{ $data->upline == 'None' ? 'no-pointer no-select' : 'c-primary u no-select pointer' }}"> {{ ucwords($data->upline) }}</strong>
                    </div>
                        {{-- new row --}}
                     <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">

<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M12 10C14.2091 10 16 8.20914 16 6 16 3.79086 14.2091 2 12 2 9.79086 2 8 3.79086 8 6 8 8.20914 9.79086 10 12 10ZM5.5 13C6.88071 13 8 11.8807 8 10.5 8 9.11929 6.88071 8 5.5 8 4.11929 8 3 9.11929 3 10.5 3 11.8807 4.11929 13 5.5 13ZM21 10.5C21 11.8807 19.8807 13 18.5 13 17.1193 13 16 11.8807 16 10.5 16 9.11929 17.1193 8 18.5 8 19.8807 8 21 9.11929 21 10.5ZM12 11C14.7614 11 17 13.2386 17 16V22H7V16C7 13.2386 9.23858 11 12 11ZM5 15.9999C5 15.307 5.10067 14.6376 5.28818 14.0056L5.11864 14.0204C3.36503 14.2104 2 15.6958 2 17.4999V21.9999H5V15.9999ZM22 21.9999V17.4999C22 15.6378 20.5459 14.1153 18.7118 14.0056 18.8993 14.6376 19 15.307 19 15.9999V21.9999H22Z"></path></svg>

                        <span>Total Downlines:</span>
                        </div>
                        <strong class="text-overflow-ellipsis"> {{ number_format($data->downlines) }}</strong>
                    </div>
                      {{-- new row --}}
                     <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">

<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M3 12H7V21H3V12ZM17 8H21V21H17V8ZM10 2H14V21H10V2Z"></path></svg>

                        <span>All Time Investment Count:</span>
                        </div>
                        <strong class="text-overflow-ellipsis"> {{ number_format($data->investment_count) }}</strong>
                    </div>
                     {{-- new row --}}
                     <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">

<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M5 3V19H21V21H3V3H5ZM20.2929 6.29289L21.7071 7.70711L16 13.4142L13 10.415L8.70711 14.7071L7.29289 13.2929L13 7.58579L16 10.585L20.2929 6.29289Z"></path></svg>

                        <span>All Time Investment Amount:</span>
                        </div>
                        <strong class="text-overflow-ellipsis"> {{ $data->currency.number_format($data->investment_amount,2) }}</strong>
                    </div>
                    {{-- new row --}}
                     <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">

<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M2 13H8V21H2V13ZM9 3H15V21H9V3ZM16 8H22V21H16V8Z"></path></svg>

                        <span>Total Active Invesments:</span>
                        </div>
                        <strong class="text-overflow-ellipsis"> {{ number_format($data->active_investments) }}</strong>
                    </div>
                     {{-- new row --}}
                    <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">

<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M11 2.04935V13H21.9506C21.4489 18.0533 17.1853 22 12 22C6.47715 22 2 17.5228 2 12C2 6.81462 5.94668 2.55107 11 2.04935ZM13 0.542847C18.5535 1.02121 22.9788 5.4465 23.4571 11H13V0.542847Z"></path></svg>

                        <span>Total Active Invesments Amount:</span>
                        </div>
                        <strong class="text-overflow-ellipsis"> {{ $data->currency.number_format($data->active_investments_amount,2) }}</strong>
                    </div>
                     {{-- new row --}}
                    <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">

<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3ZM16.9 13H11V7.10002C8.71776 7.56329 7 9.58104 7 12C7 14.7614 9.23858 17 12 17C14.419 17 16.4367 15.2822 16.9 13ZM16.9 11C16.5023 9.04087 14.9591 7.4977 13 7.10002V11H16.9Z"></path></svg>
                        <span>Total Daily Income:</span>
                        </div>
                        <strong class="text-overflow-ellipsis"> {{ $data->currency.number_format($data->total_daily_income,2) }}</strong>
                    </div>
                     {{-- new row --}}
                    <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">

<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M16 16C17.6569 16 19 17.3431 19 19C19 20.6569 17.6569 22 16 22C14.3431 22 13 20.6569 13 19C13 17.3431 14.3431 16 16 16ZM6 12C8.20914 12 10 13.7909 10 16C10 18.2091 8.20914 20 6 20C3.79086 20 2 18.2091 2 16C2 13.7909 3.79086 12 6 12ZM14.5 2C17.5376 2 20 4.46243 20 7.5C20 10.5376 17.5376 13 14.5 13C11.4624 13 9 10.5376 9 7.5C9 4.46243 11.4624 2 14.5 2Z"></path></svg>
                        <span>Total Deposit:</span>
                        </div>
                        <strong class="text-overflow-ellipsis"> {{ $data->currency.number_format($data->total_deposit,2) }}</strong>
                    </div>
                   {{-- new row --}}
                    <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">

<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M10.9999 2.04938L11 5.07088C7.6077 5.55612 5 8.47352 5 12C5 15.866 8.13401 19 12 19C13.5723 19 15.0236 18.4816 16.1922 17.6064L18.3289 19.7428C16.605 21.1536 14.4014 22 12 22C6.47715 22 2 17.5228 2 12C2 6.81468 5.94662 2.55115 10.9999 2.04938ZM21.9506 13.0001C21.7509 15.0111 20.9555 16.8468 19.7433 18.3283L17.6064 16.1922C18.2926 15.2759 18.7595 14.1859 18.9291 13L21.9506 13.0001ZM13.0011 2.04948C17.725 2.51902 21.4815 6.27589 21.9506 10.9999L18.9291 10.9998C18.4905 7.93452 16.0661 5.50992 13.001 5.07103L13.0011 2.04948Z"></path></svg>
                        <span>Total Withdrawn:</span>
                        </div>
                        <strong class="text-overflow-ellipsis"> {{ $data->currency.number_format($data->total_withdrawn,2) }}</strong>
                    </div>
                     {{-- new row --}}
                    <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">

<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM11 7V17H13V7H11ZM15 11V17H17V11H15ZM7 13V17H9V13H7Z"></path></svg>
                        <span>Last Deposit:</span>
                        </div>
                        <strong class="text-overflow-ellipsis"> {{ $data->currency.number_format($data->last_deposit,2) }}</strong>
                    </div>
                    {{-- new row --}}
                    <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">

<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M9.99945 11H2.04883C2.55055 5.94668 6.8141 2 11.9995 2C17.5223 2 21.9995 6.47715 21.9995 12C21.9995 17.5228 17.5223 22 11.9995 22C6.8141 22 2.55055 18.0533 2.04883 13H9.99945V16L14.9995 12L9.99945 8V11Z"></path></svg>
                        <span>Last Login:</span>
                        </div>
                        <strong class="text-overflow-ellipsis"> {{ $data->last_login }}</strong>
                    </div>

            {{-- action buttons --}}
                 <div class="w-full row align-center flex-wrap g-10px">
                    <button style="background:#2363dd;color:white;box-shadow:0 0 10px rgba(0,0,0,0.2);clip-path:none;" onclick="window.open('{{ url('admins/login/as/user?user_id='.$data->id.'') }}')" class="btn-green">

                        Login as User
                    </button>
                     @if ($data->status == 'active')
                         <button onclick="window.location.href='{{ url('admins/ban/user?user_id='.$data->id.'') }}'" class="btn-red">

                            Ban User
                    </button>
                     @else
                         <button onclick="window.location.href='{{ url('admins/unban/user?user_id='.$data->id.'') }}'" class="btn-green">

                            UnBan User
                    </button>
                     @endif
                 {{-- action buttons --}}
                    <button style="background:black;" onclick="window.location.href='{{ url('admins/transactions?user_id='.$data->id.'') }}'" class="btn-blue br-5px">
                        Transactions
                    </button>
                     <button style="background:#4caf50;" onclick="window.location.href='{{ url('admins/packages/investment/records?user_id='.$data->id.'') }}'" class="btn-blue br-5px">
                       Investments
                    </button>
                    @if ($data->type == 'user')
                        <button onclick="window.location.href='{{ url('admins/user/mark/as/promoter?user_id='.$data->id.'') }}'" class="btn-primary br-5px">

                        Mark as Promoter
                    </button>
                    @else
                        <button style="background:purple;color:white;" onclick="window.location.href='{{ url('admins/user/mark/as/promoter?user_id='.$data->id.'') }}'" class="btn-gold br-5px">

                        UnMark as Promoter
                    </button>
                    @endif
                  <button x-on:click="ResetOverlay = true" style="background:#700101" class="br-5px btn-primary p-10px w-fit row align-center justify-center">
                    Reset Password
                  </button>
                   </div>
                    
                  </div>
                  <section x-show="ResetOverlay" x-transition:enter-start="fade-enter" x-transition:enter-end="fade-enter-end" x-transition:leave-start="fade-leave" x-transition:leave-end="fade-leave-end" class="pos-fixed transition-all p-20px column align-center justify-center inset-0 bg-black-transparent z-index-3000">
                    <div x-on:click.outside="ResetOverlay = false;" style="width:90%;" class="column align-center w-full p-15px br-15px g-10px bg-light">
                        <div class="h-50px w-50px circle bg-primary primary-text column align-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 32 32">
  <g fill="currentColor">
    <path d="m23,13h-2v-6c-.008-2.748-2.252-4.992-5.003-5-2.745.008-4.989,2.252-4.997,5.003v5.997h-2v-6c.012-3.85,3.15-6.989,6.997-7,3.853.011,6.991,3.15,7.003,6.997v6.003Z" fill="currentColor" stroke-width="0"></path>
    <path d="m25,11H7c-2.206,0-4,1.794-4,4v12c0,2.206,1.794,4,4,4h18c2.206,0,4-1.794,4-4v-12c0-2.206-1.794-4-4-4Zm-8,11.837v3.163h-2v-3.163c-1.441-.433-2.5-1.757-2.5-3.337,0-1.93,1.57-3.5,3.5-3.5s3.5,1.57,3.5,3.5c0,1.58-1.059,2.903-2.5,3.337Z" stroke-width="0" fill="currentColor"></path>
  </g>
</svg>
                        </div>
                        {{-- new --}}
                        <strong class="font-size-1rem font-weight-900">Reset Login Password</strong>
                        <span class="text-center">Do you really want to reset this users login password? <br>
                            The users new password would be reset to <br><strong class="font-size-09 font-weight-900 c-primary">123456</strong>
                        </span>
                        <small class="c-red text-align-center">Only take this action if the user forgot his/her account password and please endeavour to send the new password to the user and encourage him/her to change it from his/her daahboard.</small>
                   <div class="row w-full align-center g-10px space-between">
                    <div class="w-full br-5px p-10px bg-black pointer c-white row align-center justify-center no-select">
                        No, Cancel
                    </div>
                     <div x-data="{ 
                        Resetting : false
                      }" x-on:click="
                      Resetting = true;
                     SendPostRequest('{{ url('admins/post/reset/user/pasword') }}',{
                        '_token' : '{{ @csrf_token() }}',
                        'user_id' : '{{ $data->id }}'
                     },function(response,error){
                        Resetting = false;
                        if(response){
                            let data=JSON.parse(response);
                           CreateNotify(data.status,data.message);
                           if(data.status == 'success'){
                            ResetOverlay = false;
                           }
                        }
                     })
                     " class="w-full br-5px p-10px bg-primary pointer primary-text row align-center justify-center no-select">
                        <span x-show="!Resetting" class="row w-fit align-center g-5px">
                            Yes, Reset
                        </span>
                        <span x-show="Resetting" class="row w-fit align-center g-5px">
                            <?xml version="1.0" encoding="utf-8"?><svg height="15" width="15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 2400 2400" xml:space="preserve"><g stroke-width="200" stroke-linecap="round" stroke="currentColor" fill="none" id="spinner"><line x1="1200" y1="600" x2="1200" y2="100"/><line opacity="0.5" x1="1200" y1="2300" x2="1200" y2="1800"/><line opacity="0.917" x1="900" y1="680.4" x2="650" y2="247.4"/><line opacity="0.417" x1="1750" y1="2152.6" x2="1500" y2="1719.6"/><line opacity="0.833" x1="680.4" y1="900" x2="247.4" y2="650"/><line opacity="0.333" x1="2152.6" y1="1750" x2="1719.6" y2="1500"/><line opacity="0.75" x1="600" y1="1200" x2="100" y2="1200"/><line opacity="0.25" x1="2300" y1="1200" x2="1800" y2="1200"/><line opacity="0.667" x1="680.4" y1="1500" x2="247.4" y2="1750"/><line opacity="0.167" x1="2152.6" y1="650" x2="1719.6" y2="900"/><line opacity="0.583" x1="900" y1="1719.6" x2="650" y2="2152.6"/><line opacity="0.083" x1="1750" y1="247.4" x2="1500" y2="680.4"/><animateTransform attributeName="transform" attributeType="XML" type="rotate" keyTimes="0;0.08333;0.16667;0.25;0.33333;0.41667;0.5;0.58333;0.66667;0.75;0.83333;0.91667" values="0 1199 1199;30 1199 1199;60 1199 1199;90 1199 1199;120 1199 1199;150 1199 1199;180 1199 1199;210 1199 1199;240 1199 1199;270 1199 1199;300 1199 1199;330 1199 1199" dur="0.83333s" begin="0s" repeatCount="indefinite" calcMode="discrete"/></g></svg>

                            Resetting...
                        </span>
                    </div>
                   </div>
                    </div>
                  </section>
                     {{--credit/debit wallet  --}}
                   <div style="border:1px solid var(--rgt-01)" class="column bg-light align-center w-full br-primary">
                     {{-- headings/prompt --}}
                    <div class="row p-20 no-select w-full">
                        <div onclick="MyFunc.SwitchForm(this,'.credit-form')" class="w-half wallet-heading p-y-10 active column align-center justify-center g-5">
                            <span class="title">Credit User</span>
                            <span class="bar"></span>
                        </div>
                         <div onclick="MyFunc.SwitchForm(this,'.debit-form')" class="w-half wallet-heading p-y-10 column align-center justify-center g-5">
                            <span class="title">Debit User</span>
                            <span class="bar"></span>
                        </div>
                    </div>
                    {{-- credit form --}}
                    <form style="padding-top:0;" action="{{ url('admins/post/credit/user/process') }}" onsubmit="PostRequest(event,this,MyFunc.Completed)" class="w-full active forms credit-form column g-10 p-20">
                       {{-- csrf token --}}
                       <input type="hidden" name="_token" value="{{ @csrf_token() }}" class="inp input">
                      {{-- user id --}}
                       <input type="hidden" name="user_id" value="{{ $data->id }}" class="inp input">
                       
                       {{-- new input --}}
                        <div class="w-full column g-5">
                            <label>Select Wallet</label>
                            <div class="cont">
                            <select name="wallet" class="inp input required">
                                <option value="" selected disabled>Choose Wallet....</option>
                               @foreach (Wallets() as $wallet)
                                   <option value="{{ $wallet->key }}">{{ $wallet->name }}</option>
                               @endforeach
                            </select>
                        </div>
                        </div>
                         {{-- new input --}}
                        <div class="w-full column g-5">
                            <label>Credit Amount({{ $data->currency }})</label>
                            <div class="cont">
                           <input name="amount" placeholder="E.g {{ $data->currency }}5,000" type="number" class="inp input required">
                        </div>
                        </div>
                        {{-- new input --}}
                        <div class="w-full title column g-5">
                            <label>Transaction Title</label>
                            <div class="cont">
                           <input name="title" placeholder="E.g Admin Bonus" type="text" class="inp">
                        </div>
                        </div>
                        
                        <label  class="row align-center w-full">
                            <input onchange="MyFunc.VerifyCheck(this)" type="checkbox">
                            <span>Log this Transaction</span>
                        </label>
                        <button class="post">Credit User</button>
                    </form>

                      {{-- debit form --}}
                    <form style="padding-top:0;" action="{{ url('admins/post/debit/user/process') }}" onsubmit="PostRequest(event,this,MyFunc.Completed)" class="w-full forms debit-form column g-10 p-20">
                       {{-- csrf token --}}
                       <input type="hidden" name="_token" value="{{ @csrf_token() }}" class="inp input">
                      {{-- user id --}}
                       <input type="hidden" name="user_id" value="{{ $data->id }}" class="inp input">
                       
                       {{-- new input --}}
                        <div class="w-full column g-5">
                            <label>Select Wallet</label>
                            <div class="cont">
                            <select name="wallet" class="inp input required">
                                <option value="" selected disabled>Choose Wallet....</option>
                               @foreach (Wallets() as $wallet)
                                   <option value="{{ $wallet->key }}">{{ $wallet->name }}</option>
                               @endforeach
                            </select>
                        </div>
                        </div>
                         {{-- new input --}}
                        <div class="w-full column g-5">
                            <label>Debit Amount({{ $data->currency }})</label>
                            <div class="cont">
                           <input name="amount" placeholder="E.g {{ $data->currency }}5,000" type="number" class="inp input required">
                        </div>
                        </div>
                        {{-- new input --}}
                        <div class="w-full title column g-5">
                            <label>Transaction Title</label>
                            <div class="cont">
                           <input name="title" placeholder="E.g Admin Bonus" type="text" class="inp">
                        </div>
                        </div>
                        
                        <label  class="row align-center w-full">
                            <input onchange="MyFunc.VerifyCheck(this)" type="checkbox">
                            <span>Log this Transaction</span>
                        </label>
                        <button class="post">Debit User</button>
                    </form>
                   </div>
                  
    </section>
@endsection
@section('js')
   <script class="js">
   window.MyFunc = {
    Restyle : function(){
         document.querySelectorAll('.wallet-heading .bar').forEach((data)=>{
        data.style.width=data.closest('.wallet-heading').querySelector('.title').getBoundingClientRect().width + 'px'
    });
    },
    SwitchForm : function(element,form_type){
        document.querySelectorAll('.wallet-heading').forEach((data)=>{
            data.classList.remove('active');
        });

        document.querySelectorAll('.forms').forEach((data)=>{
            data.classList.remove('active');
        });
        document.querySelector(form_type).classList.add('active');
        element.classList.add('active');
    },
    VerifyCheck : function(element){
      
         if(element.checked){
        
            element.closest('.forms').classList.add('log');
        //    alert(element.closest('.forms').querySelector('.title').innerHTML);
            element.closest('.forms').querySelector('.title .cont input').classList.add('input');
            element.closest('.forms').querySelector('.title .cont input').classList.add('required');
        }else{
            element.closest('.forms').classList.remove('log');
             element.closest('.forms').querySelector('.title .cont input').classList.remove('input');
            element.closest('.forms').querySelector('.title .cont input').classList.remove('required');
        }
       
    },
    Completed : function(response){
        let data=JSON.parse(response);
        if(data.status == 'success'){
            window.location.reload();
        }
    }
   }
   MyFunc.Restyle();
    </script> 
@endsection