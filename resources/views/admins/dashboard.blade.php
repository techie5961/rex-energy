@extends('layout.admins.app')
@section('title')
  Dashboard    
@endsection
@section('css')
    <style class="css">
       .analytic{
        user-select: none;
        
       }
    </style>
@endsection
@section('main')
    <section class="w-full column g-10">
     <div class="column g-5">
          <strong class="font-1-5 font-weight-900 c-primary">Welcome back, {{ ucfirst(Auth::guard('admins')->user()->tag) }}</strong>
   <span class="c-primary">Here's what's happening today.</span>

    </div> 
    {{-- total users --}}
    <div onclick="window.location.href='{{ url('admins/users') }}'" style="border:1px solid var(--primary-02)" class="w-full analytic bg-light p-20 br-primary column g-10">
        <div class="row g-10 align-center space-between w-full">
            <span>Total Users</span>
            <span class="c-primary opacity-02">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M12 11C14.7614 11 17 13.2386 17 16V22H15V16C15 14.4023 13.7511 13.0963 12.1763 13.0051L12 13C10.4023 13 9.09634 14.2489 9.00509 15.8237L9 16V22H7V16C7 13.2386 9.23858 11 12 11ZM5.5 14C5.77885 14 6.05009 14.0326 6.3101 14.0942C6.14202 14.594 6.03873 15.122 6.00896 15.6693L6 16L6.0007 16.0856C5.88757 16.0456 5.76821 16.0187 5.64446 16.0069L5.5 16C4.7203 16 4.07955 16.5949 4.00687 17.3555L4 17.5V22H2V17.5C2 15.567 3.567 14 5.5 14ZM18.5 14C20.433 14 22 15.567 22 17.5V22H20V17.5C20 16.7203 19.4051 16.0796 18.6445 16.0069L18.5 16C18.3248 16 18.1566 16.03 18.0003 16.0852L18 16C18 15.3343 17.8916 14.694 17.6915 14.0956C17.9499 14.0326 18.2211 14 18.5 14ZM5.5 8C6.88071 8 8 9.11929 8 10.5C8 11.8807 6.88071 13 5.5 13C4.11929 13 3 11.8807 3 10.5C3 9.11929 4.11929 8 5.5 8ZM18.5 8C19.8807 8 21 9.11929 21 10.5C21 11.8807 19.8807 13 18.5 13C17.1193 13 16 11.8807 16 10.5C16 9.11929 17.1193 8 18.5 8ZM5.5 10C5.22386 10 5 10.2239 5 10.5C5 10.7761 5.22386 11 5.5 11C5.77614 11 6 10.7761 6 10.5C6 10.2239 5.77614 10 5.5 10ZM18.5 10C18.2239 10 18 10.2239 18 10.5C18 10.7761 18.2239 11 18.5 11C18.7761 11 19 10.7761 19 10.5C19 10.2239 18.7761 10 18.5 10ZM12 2C14.2091 2 16 3.79086 16 6C16 8.20914 14.2091 10 12 10C9.79086 10 8 8.20914 8 6C8 3.79086 9.79086 2 12 2ZM12 4C10.8954 4 10 4.89543 10 6C10 7.10457 10.8954 8 12 8C13.1046 8 14 7.10457 14 6C14 4.89543 13.1046 4 12 4Z"></path></svg>

            </span>
        </div>
        <strong class="desc font-weight-900">{{ number_format($total_users) }}</strong>
       
    </div>
     {{-- new users --}}
    <div onclick="window.location.href='{{ url('admins/users?new=true') }}'" style="border:1px solid var(--primary-02)" class="w-full analytic bg-light p-20 br-primary column g-10">
        <div class="row g-10 align-center space-between w-full">
            <span>New Users</span>
            <span class="c-primary opacity-02">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M14 14.252V16.3414C13.3744 16.1203 12.7013 16 12 16C8.68629 16 6 18.6863 6 22H4C4 17.5817 7.58172 14 12 14C12.6906 14 13.3608 14.0875 14 14.252ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11ZM18 17V14H20V17H23V19H20V22H18V19H15V17H18Z"></path></svg>
                </span>
        </div>
        <strong class="desc font-weight-900">{{ number_format($today_users) }}</strong>
       
    </div>
       {{-- new users --}}
    <div onclick="window.location.href='{{ url('admins/users?type=promoter') }}'" style="border:1px solid var(--primary-02)" class="w-full analytic bg-light p-20 br-primary column g-10">
        <div class="row g-10 align-center space-between w-full">
            <span>Total Promoters</span>
            <span class="c-green opacity-02">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M2 22C2 17.5817 5.58172 14 10 14C14.4183 14 18 17.5817 18 22H16C16 18.6863 13.3137 16 10 16C6.68629 16 4 18.6863 4 22H2ZM10 13C6.685 13 4 10.315 4 7C4 3.685 6.685 1 10 1C13.315 1 16 3.685 16 7C16 10.315 13.315 13 10 13ZM10 11C12.21 11 14 9.21 14 7C14 4.79 12.21 3 10 3C7.79 3 6 4.79 6 7C6 9.21 7.79 11 10 11ZM18.2837 14.7028C21.0644 15.9561 23 18.752 23 22H21C21 19.564 19.5483 17.4671 17.4628 16.5271L18.2837 14.7028ZM17.5962 3.41321C19.5944 4.23703 21 6.20361 21 8.5C21 11.3702 18.8042 13.7252 16 13.9776V11.9646C17.6967 11.7222 19 10.264 19 8.5C19 7.11935 18.2016 5.92603 17.041 5.35635L17.5962 3.41321Z"></path></svg>
                </span>
        </div>
        <strong class="desc font-weight-900">{{ number_format($total_promoters) }}</strong>
       
    </div>
      {{-- new users --}}
    <div onclick="window.location.href='{{ url('admins/packages/manage') }}'" style="border:1px solid var(--primary-02)" class="w-full analytic bg-light p-20 br-primary column g-10">
        <div class="row g-10 align-center space-between w-full">
            <span>Total Products</span>
            <span class="c-black opacity-02">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M20 3L22 7V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V7.00353L4 3H20ZM20 9H4V19H20V9ZM13 10V14H16L12 18L8 14H11V10H13ZM18.7639 5H5.23656L4.23744 7H19.7639L18.7639 5Z"></path></svg>
                </span>
        </div>
        <strong class="desc font-weight-900">{{ number_format($total_packages) }}</strong>
       
    </div>
      {{-- pending withdrawal --}}
    <div onclick="window.location.href='{{ url('admins/transactions?type=withdrawal&status=pending') }}'" style="border:1px solid var(--primary-02)" class="w-full analytic bg-light p-20 br-primary column g-10">
        <div class="row g-10 align-center space-between w-full">
            <span>Pending Withdrawals</span>
            <span class="c-gold opacity-02">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979ZM20.0049 10.9998H4.00488V18.9998H20.0049V10.9998ZM20.0049 8.99979V4.99979H4.00488V8.99979H20.0049ZM14.0049 14.9998H18.0049V16.9998H14.0049V14.9998Z"></path></svg>
              </span>
        </div>
        <strong class="desc font-weight-900">&#8358;{{ number_format($pending_withdrawals,2) }}</strong>
       
    </div>
     {{-- successfull withdrawals --}}
    <div onclick="window.location.href='{{ url('admins/transactions?type=withdrawal&status=success') }}'" style="border:1px solid var(--primary-02)" class="w-full analytic bg-light p-20 br-primary column g-10">
        <div class="row g-10 align-center space-between w-full">
            <span>Successfull Withdrawals</span>
            <span class="c-green opacity-02">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979ZM20.0049 10.9998H4.00488V18.9998H20.0049V10.9998ZM20.0049 8.99979V4.99979H4.00488V8.99979H20.0049ZM14.0049 14.9998H18.0049V16.9998H14.0049V14.9998Z"></path></svg>              </span>

        </div>
        <strong class="desc font-weight-900">&#8358;{{ number_format($successfull_withdrawals,2) }}</strong>
       
    </div>
      {{-- rejected withdrawals --}}
    <div onclick="window.location.href='{{ url('admins/transactions?type=withdrawal&status=rejected') }}'" style="border:1px solid var(--primary-02)" class="w-full analytic bg-light p-20 br-primary column g-10">
        <div class="row g-10 align-center space-between w-full">
            <span>Rejected Withdrawals</span>
            <span class="c-red opacity-02">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979ZM20.0049 10.9998H4.00488V18.9998H20.0049V10.9998ZM20.0049 8.99979V4.99979H4.00488V8.99979H20.0049ZM14.0049 14.9998H18.0049V16.9998H14.0049V14.9998Z"></path></svg>              </span>

        </div>
        <strong class="desc font-weight-900">&#8358;{{ number_format($rejected_withdrawals,2) }}</strong>
       
    </div>
      {{-- pending deposits --}}
    <div onclick="window.location.href='{{ url('admins/transactions?type=deposit&status=pending') }}'" style="border:1px solid var(--primary-02)" class="w-full analytic bg-light p-20 br-primary column g-10">
        <div class="row g-10 align-center space-between w-full">
            <span>Pending Deposits</span>
            <span class="c-gold opacity-02">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979ZM20.0049 11.9998H4.00488V18.9998H20.0049V11.9998ZM20.0049 7.99979V4.99979H4.00488V7.99979H20.0049Z"></path></svg>
              </span>
        </div>
        <strong class="desc font-weight-900">&#8358;{{ number_format($pending_deposits,2) }}</strong>
       
    </div>
      {{-- successfull deposits --}}
    <div onclick="window.location.href='{{ url('admins/transactions?type=deposit&status=success') }}'" style="border:1px solid var(--primary-02)" class="w-full analytic bg-light p-20 br-primary column g-10">
        <div class="row g-10 align-center space-between w-full">
            <span>Successfull Deposits</span>
            <span class="c-green opacity-02">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979ZM20.0049 11.9998H4.00488V18.9998H20.0049V11.9998ZM20.0049 7.99979V4.99979H4.00488V7.99979H20.0049Z"></path></svg>

            </span>
        </div>
        <strong class="desc font-weight-900">&#8358;{{ number_format($successfull_deposits,2) }}</strong>
       
    </div>
      {{-- rejected deposits --}}
    <div onclick="window.location.href='{{ url('admins/transactions?type=deposit&status=rejected') }}'" style="border:1px solid var(--primary-02)" class="w-full analytic bg-light p-20 br-primary column g-10">
        <div class="row g-10 align-center space-between w-full">
            <span>Rejected Deposits</span>
            <span class="c-red opacity-02">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979ZM20.0049 11.9998H4.00488V18.9998H20.0049V11.9998ZM20.0049 7.99979V4.99979H4.00488V7.99979H20.0049Z"></path></svg>
              </span>

        </div>
        <strong class="desc font-weight-900">&#8358;{{ number_format($rejected_deposits,2) }}</strong>
       
    </div>
    </section>
@endsection