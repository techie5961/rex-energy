@extends('layout.users.app')
@section('title')
   Deposit
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
          Deposit
        </span>
        <span></span>
    </div>
@endsection
@section('main')
    <section  x-data="{ 
        Amount : ''
      }" x-init="
     
     
      " class="w-full column g-10px">
         <form x-data="{ 
            Inputs : {
                channel : '{{ $gateways->keys()->first() }}'
            },
            Saving : false,
            Notify : false
          }" method="POST" action="{{ url('users/post/deposit/initiate/process') }}" x-on:submit.prevent="
        if(Amount == '' || Amount == 0){
            Notify = true;
            return;
        }
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
                    window.location.href=data.url;
                
                }
            })" class="w-full column p-15px br-10px g-10px box-shadow">



          

               {{-- csrf token --}}
               <input type="hidden" class="input inp required" name="_token" value="{{ @csrf_token() }}">
              
              
               
               
               {{-- new input --}}
                <div class="column g-5 w-full">
                 <label>Select Channel</label>
              <div class="row g-10px align-center flex-wrap">
                 @foreach ($gateways as $key => $data)
                   <div x-bind:style="Inputs.channel != '{{ $key }}' ? {
                    'border' : '1px solid var(--rgt-01)',
                    'background' : 'var(--rgt-005)'
                   } : {
                    'border' : '1px solid rgb(76, 175, 80,0.5)',
                    'background' : 'rgb(76, 175, 80,0.1)'
                   }" x-on:click="Inputs.channel = '{{ $key }}'" class="w-fit pos-relative column br-5px">
                       
                         <i x-show="Inputs.channel == '{{ $key }}'" class="pos-absolute top-0 right-0 c-green" style=";transform:translateY(-30%);height:fit-content !important;">
<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 20 20">
  <g fill="currentColor">
    <path d="m17.999,10c0-1.097-.567-2.113-1.465-2.707.215-1.054-.103-2.174-.878-2.95-.775-.776-1.896-1.094-2.95-.878-.593-.897-1.609-1.464-2.706-1.464s-2.113.567-2.706,1.464c-1.053-.216-2.174.102-2.95.878s-1.093,1.896-.878,2.949c-.897.593-1.465,1.61-1.465,2.707s.567,2.113,1.465,2.707c-.215,1.054.103,2.174.878,2.95s1.898,1.092,2.95.878c.593.897,1.609,1.464,2.706,1.464s2.113-.568,2.706-1.465c1.059.214,2.176-.103,2.95-.878.776-.776,1.094-1.896.878-2.95.897-.593,1.465-1.609,1.465-2.707Zm-4.218-1.875l-4,5c-.178.222-.442.358-.726.374-.019,0-.037.001-.056.001-.265,0-.52-.105-.707-.293l-2-2c-.391-.391-.391-1.023,0-1.414s1.023-.391,1.414,0l1.21,1.21,3.302-4.127c.347-.43.975-.502,1.406-.156.431.345.501.974.156,1.405Z" stroke-width="0" fill="currentColor"></path>
  </g>
