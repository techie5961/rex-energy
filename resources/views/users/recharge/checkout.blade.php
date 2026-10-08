@extends('layout.users.app')
@section('title')
    Checkout
@endsection
@section('css')
    <style class="css">
        header,footer{
            display:none !important;
        }
        :root{
            --bg:whitesmoke;
            --bg-light:white;
            --text:black;
            --rgt:0,0,0;
            --rgb:255,255,255;
            --primary:#0057d9;
            --primary-005:rgb(0, 87, 217,0.05);
            --primary-007:rgb(0, 87, 217,0.07);
            --primary-01:rgb(0, 87, 217,0.1);
            --primary-02:rgb(0, 87, 217,0.2);
            --primary-03:rgb(0, 87, 217,0.3);
        }
        /* .notify.success{
            color:#4caf50 !important;
            border-color:#4caf50;
            background:black;
        } */
         .notify{
            background:black;
         }
    </style>
@endsection
@section('main')
<section x-data="{ 
    Overlay : false,
 }" x-init="
 $watch('Overlay', (value) => {
    if(value){
        document.body.classList.add('overflow-hidden');
    }else{
        document.body.classList.remove('overflow-hidden');

    }
 })
 " class="w-full flex-auto column g-10px">
    <section class="w-full align-center flex-auto column g-10px">
        <i class="m-x-auto opacity-03">
            <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="50" width="50"><path d="M2 20H22V22H2V20ZM4 12H6V19H4V12ZM9 12H11V19H9V12ZM13 12H15V19H13V12ZM18 12H20V19H18V12ZM2 7L12 2L22 7V11H2V7ZM12 8C12.5523 8 13 7.55228 13 7C13 6.44772 12.5523 6 12 6C11.4477 6 11 6.44772 11 7C11 7.55228 11.4477 8 12 8Z"></path></svg>

        </i>
          <div class="column align-center g-5px">
             <strong class="font-size-1-5 font-weight-900 m-x-auto">Pay {{ $CurrencyHelper::format($trx->amount,'NGN','NGN') }}</strong> 
         <small x-on:click="copy('{{ $CurrencyHelper::convert($trx->amount,'NGN',$display_currency) }}')" class="opacity-07 font-weight-800">Copy Amount
            <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="16" width="16"><path d="M6.9998 6V3C6.9998 2.44772 7.44752 2 7.9998 2H19.9998C20.5521 2 20.9998 2.44772 20.9998 3V17C20.9998 17.5523 20.5521 18 19.9998 18H16.9998V20.9991C16.9998 21.5519 16.5499 22 15.993 22H4.00666C3.45059 22 3 21.5554 3 20.9991L3.0026 7.00087C3.0027 6.44811 3.45264 6 4.00942 6H6.9998ZM8.9998 6H16.9998V16H18.9998V4H8.9998V6Z"></path></svg>

         </small>
          </div>
          
           <div style="background:rgb(218, 165, 32,0.2);color:rgb(109, 78, 1);" class="p-15px text-center font-weight-700 font-size-1 w-full max-w-500 br-10px no-select">
            Transfer exactly <u>{{ $CurrencyHelper::format($trx->amount,'NGN','NGN') }}</u> to the bank account below.
          </div>
           <div style="border:1px solid var(--primary)" class="w-full overflow-hidden bg-primary-007 column g-10px align-center br-10px">
         <div class="column align-center text-center g-10px w-full p-15px">
               {{-- new --}}
            <div class="column align-center">
                <small class="opacity-07">Bank name</small>
                <strong class="font-weight-700 font-size-1">{{ ucwords($bank_settings->bank_name) }}</strong>

            </div>
            {{-- new --}}
             <div class="column align-center">
                <small class="opacity-07">Account number</small>
            
           <div class="row align-center g-10px">
                <strong class="font-weight-800 font-size-1-2 c-primary">{{ ucwords($bank_settings->account_number) }}</strong>
          
          <span x-data="{ 
                    Copied : false
                 }" class="c-primary">
                    <svg x-on:click="
                    copy('{{ $trx->amount }}');
                    Copied = true;
                    setTimeout(() => {
                        Copied = false;
                    }, 2000);
                    " class="pc-pointer" x-show="!Copied" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M180,64H40A12,12,0,0,0,28,76V216a12,12,0,0,0,12,12H180a12,12,0,0,0,12-12V76A12,12,0,0,0,180,64ZM168,204H52V88H168ZM228,40V180a12,12,0,0,1-24,0V52H76a12,12,0,0,1,0-24H216A12,12,0,0,1,228,40Z"></path></svg>
                 <svg x-show="Copied" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M176.49,95.51a12,12,0,0,1,0,17l-56,56a12,12,0,0,1-17,0l-24-24a12,12,0,1,1,17-17L112,143l47.51-47.52A12,12,0,0,1,176.49,95.51ZM236,128A108,108,0,1,1,128,20,108.12,108.12,0,0,1,236,128Zm-24,0a84,84,0,1,0-84,84A84.09,84.09,0,0,0,212,128Z"></path></svg>

                </span>
           </div>
             </div>
            {{-- new --}}
             <div class="column align-center">
                <small class="opacity-07">Account name</small>
            
                <strong class="font-weight-600 font-size-09">{{ ucwords($bank_settings->account_name) }}</strong>
             </div>
         </div>
               
            <div style="background:var(--primary);color:white" class="w-full text-center bg-primary-02 p-15px">
                <small>Ensure to send the exact amount to avoid loss of funds</small>
            </div>
            </div>
           <div class="column m-top-auto text-center g-10px w-full">
             <span style="color:#708090;" class="font-weight-700 m-top-auto">Click the button after making transfer to the account details above</span>
            <button x-on:click="Overlay=true;" style="background:var(--primary);color:white;" class="p-10px min-h-50 m-top-auto br-1000px w-full border-none no-select pointer">I Have Paid</button>
           </div> 
    </section>
    <section x-on:click="Overlay=false;" x-show="Overlay" x-transition:enter-start="fade-enter transition-all" x-transition:enter-end="fade-enter-end transition-all" x-transition:leave-start="fade-leave transition-all" x-transition:leave-end="fade-leave-end transition-all"  class="w-full align-center justify-end z-index-3000 column pos-fixed inset-0 bg-black-transparent">
        <div x-on:click.stop="" x-show="Overlay" x-transition:enter-start="bottom-enter" x-transition:enter-end="bottom-enter-end" x-transition:leave-start="bottom-leave" x-transition:leave-end="bottom-leave-end" class="w-full transition-all column p-20px g-10px bg br-top-right-15px br-top-left-15px">
            <strong  class="font-size-1 c-primary font-weight-900">Complete Payment</strong>
            <div class="w-full border-top-width-1px border-top-style-solid border-top-color-primary"></div>
            <form x-data="{ 
                Inputs : {

                },
                Submittable : true,
                Submitting : false,
                Notify : {
                    Status : '',
                    Message : ''
                }
             }" x-on:submit.prevent="
             Notify.Status = '';
             Notify.Message = '';
             Submittable = true;
             $el.querySelectorAll('input[name]').forEach((inp)=>{
                inp.dispatchEvent(new Event('validate'));
                if(inp.type == 'file'){
                Inputs[inp.name] = inp.files[0];
                }else{
                    Inputs[inp.name] = inp.value;
                }
                
             });
             if(!Submittable){
                return;
             }
             Submitting = true;
             SendPostRequest($el.action,Inputs,function(response){
                Submitting = false;
                let data= JSON.parse(response);
                Notify.Status = data.status;
                Notify.Message = data.message;
                if(data.status == 'success'){
                    window.location.href='{{ url('users/transactions?type=deposit') }}'
                }
                
             });

            " method="POST" action="{{ url('users/post/deposit/checkout/process') }}" class="w-full column g-10px">
             <input type="hidden" class="inp input" name="_token" value="{{ @csrf_token() }}">
             <input type="hidden" class="inp input" name="id" value="{{ $id }}">
           <div x-show="Notify.Status != ''" x-text="Notify.Message" x-bind:class="Notify.Status == 'success' ? 'border-width-1px c-green border-style-solid border-color-green bg-green-transparent' : 'border-width-1px c-red border-style-solid border-color-red bg-red-transparent'" class="p-15px m-x-auto w-fit br-10px">

           </div>
             {{-- new input --}}
                <div x-data="{ 
                    InputEmpty : false
                 }" class="column w-full g-5px">
                    <label>Sender Name</label>
                    <div style="border:1px solid rgba(0,0,0,0.1);background:rgba(0,0,0,0.05)" class="cont">
                        <input x-on:validate="
                        if($el.value == ''){
                            InputEmpty = true;
                            Submittable = false;

                        }
                        " name="full_name" placeholder="Enter sender full name" type="text" class="inp h-40px input required">
                    </div>
                    <small x-show="InputEmpty" class="c-red">Please enter sender name</small>

                </div>
                 {{-- new input --}}
                <div x-data="{ 
                    InputEmpty : false
                 }" class="column w-full g-5px">
                    <label>Transfer receipt/screenshot</label>
                    <label  style="border:1px solid rgba(0,0,0,0.1);background:rgba(0,0,0,0.05);display:flex;flex-direction:column;align-items:center;justify-content:center;color:rgba(0,0,0,0.7);padding:10px;" class="cont p-10px column align-center justify-center h-150px">
                        <input x-on:validate="
                        if($el.files.length == 0){
                            InputEmpty = true;
                            Submittable = false;
                        }
                        " accept="image/*" name="receipt" x-on:change="PreviewPhoto($el,$el.closest('label'))" class="display-none inp input required" type="file">
                        <span>Tap to select</span>
                        <span>JPG,PNG or WEBP(MAX: 5MB)</span>
                    </label>
                    <small x-show="InputEmpty" class="c-red">Please attach screenshot of debit</small>
                </div>
                <div class="row align-center g-5px">
                    <span class="font-weight-700 m-top-20px justify-center w-fit m-x-auto row align-center g-5px font-size-07">
                        <svg class="c-primary" height="15" width="15" viewBox="0 0 135 140" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><rect y="10" width="15" height="120" rx="6"><animate attributeName="height" begin="0.5s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite"/><animate attributeName="y" begin="0.5s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite"/></rect><rect x="30" y="10" width="15" height="120" rx="6"><animate attributeName="height" begin="0.25s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite"/><animate attributeName="y" begin="0.25s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite"/></rect><rect x="60" width="15" height="140" rx="6"><animate attributeName="height" begin="0s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite"/><animate attributeName="y" begin="0s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite"/></rect><rect x="90" y="10" width="15" height="120" rx="6"><animate attributeName="height" begin="0.25s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite"/><animate attributeName="y" begin="0.25s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite"/></rect><rect x="120" y="10" width="15" height="120" rx="6"><animate attributeName="height" begin="0.5s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite"/><animate attributeName="y" begin="0.5s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite"/></rect></svg>

                        Submit the details to quickly confirm your transaction</span>
                </div>
                <button x-bind:class="Submitting ? 'disabled' : ''" class="w-full h-50px br-1000px border-none bg-primary c-white no-select pointer">
                    <template x-if="!Submitting">
                        <div>
                            Submit payment proof
                        </div>
                    </template>
                     <template x-if="Submitting">
                        <div class="row align-center g-5px justify-center">
                            <?xml version="1.0" encoding="utf-8"?><svg height="15" width="15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 2400 2400" xml:space="preserve"><g stroke-width="200" stroke-linecap="round" stroke="currentColor" fill="none" id="spinner"><line x1="1200" y1="600" x2="1200" y2="100"/><line opacity="0.5" x1="1200" y1="2300" x2="1200" y2="1800"/><line opacity="0.917" x1="900" y1="680.4" x2="650" y2="247.4"/><line opacity="0.417" x1="1750" y1="2152.6" x2="1500" y2="1719.6"/><line opacity="0.833" x1="680.4" y1="900" x2="247.4" y2="650"/><line opacity="0.333" x1="2152.6" y1="1750" x2="1719.6" y2="1500"/><line opacity="0.75" x1="600" y1="1200" x2="100" y2="1200"/><line opacity="0.25" x1="2300" y1="1200" x2="1800" y2="1200"/><line opacity="0.667" x1="680.4" y1="1500" x2="247.4" y2="1750"/><line opacity="0.167" x1="2152.6" y1="650" x2="1719.6" y2="900"/><line opacity="0.583" x1="900" y1="1719.6" x2="650" y2="2152.6"/><line opacity="0.083" x1="1750" y1="247.4" x2="1500" y2="680.4"/><animateTransform attributeName="transform" attributeType="XML" type="rotate" keyTimes="0;0.08333;0.16667;0.25;0.33333;0.41667;0.5;0.58333;0.66667;0.75;0.83333;0.91667" values="0 1199 1199;30 1199 1199;60 1199 1199;90 1199 1199;120 1199 1199;150 1199 1199;180 1199 1199;210 1199 1199;240 1199 1199;270 1199 1199;300 1199 1199;330 1199 1199" dur="0.83333s" begin="0s" repeatCount="indefinite" calcMode="discrete"/></g></svg>

                            Submitting payment proof
                        </div>
                    </template>
                </button>
            </form>
        </div>
    </section>
    </section>
@endsection