@extends('layout.users.app')
@section('title')
    Share
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
            Bind Bank card
        </span>
        <span></span>
    </div>
@endsection
@section('main')
    <section  x-data="{ 
        Bankselected : false,
        BankOverlay : false,
        Bank : {
            Code : '',
            Name : ''
        },
        AccountVerified : false,
        AccountNumber : '',
        AccountName : '',
        IsChanged : 0,
        Verifying : false,
        VerifyError : false
      }" x-init="
     
      $watch('AccountNumber', (value) => {
        if(value.length == 10){
            IsChanged++;
        }
      });
      $watch('Bank.Code', (value) => {
        if(value != ''){
            IsChanged++;
        }
      });
      $watch('IsChanged', (value) => {
        if(Bank.Code != '' && AccountNumber.length == 10){
            Verifying = true;
            VerifyError = false;
            AccountVerified = false;
            AccountName = '';
            SendGetRequest('{{ url('users/get/korapay/bank/verify') }}',{
                'account_number' : AccountNumber,
                'bank_code' : Bank.Code
            },function(response,error){
                Verifying = false; 
              let data=JSON.parse(response);
              if(data.status == 'success'){
                AccountVerified = true;
                AccountName = data.message;
              }else{
                VerifyError= true;
              }

              if(error){
                CreateNotify('error','Internal server error, please try again')
              }
            });
        }
      })
      " class="w-full column g-10px">
         <form x-data="{ 
            Inputs : {

            },
            Saving : false
          }" method="POST" action="{{ url('users/post/add/bank/process') }}" x-on:submit.prevent="
          $el.querySelectorAll('input[name]').forEach((inp)=>{
            Inputs[inp.name] = inp.value;
          });
          Loading = true;
         SendPostRequest($el.action,Inputs,function(response){
          Loading = false;

                let data=JSON.parse(response);
                Inform.Status = data.status;
                Inform.Message = data.message;
                if(data.status == 'success'){
                    Vitecss.navigate('{{ $next ? url('users/withdraw') : url()->current() }}');
                
                }
            })" class="w-full column p-15px br-10px g-10px box-shadow">



            <div style="background:linear-gradient(to bottom right,#222,#666);color:white;box-shadow:0 0 5px rgba(0,0,0,0.9)" class="w-full p-15px br-10px column min-h-150px space-between g-10px">
             
                 {{-- new row --}}
                <div class="row align-center g-10px space-between">
                    <div class="column g-5px">
               <span style="text-shadow:1.5px 1.5px 0px black">{{ json_decode(Auth::guard('users')->user()->bank)->bank_name ?? '----' }}</span>
                 <span style="text-shadow:1.5px 1.5px 0px black" class="font-size-1rem">{{ json_decode(Auth::guard('users')->user()->bank)->account_number ?? '----' }}</span>
            
                    </div>
                    <img src="{{ asset('photos/chip-logo-removebg-preview.png') }}" alt="" class="no-pointer no-select h-40px">
                </div>
                <div style="text-shadow:1.5px 1.5px 0px black" class="row align-center g-10px m-top-auto">
                    Real Name: {{ json_decode(Auth::guard('users')->user()->bank)->account_name ?? '----' }}
                </div>
           
            </div>

               {{-- csrf token --}}
               <input type="hidden" class="input inp required" name="_token" value="{{ @csrf_token() }}">
               {{-- new input --}}
                <div x-bind:class="Verifying ? 'no-pointer' : ''" class="column g-5 w-full">
                 <label>Card Number</label>
                <div class="w-full bg-rgt-005 border-width-1px border-style-solid border-color-rgt-01 h-45px br-10px">
                    <input x-model="AccountNumber" name="account_number" placeholder="Please enter correct card number" inputmode="numeric" type="number" class="w-full border-none br-inherit c-text bg-transparent h-full w-full">
                </div>
               </div>
                {{-- new input --}}
                <div x-bind:class="Verifying ? 'no-pointer' : ''" class="column g-5 w-full">
                 <label>Bank</label>
                <div x-on:click="
                BankOverlay = true;
                " class="w-full bg-rgt-005 pos-relative border-width-1px border-style-solid border-color-rgt-01 h-45px br-10px">
                    <input type="hidden" x-bind:value="Bank.Name" name="bank_name" class="inp input required">
                <input type="hidden" x-bind:value="Bank.Code" name="bank_code" class="inp input required">
                 {{-- new --}}
                 <template x-if="!Bankselected">
                    <div class="row align-center h-full no-select opacity-07 p-10px w-full g-10px space-between">
                        <span>Select bank</span>
                        <i>
                            <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z"></path></svg>

                        </i>
                    </div>
                 </template>
                  <template x-if="Bankselected">
                    <div class="row align-center no-select h-full p-10px w-full g-10px space-between">
                        <span x-text="Bank.Name"></span>
                      
                    </div>
                 </template>
                  {{-- bank overlay --}}
                 <div x-on:click.outside="BankOverlay=false;" x-show="BankOverlay" x-data="{ 
                    Search : ''
                  }" style="max-height:50vh;" class="w-full pos-absolute top-full bg-light box-shadow z-index-3000 overflow-auto">
                    <div class="pos-sticky top-0 left-0 right-0 w-full bg-inherit p-10px">
                        <input x-model="Search" placeholder="Search by bank name..." type="search" class="w-full bg-rgt-005 border-width-1px border-style-solid border-color-rgt-01">
                    </div>
                    {{-- body --}}
                    <div class="column w-full">
                         @foreach (collect(json_decode(file_get_contents(database_path('data/banks.json'))))->sortBy('name') as $data)
                <div x-bind:style="'{{ $data->name }}'.includes(Search) ? {} : {
                    'display' : 'none'
                }" x-on:touchstart="$el.classList.add('bg-rgt-01')" x-on:touchend="$el.classList.remove('bg-rgt-01')" x-on:click.stop="
                Bank.Code = '{{ $data->code }}';
                Bank.Name = '{{ $data->name }}';
                BankOverlay=false;
                Bankselected = true;
                Search = '';
                " class="p-15px p-y-10px row align-center">
                    
                    <span class="font-size-07">{{ $data->name }}</span>
                </div>
            @endforeach
                        
                    </div>
                 </div>
                   </div>
               </div>
               
                 {{-- new --}}
               <div style="color:#4caf50;" x-show="Verifying" class="p-5px row align-center g-5px w-fit font-size-07 m-left-auto p-x-10px br-5px bg-green-transparent no-select no-pointer c-green font-weight-700">
               <?xml version="1.0" encoding="utf-8"?><svg height="15" width="15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 2400 2400" xml:space="preserve"><g stroke-width="200" stroke-linecap="round" stroke="currentColor" fill="none" id="spinner"><line x1="1200" y1="600" x2="1200" y2="100"/><line opacity="0.5" x1="1200" y1="2300" x2="1200" y2="1800"/><line opacity="0.917" x1="900" y1="680.4" x2="650" y2="247.4"/><line opacity="0.417" x1="1750" y1="2152.6" x2="1500" y2="1719.6"/><line opacity="0.833" x1="680.4" y1="900" x2="247.4" y2="650"/><line opacity="0.333" x1="2152.6" y1="1750" x2="1719.6" y2="1500"/><line opacity="0.75" x1="600" y1="1200" x2="100" y2="1200"/><line opacity="0.25" x1="2300" y1="1200" x2="1800" y2="1200"/><line opacity="0.667" x1="680.4" y1="1500" x2="247.4" y2="1750"/><line opacity="0.167" x1="2152.6" y1="650" x2="1719.6" y2="900"/><line opacity="0.583" x1="900" y1="1719.6" x2="650" y2="2152.6"/><line opacity="0.083" x1="1750" y1="247.4" x2="1500" y2="680.4"/><animateTransform attributeName="transform" attributeType="XML" type="rotate" keyTimes="0;0.08333;0.16667;0.25;0.33333;0.41667;0.5;0.58333;0.66667;0.75;0.83333;0.91667" values="0 1199 1199;30 1199 1199;60 1199 1199;90 1199 1199;120 1199 1199;150 1199 1199;180 1199 1199;210 1199 1199;240 1199 1199;270 1199 1199;300 1199 1199;330 1199 1199" dur="0.83333s" begin="0s" repeatCount="indefinite" calcMode="discrete"/></g></svg>

                Verifying...
               </div>
               </div>
               <div x-show="VerifyError" class="p-10px br-10px bg-red-transparent c-red no-select no-pointer">We could not verify this account, please check the details and try again</div>
              
              
                {{-- new input --}}
                <div x-show="AccountVerified" x-bind:class="Verifying ? 'no-pointer' : ''" class="column g-5 w-full">
                 <label>Real Name</label>
                <div class="w-full bg-rgt-005 border-width-1px border-style-solid border-color-rgt-01 h-45px br-10px">
                    <input readonly x-bind:value="AccountName" name="account_name" type="text" placeholder="Please enter correct card number" class="w-full border-none br-inherit c-text bg-transparent h-full w-full">
                </div>
               </div>
              
             <button style="background:linear-gradient(to right,var(--secondary),var(--secondary-light)) !important;" x-bind:class="!AccountVerified ? 'disabled' : ''" x-bind:style="!AccountVerified ? {
                'filter' : 'grayscale(100%)'
             } : {}" class="bg-secondary h-50px br-10px secondary-text no-select m-top-20px">
                Confirm
             </button>
            </form>
    </section>
@endsection