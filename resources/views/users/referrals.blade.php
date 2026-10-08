@extends('layout.users.app')
@section('title')
    Dashboard
@endsection
@section('css')
    <style class="css">
        header img.banner{
            max-height:200px;
        }
    </style>
@endsection
@section('header')
    <div x-data="{ 
      MarginBottom : 0,
      Height : 0
     }" x-bind:style="{
        'min-height' : Height + 'px'
     }" style="min-height:251px" class="w-full pos-relative">
      <img x-on:load="Height = $el.offsetHeight" style="max-height:auto" src="{{ asset('banners/DFD3332F-9758-4568-A2DD-DE111FB28B3F-compressed.jpeg') }}" alt="" class="w-full banner no-select pos-absolute inset-0 z-index-3000 no-pointer">
  <div x-bind:style="{
        'min-height' : Height + 'px'
     }" class="pos-relative z-index-5000 p-20px column p-bottom-0 p-top-30px g-10px  top-0 left-0 right-0 z-index-500">
<div class="w-full row g-10px">

</div>
<div style="background:linear-gradient(to bottom,transparent,rgba(255,255,255,0.7),rgba(255,255,255,1));height:50%;transform:translateY(2px)" class="pos-absolute w-full column p-20px align-center bottom-0 left-0 right-0">
</div>
 <div style="transform:translateY(20%)" class="w-full pc-x-padding pos-relative h-full details-div g-10px m-top-auto primary-text br-10px row">

    {{-- new --}}
<div class="column g-10px br-10px bg-primary primary-text text-align-center overflow-hidden p-15px w-full align-center">
<span class="font-size-07rem ws-nowrap text-overflow-ellipsis">Team Deposit</span>
<strong class="font-size-1rem ws-nowrap text-overflow-ellipsis font-weight-900">&#8358;{{ number_format($team_deposit) }}</strong>
</div>
{{-- new --}}
<div class="column g-10px br-10px bg-primary primary-text text-align-center overflow-hidden p-15px w-full align-center">
<span class="font-size-07rem ws-nowrap text-overflow-ellipsis">Team Size</span>
<strong class="font-size-1rem ws-nowrap text-overflow-ellipsis font-weight-900">{{ number_format($team_size) }}</strong>
</div>

  </div>
  </div>
 
    </div>
@endsection
@section('main')
 <section class="w-full column g-10px">
    <div class="w-full bg-secondary secondary-text p-5px br-5px row align-center g-5px">
        <div x-on:click="Vitecss.navigate('{{ url('users/referrals') }}')" class="column {{ request('level','1') == 1 ? 'bg-white c-secondary' : '' }} p-10px w-full pc-pointer align-center g-5px br-inherit">
           <span> LV: 1</span>
           <small>Income: {{ number_format($referral_settings->level_1) }}%</small>
        </div>

         <div x-on:click="Vitecss.navigate('{{ url('users/referrals?level=2') }}')" class="column {{ request('level','1') == 2 ? 'bg-white c-secondary' : '' }} p-10px pc-pointer w-full align-center g-5px br-inherit">
           <span> LV: 2</span>
           <small>Income: {{ number_format($referral_settings->level_2) }}%</small>
        </div>

         <div x-on:click="Vitecss.navigate('{{ url('users/referrals?level=3') }}')" class="column {{ request('level','1') == 3 ? 'bg-white c-secondary' : '' }} p-10px pc-pointer w-full align-center g-5px br-inherit">
           <span> LV: 3</span>
           <small>Income: {{ number_format($referral_settings->level_3) }}%</small>
        </div>
    </div>
     @if ($referrals->isEmpty())
            @include('components.utilities',[
                'empty' => true,
                'text' => 'No referral yet',
                'icon' => '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="50" width="50"><path d="M12 10C14.2091 10 16 8.20914 16 6 16 3.79086 14.2091 2 12 2 9.79086 2 8 3.79086 8 6 8 8.20914 9.79086 10 12 10ZM5.5 13C6.88071 13 8 11.8807 8 10.5 8 9.11929 6.88071 8 5.5 8 4.11929 8 3 9.11929 3 10.5 3 11.8807 4.11929 13 5.5 13ZM21 10.5C21 11.8807 19.8807 13 18.5 13 17.1193 13 16 11.8807 16 10.5 16 9.11929 17.1193 8 18.5 8 19.8807 8 21 9.11929 21 10.5ZM12 11C14.7614 11 17 13.2386 17 16V22H7V16C7 13.2386 9.23858 11 12 11ZM5 15.9999C5 15.307 5.10067 14.6376 5.28818 14.0056L5.11864 14.0204C3.36503 14.2104 2 15.6958 2 17.4999V21.9999H5V15.9999ZM22 21.9999V17.4999C22 15.6378 20.5459 14.1153 18.7118 14.0056 18.8993 14.6376 19 15.307 19 15.9999V21.9999H22Z"></path></svg>'
            ])
        @else
            <div class="w-full grid place-center g-10 pc-grid-2">
                @foreach ($referrals as $data)
                    <div class="bg-light br-10px box-shadow column g-10px w-full p-15px">
                       <div class="w-full g-10px row">
                        <img src="{{ asset(config('settings.logo')) }}" alt="" class="h-50px circle w-50px no-shrink no-select no-pointer">
                       <div class="flex-auto g-5px column">
                        <small class="font-weight-800">Mobile : {{ '234****'.substr($data->phone,6,6) }}</small>
                        <div class="hr" vitecss-type="solid"></div>
                       <div class="row align-center w-full">
                         <small class="row w-full opacity-07">
                            Deposit : &#8358;{{ number_format($data->deposits) }}
                        </small>
                        <small class="row w-full opacity-07">
                            Withdraw : &#8358;{{ number_format($data->withdrawn) }}
                        </small>
                       </div>
                       <small class="opacity-07">
                        Time : {{ $data->time }}
                       </small>
                       </div>
                    </div>
                       
                    </div>
                @endforeach
            </div>
        @endif
          @if ($referrals->lastPage() > 1)
              @include('components.utilities',[
                'data' => $referrals,
                'paginate' => true
              ])
          @endif
 </section>
@endsection