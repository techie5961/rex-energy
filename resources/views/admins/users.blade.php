@extends('layout.admins.app')
@section('title')
  {{ ucwords($status) }}  Users
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
    

    </style>
@endsection
@section('main')
    <section class="column g-10 w-full">
         {{-- analytic --}}
        <div style="border:1px solid var(--rgt-01)" class="p-20 w-full br-primary bg-light column g-10">
            <div class="row w-full g-10">
               <div class="h-50 perfect-square br-primary column align-center justify-center" style="border:1px solid #4caf50;background:rgba(0,255,0,0.1);color:#4caf50;">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M12 11C14.7614 11 17 13.2386 17 16V22H15V16C15 14.4023 13.7511 13.0963 12.1763 13.0051L12 13C10.4023 13 9.09634 14.2489 9.00509 15.8237L9 16V22H7V16C7 13.2386 9.23858 11 12 11ZM5.5 14C5.77885 14 6.05009 14.0326 6.3101 14.0942C6.14202 14.594 6.03873 15.122 6.00896 15.6693L6 16L6.0007 16.0856C5.88757 16.0456 5.76821 16.0187 5.64446 16.0069L5.5 16C4.7203 16 4.07955 16.5949 4.00687 17.3555L4 17.5V22H2V17.5C2 15.567 3.567 14 5.5 14ZM18.5 14C20.433 14 22 15.567 22 17.5V22H20V17.5C20 16.7203 19.4051 16.0796 18.6445 16.0069L18.5 16C18.3248 16 18.1566 16.03 18.0003 16.0852L18 16C18 15.3343 17.8916 14.694 17.6915 14.0956C17.9499 14.0326 18.2211 14 18.5 14ZM5.5 8C6.88071 8 8 9.11929 8 10.5C8 11.8807 6.88071 13 5.5 13C4.11929 13 3 11.8807 3 10.5C3 9.11929 4.11929 8 5.5 8ZM18.5 8C19.8807 8 21 9.11929 21 10.5C21 11.8807 19.8807 13 18.5 13C17.1193 13 16 11.8807 16 10.5C16 9.11929 17.1193 8 18.5 8ZM5.5 10C5.22386 10 5 10.2239 5 10.5C5 10.7761 5.22386 11 5.5 11C5.77614 11 6 10.7761 6 10.5C6 10.2239 5.77614 10 5.5 10ZM18.5 10C18.2239 10 18 10.2239 18 10.5C18 10.7761 18.2239 11 18.5 11C18.7761 11 19 10.7761 19 10.5C19 10.2239 18.7761 10 18.5 10ZM12 2C14.2091 2 16 3.79086 16 6C16 8.20914 14.2091 10 12 10C9.79086 10 8 8.20914 8 6C8 3.79086 9.79086 2 12 2ZM12 4C10.8954 4 10 4.89543 10 6C10 7.10457 10.8954 8 12 8C13.1046 8 14 7.10457 14 6C14 4.89543 13.1046 4 12 4Z"></path></svg>
                 </div>
                <div class="column g-5">
                    <span>Total Users</span>
                    <strong class="font-1 font-weight-900">{{ number_format($total_users) }}</strong>
                </div>
            </div>
        </div>
          {{-- analytic --}}
        <div style="border:1px solid var(--primary-01)" class="p-20 w-full br-primary bg-light column g-10">
            <div class="row w-full g-10">
               <div class="h-50 perfect-square br-primary column align-center justify-center" style="border:1px solid #4caf50;background:rgba(0,255,0,0.1);color:#4caf50;">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M12 10C14.2091 10 16 8.20914 16 6 16 3.79086 14.2091 2 12 2 9.79086 2 8 3.79086 8 6 8 8.20914 9.79086 10 12 10ZM5.5 13C6.88071 13 8 11.8807 8 10.5 8 9.11929 6.88071 8 5.5 8 4.11929 8 3 9.11929 3 10.5 3 11.8807 4.11929 13 5.5 13ZM21 10.5C21 11.8807 19.8807 13 18.5 13 17.1193 13 16 11.8807 16 10.5 16 9.11929 17.1193 8 18.5 8 19.8807 8 21 9.11929 21 10.5ZM12 11C14.7614 11 17 13.2386 17 16V22H7V16C7 13.2386 9.23858 11 12 11ZM5 15.9999C5 15.307 5.10067 14.6376 5.28818 14.0056L5.11864 14.0204C3.36503 14.2104 2 15.6958 2 17.4999V21.9999H5V15.9999ZM22 21.9999V17.4999C22 15.6378 20.5459 14.1153 18.7118 14.0056 18.8993 14.6376 19 15.307 19 15.9999V21.9999H22Z"></path></svg>


                </div>
                <div class="column g-5">
                    <span>Active Users</span>
                    <strong class="font-1 font-weight-900">{{ number_format($active_users) }}</strong>
                </div>
            </div>
        </div>
        {{-- analytic --}}
        <div style="border:1px solid var(--primary-01)" class="p-20 w-full br-primary bg-light column g-10">
            <div class="row w-full g-10">
               <div class="h-50 perfect-square br-primary column align-center justify-center" style="border:1px solid #4caf50;background:rgba(0,255,0,0.1);color:#4caf50;">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M17 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9V3H15V1H17V3ZM4 9V19H20V9H4ZM6 13H11V17H6V13Z"></path></svg>

                </div>
                <div class="column g-5">
                    <span>Today's Signups</span>
                    <strong class="font-1 font-weight-900">{{ number_format($today_signups) }}</strong>
                </div>
            </div>
        </div>

         {{-- search --}}
        <div style="border:1px solid var(--rgt-01);" class="w-full search br-primary p-20 bg-light">
            <div class="cont">
                <span class="h-full perfect-square column align-center no-shrink justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M232.49,215.51,185,168a92.12,92.12,0,1,0-17,17l47.53,47.54a12,12,0,0,0,17-17ZM44,112a68,68,0,1,1,68,68A68.07,68.07,0,0,1,44,112Z"></path></svg>

                </span>
                <input oninput="Search(this,'{{ url('admins/search/users?key=') }}' + this.value)" type="search" placeholder="Search by User ID,Phone Number,Username..." class="inp input">
            </div>
            <div class="child">
              
                
            </div>
        </div>
       
        @if ($users->isEmpty())
            @include('components.utilities',[
                'empty' => true,
                'text' => 'No Users Found'
            ])
        @else
         @if ($type == 'promoter')
            {{-- new row --}}
        <div class="row w-full flex-wrap g-10 align-center space-between">
            <button onclick="document.querySelector('.modal.credit').classList.add('active')" class="btn-green-3d">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11 11H7V13H11V17H13V13H17V11H13V7H11V11Z"></path></svg>

                Credit All Promoters
            </button>
            <button onclick="document.querySelector('.modal.debit').classList.add('active')" class="btn-red-3d">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM7 11V13H17V11H7Z"></path></svg>

                Debit All Promoters
            </button>
        </div>
        @endif
        
            <div class="w-full grid pc-grid-2 g-10">
                @foreach ($users as $data)
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
                        <strong onclick="window.location.href='{{ url('admins/user?id='.$data->ref ?? ''.'') }}'" class="text-overflow-ellipsis {{ $data->upline == 'None' ? 'no-pointer no-select' : 'c-primary u no-select pointer' }}"> {{ ucwords($data->upline) }}</strong>
                    </div>
                        {{-- new row --}}
                    <div class="row ws-nowrap text-overflow-ellipsis w-full align-center g-10">
                        <div class="row align-center g-4">

