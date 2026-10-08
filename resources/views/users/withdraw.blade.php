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
            Withdraw
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

            },
            Saving : false
          }" method="POST" action="{{ url('users/post/withdraw/process') }}" x-on:submit.prevent="
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
                    Vitecss.navigate('{{ url('users/transactions?type=withdrawal') }}');
                
                }
            })" class="w-full column p-15px br-10px g-10px box-shadow">



          

               {{-- csrf token --}}
               <input type="hidden" class="input inp required" name="_token" value="{{ @csrf_token() }}">
              
              
               
               
              
              
                {{-- new input --}}
                <div class="column g-5 w-full">
                 <label>Withdrawal Amount</label>
                <div class="w-full bg-rgt-005 border-width-1px border-style-solid border-color-rgt-01 h-45px br-10px">
                    <input x-model="Amount" name="amount" type="number" inputmode="numeric" placeholder="Enter Amount" class="w-full border-none br-inherit c-text bg-transparent h-full w-full">
                </div>
               </div>
               <span>Balance: {{ Auth::guard('users')->user()->currency.number_format(Auth::guard('users')->user()->main_balance,2) }}</span>
              
             <button style="background:linear-gradient(to right,var(--secondary),var(--secondary-light)) !important;" x-bind:class="!AccountVerified ? 'disabled' : ''" x-bind:style="!AccountVerified ? {
                'filter' : 'grayscale(100%)'
             } : {}" class="bg-secondary h-50px br-10px secondary-text no-select m-top-20px">
                Withdraw <span x-text="'&#8358;' + FormatNumber(Amount)"></span>
             </button>
             <div x-show="Amount > 0" style="background:var(--secondary-005);border:1px solid var(--secondary-01);color:var(--secondary)" class="w-full br-5px column  bg-rgt-005 border-width-1px border-style-solid border-color-rgt-01 p-15px">
               <span>
                 Withdrawal Fee : {{ number_format($finance_settings->withdrawal->fee) }}%
               </span>
                <span>
                 You would receive : <span x-text="'&#8358;' + FormatNumber(Amount - ({{$finance_settings->withdrawal->fee }}*Amount)/100)"></span>
               </span>
             </div>
            </form>
            {{-- new --}}
             <div class="w-full bg-light box-shadow br-10px p-15px column g-10px">
             {{-- new row --}}
             <div class="row align-center g-10px space-between">
                <span>Real Name</span>
                <span>{{ json_decode(Auth::guard('users')->user()->bank)->account_name ?? '----' }}</span>
             </div>
             <div class="hr" vitecss-type="solid"></div>
              {{-- new row --}}
             <div class="row align-center g-10px space-between">
                <span>Bank</span>
                <span>{{ json_decode(Auth::guard('users')->user()->bank)->bank_name ?? '----' }}</span>
             </div>
             <div class="hr" vitecss-type="solid"></div>
                           {{-- new row --}}
             <div class="row align-center g-10px space-between">
                <span>Account Number</span>
                <span>{{ json_decode(Auth::guard('users')->user()->bank)->account_number ?? '----' }}</span>
             </div>
            <div x-on:click="Vitecss.navigate('{{ url('users/bank?next=withdrawal') }}')" class="w-full border-width-1px m-top-10px no c-secondary border-style-solid border-color-rgt-01 bg-rgt-005 br-10px h-50px row align-center justify-center g-10px">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
  <g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt"><path d="M24 32C28.4183 32 32 28.4183 32 24C32 19.5817 28.4183 16 24 16C19.5817 16 16 19.5817 16 24C16 28.4183 19.5817 32 24 32Z" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square" fill="none"></path> <path d="M45 26.2498V21.7502L39.9184 19.7178C39.5434 18.3184 38.9929 16.9955 38.285 15.7686L40.4388 10.7424L37.2576 7.56117L32.2314 9.71502C31.006 9.00707 29.6816 8.45811 28.2822 8.08164L26.2498 3H21.7502L19.7178 8.08164C18.3184 8.45661 16.9955 9.00707 15.7686 9.71502L10.7424 7.56117L7.56117 10.7424L9.71502 15.7686C9.00707 16.994 8.45811 18.3184 8.08164 19.7178L3 21.7502V26.2498L8.08164 28.2822C8.45661 29.6816 9.00707 31.0045 9.71502 32.2314L7.56117 37.2576L10.7424 40.4388L15.7686 38.285C16.994 38.9929 18.3184 39.5419 19.7178 39.9184L21.7502 45H26.2498L28.2822 39.9184C29.6816 39.5434 31.0045 38.9929 32.2314 38.285L37.2576 40.4388L40.4388 37.2576L38.285 32.2314C38.9929 31.006 39.5419 29.6816 39.9184 28.2822L45 26.2498Z" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square" fill="none"></path></g>
</svg>  
                Bind Bank Card
            </div>
           
            </div>
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
                        Minimum Withdrawal: &#8358;{{ number_format($finance_settings->withdrawal->minimum) }}
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
                    @php
                        use Carbon\Carbon;
                    @endphp
                    <span>
                        Withdrawal Time: {{ Carbon::parse($finance_settings->withdrawal->start_time)->format('H:i A') }} to {{ Carbon::parse($finance_settings->withdrawal->end_time)->format('H:i A') }}
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
                        Please carefully verify your withdrawal bank details before placing withdrawal
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
                        Once the withdrawal is complete, endeavour to share a screenshot of the successful withdrawal on our social media groups like telegram and whatsapp
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