</svg>
                    </i>
                    <span class="p-10px w-full align-center justify-center">
                            Channel - {{ $loop->iteration }}
                        </span>
                  
                   </div>
               @endforeach
              </div>
               </div>
              
                {{-- new input --}}
                <div class="column g-5 w-full">
                 <label>Deposit Amount</label>
                <div class="w-full bg-rgt-005 border-width-1px border-style-solid border-color-rgt-01 h-45px br-10px">
                    <input x-on:input="Notify = false;" x-model="Amount" name="amount" type="number" inputmode="numeric" placeholder="Enter Amount" class="w-full border-none br-inherit c-text bg-transparent h-full w-full">
                </div>
                <small x-show="Notify && (Amount == '' || Amount == 0)" class="c-red">Please enter a valid deposit amount or select amount</small>
               </div>
               <span>Balance: {{ Auth::guard('users')->user()->currency.number_format(Auth::guard('users')->user()->deposit_balance,2) }}</span>
              
             <button style="background:linear-gradient(to right,var(--secondary),var(--secondary-light)) !important;" x-bind:class="!AccountVerified ? 'disabled' : ''" x-bind:style="!AccountVerified ? {
                'filter' : 'grayscale(100%)'
             } : {}" class="bg-secondary h-50px br-10px secondary-text no-select m-top-20px">
                Pay <span x-text="'&#8358;' + FormatNumber(Amount)"></span>
             </button>
           
            </form>
            {{-- new --}}
            @if (!$packages->isEmpty())
                 <div class="w-full bg-light box-shadow br-10px p-15px column g-10px">
        <span>Select Deposit Amount</span>
       <div style="grid-template-columns: repeat(auto-fit,minmax(100px,1fr))" class="w-full grid place-center g-10px">
         @foreach ($packages as $data)
            <div x-on:click="Amount = {{ $data->cost }}" x-bind:class="Amount != {{$data->cost}} ? 'bg-rgt-005 border-width-1px border-style-solid border-color-rgt-01 c-rgt-10' : 'bg-secondary secondary-text'" class="w-full row p-10px g-10px align-center justify-center">
                &#8358;{{ number_format($data->cost) }}
            </div>
        @endforeach
       </div>
           
            </div>
            @endif
             <div class="w-full bg-light box-shadow br-10px p-15px column g-10px">
                <div class="row g-5px">
                    <i class="c-green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 32 32">
  <g fill="currentColor">
    <path d="m16,1C7.729,1,1,7.729,1,16s6.729,15,15,15,15-6.729,15-15S24.271,1,16,1Zm-2.43,21.985l-5.984-5.985,1.414-1.414,4.43,4.429,9.437-11.423,1.542,1.273-10.838,13.119Z" stroke-width="0" fill="currentColor"></path>
  </g>
</svg>
                    </i>
                    <span>
                        The minimum deposit amount is &#8358;{{ number_format($packages[0]->cost ?? 0) }}
                    </span>
                </div>
                 <div class="row g-5px">
                    <i class="c-green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 32 32">
  <g fill="currentColor">
    <path d="m16,1C7.729,1,1,7.729,1,16s6.729,15,15,15,15-6.729,15-15S24.271,1,16,1Zm-2.43,21.985l-5.984-5.985,1.414-1.414,4.43,4.429,9.437-11.423,1.542,1.273-10.838,13.119Z" stroke-width="0" fill="currentColor"></path>
  </g>
</svg>
                    </i>
                   
                    <span>
                       Deposit Time 7 x 24 hours
                    </span>
                </div>
                  <div class="row g-5px">
                    <i class="c-green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 32 32">
  <g fill="currentColor">
    <path d="m16,1C7.729,1,1,7.729,1,16s6.729,15,15,15,15-6.729,15-15S24.271,1,16,1Zm-2.43,21.985l-5.984-5.985,1.414-1.414,4.43,4.429,9.437-11.423,1.542,1.273-10.838,13.119Z" stroke-width="0" fill="currentColor"></path>
  </g>
</svg>
                    </i>
                  
                    <span>
                        Please be sure to complete your deposit within the app, do not transfer funds to anyone who calls you.
                    </span>
                </div>
                 <div class="row g-5px">
                    <i class="c-green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 32 32">
  <g fill="currentColor">
    <path d="m16,1C7.729,1,1,7.729,1,16s6.729,15,15,15,15-6.729,15-15S24.271,1,16,1Zm-2.43,21.985l-5.984-5.985,1.414-1.414,4.43,4.429,9.437-11.423,1.542,1.273-10.838,13.119Z" stroke-width="0" fill="currentColor"></path>
  </g>
</svg>
                    </i>
                  
                    <span>
                       If you encounter any issues during the deposit process, please contact customer support immediately.
                    </span>
                </div>
                  <div class="row g-5px">
                    <i class="c-green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 32 32">
  <g fill="currentColor">
    <path d="m16,1C7.729,1,1,7.729,1,16s6.729,15,15,15,15-6.729,15-15S24.271,1,16,1Zm-2.43,21.985l-5.984-5.985,1.414-1.414,4.43,4.429,9.437-11.423,1.542,1.273-10.838,13.119Z" stroke-width="0" fill="currentColor"></path>
  </g>
</svg>
                    </i>
                  
                    <span>
                        Please do not disclose your app password to anyone
                    </span>
                </div>
             </div>
    </section>
@endsection