<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="14" width="14"><path d="M12 10C14.2091 10 16 8.20914 16 6 16 3.79086 14.2091 2 12 2 9.79086 2 8 3.79086 8 6 8 8.20914 9.79086 10 12 10ZM5.5 13C6.88071 13 8 11.8807 8 10.5 8 9.11929 6.88071 8 5.5 8 4.11929 8 3 9.11929 3 10.5 3 11.8807 4.11929 13 5.5 13ZM21 10.5C21 11.8807 19.8807 13 18.5 13 17.1193 13 16 11.8807 16 10.5 16 9.11929 17.1193 8 18.5 8 19.8807 8 21 9.11929 21 10.5ZM12 11C14.7614 11 17 13.2386 17 16V22H7V16C7 13.2386 9.23858 11 12 11ZM5 15.9999C5 15.307 5.10067 14.6376 5.28818 14.0056L5.11864 14.0204C3.36503 14.2104 2 15.6958 2 17.4999V21.9999H5V15.9999ZM22 21.9999V17.4999C22 15.6378 20.5459 14.1153 18.7118 14.0056 18.8993 14.6376 19 15.307 19 15.9999V21.9999H22Z"></path></svg>

                        <span>Total Downlines:</span>
                        </div>
                         <strong class="text-overflow-ellipsis"> {{ number_format($data->downlines) }}</strong>
                    </div>
                    <a href="{{ url('admins/user?id='.$data->id.'') }}" class="c-primary no-select">Click to View More...</a>
                    
                  </div>
                @endforeach
            </div>
             @if ($users->lastPage() > 1)
                    @include('components.utilities',[
                        'paginate' => true,
                        'data' => $users
                    ])
                @endif
        @endif
    </section>
    @if ($type == 'promoter')
         {{-- credit form --}}
    <section onclick="this.classList.remove('active');" class="modal credit">
        <div onclick="event.stopPropagation()" class="child">
            {{-- new row --}}
            <div class="row align-center g-5">
                <svg viewBox="0 0 24 24" fill="#4caf50" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11 11H7V13H11V17H13V13H17V11H13V7H11V11Z"></path></svg>

                <strong class="font-size-1">Credit All Promoters</strong>
            </div>
            <hr>
            <form action="{{ url('admins/post/credit/all/promoters/process') }}" method="POST" onsubmit="PostRequest(event,this,Completed)" class="w-full column g-10">
             {{-- csrf token --}}
             <input type="hidden" class="inp input" name="_token" value="{{ @csrf_token() }}">
                {{-- new input --}}
                <div class="column w-full g-5">
                    <label class="column g-2">
                        <span>Wallet</span>
                        <small class="opacity-07">Select wallet to credit</small>
                    </label>
                    <div class="cont">
                       <select name="wallet" class="inp input required">
                        <option value="" selected disabled>Select Wallet....</option>
                        <option value="main_balance">Main Wallet</option>
                        <option value="deposit_balance">Deposit Wallet</option>
                       </select>
                    </div>
                </div>
                 {{-- new input --}}
                <div class="column w-full g-5">
                    <label class="column g-2">
                        <span>Credit Amount</span>
                        <small class="opacity-07">Amount to credit all promoters</small>
                    </label>
                    <div class="cont">
                       <input type="number" name="amount" placeholder="Enter amount" inputmode="numeric" class="inp input required">
                    </div>
                </div>
                <small class="opacity-05">In cases where the promoters are more than 50, only the first 50 would be creditted</small>
                {{-- post btn --}}
                <button class="btn-green w-full m-top-10 h-50">Credit All Promoters</button>
            </form>
        </div>
    </section>
       {{-- debit form --}}
    <section onclick="this.classList.remove('active');" class="modal debit">
        <div onclick="event.stopPropagation()" class="child">
            {{-- new row --}}
            <div class="row align-center g-5">
