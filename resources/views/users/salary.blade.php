@extends('layout.users.app')
@section('title')
   Salary
@endsection
@section('header')
    <div class="w-full pc-x-padding row align-center space-between bg-primary primary-text p-15px">
        <i x-on:click="Vitecss.navigate('{{ url()->previous() }}')">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 18 18">
  <g fill="currentColor">
    <path d="M11.5 16C11.308 16 11.116 15.9271 10.97 15.7801L4.71999 9.53005C4.42699 9.23705 4.42699 8.76202 4.71999 8.46902L10.97 2.21999C11.263 1.92699 11.738 1.92699 12.031 2.21999C12.324 2.51299 12.324 2.98803 12.031 3.28103L6.311 9.001L12.031 14.721C12.324 15.014 12.324 15.489 12.031 15.782C11.885 15.928 11.693 16.002 11.501 16.002L11.5 16Z" fill="currentColor"></path>
  </g>
</svg>
        </i>
        <span class="font-weight-700 font-size-1rem">
           Salary Tasks
        </span>
        <span></span>
    </div>
@endsection
@section('main')
    <section  x-data="{ 
      }" x-init="
     
     
      " class="w-full column g-10px">
        <div style="background:linear-gradient(to right,var(--secondary),var(--primary))" class="w-full primary-text text-shadow br-10px p-15px">
Invite friends to join by sharing investment links, complete cumulative tasks and claim high rewards.
        </div>
              @if (!$salary->isEmpty())
              <div style="grid-template-columns:repeat(auto-fit,minmax(min(100%,400px),1fr))" class="w-full grid g-10px place-center">
                 @foreach ($salary as $data)
                   <div x-data="{ 
                    Processing : false
                    }" class="pos-relative bg-secondary p-5px br-10px row w-full">
                     <div class="p-10px column h-full bg-secondary align-center justify-center">
                        <img src="{{ asset(config('settings.logo')) }}" alt="" class="h-50px w-50px">
                    </div> 
                    <div class="flex-auto bg-light br-inherit column g-5px p-10px">
                        {{-- new row --}}
                        <div class="w-full row align-center g-10px space-between">
                            <strong class="font-size-1rem font-weight-900">Team Task - {{ $loop->iteration }}</strong>
                        @if ($data->earned == 1)
                        <span class="c-green uppercase no-select font-weight-800">Completed</span>
                            @else
                             <button x-on:click="Vitecss.navigate('{{ url('users/invite') }}')" class="no-border no-select pc-pointer font-size-06rem br-5px bg-primary primary-text p-2px p-x-20px">
                            Share
                        </button>
                        @endif
                           
                        </div>
                        {{-- new row --}}
                        <div class="w-full font-size-07rem row align-center g-10px">
                            <span>Bonus</span>
                            <strong class="font-weight-900 c-green">+&#8358;{{ number_format($data->reward) }}</strong>
                        </div>
                       <div class="row align-center w-full space-between">
                         <div class="w-fit p-x-10px font-size-06rem br-1000px p-4px bg-rgt-01">
                          {{ number_format(min($ref,$data->referrals)) }} / {{ number_format($data->referrals) }} active referrals
                        </div>
                          @if (round((min($ref,$data->referrals) * 100)/$data->referrals) >= 100 && $data->earned == 0)
                  
                        <button x-data="{  }" x-on:click="
                        Processing = true;
                        SendGetRequest('{{ url('users/get/claim/salary') }}',{
                            'id' : '{{ $data->id }}'
                        },function(response,error){
                            Processing = false;
                            if(error){
                                alert(error);
                            }
                            if(response){
                                let data=JSON.parse(response);
                                CreateNotify(data.status,data.message);
                                if(data.status == 'success'){
                                    Vitecss.navigate('{{ url()->current() }}');
                                }
                            }
                        })
                        " x-text="Processing ? 'Claiming...' : 'claim'" x-bind:class="Processing ? 'disabled' : ''" class="no-border no-select pc-pointer font-size-07rem font-weight-900 box-shadow text-shadow uppercase br-5px bg-green c-white p-2px p-x-20px">
                            Claim
                        </button>
                        @endif
                       </div>
                    </div>
                 
                </div>
               @endforeach 
              </div>
            @endif
    </section>
@endsection