<svg viewBox="0 0 24 24" fill="red" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM7 11V13H17V11H7Z"></path></svg>

                <strong class="font-size-1">Debit All Promoters</strong>
            </div>
            <hr>
            <form action="{{ url('admins/post/debit/all/promoters/process') }}" method="POST" onsubmit="PostRequest(event,this,Completed)" class="w-full column g-10">
             {{-- csrf token --}}
             <input type="hidden" class="inp input" name="_token" value="{{ @csrf_token() }}">
                {{-- new input --}}
                <div class="column w-full g-5">
                    <label class="column g-2">
                        <span>Wallet</span>
                        <small class="opacity-07">Select wallet to debit</small>
                    </label>
                    <div class="cont">
                       <select name="wallet" class="inp input required">
                        <option value="" selected disabled>Select Wallet....</option>
                        <option value="main_balance">Main Wallet</option>
                        <option value="deposit_balance">Deposit Wallet</option>
                       </select>
                    </div>
                </div>
                 {{-- new input --}}
                <div class="column w-full g-5">
                    <label class="column g-2">
                        <span>Debit Amount</span>
                        <small class="opacity-07">Amount to debit all promoters</small>
                    </label>
                    <div class="cont">
                       <input type="number" name="amount" placeholder="Enter amount" inputmode="numeric" class="inp input required">
                    </div>
                </div>
                <small class="opacity-05">In cases where the promoters are more than 50, only the first 50 would be debitted</small>
                {{-- post btn --}}
                <button class="btn-red w-full m-top-10 h-50">Debit All Promoters</button>
            </form>
        </div>
    </section>
    @endif
   
@endsection
@section('js')
    <script class="js">
        function Completed(response){
            let data=JSON.parse(response);
            if(data.status == 'success'){
                window.location.reload();
            }
        }
    </script>
@endsection