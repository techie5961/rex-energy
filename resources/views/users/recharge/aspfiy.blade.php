@extends('layout.users.app')
@section('title')
    Recharge
@endsection
@section('main')
     <section class="w-full column">
       
        {{-- new section /body --}}
        <section class="section column w-full g-10px body">
            @isset(Auth::guard('users')->user()->paga_account)
                 {{-- new column --}}
            <div class="column max-w-500">
                <strong class="desc font-weight-900">Bank details</strong>
                <span class="opacity-07">Transfer money into the bank details below to recharge your account.</span>
            </div>
              <div class="w-full bg-light column align-center br-10px box-shadow p-15px">
                {{-- <img src="{{ asset('banners/IMG_7922.png?v=1.1') }}" alt="" class="w-100px"> --}}

               {{-- new --}}
               <div class="w-full g-5px br-5px border-bottom-width-1px border-bottom-color-rgt-01 border-bottom-style-dashed p-10px column">
               <span class="opacity-05 font-size-07">Account Number</span>
               <div class="row align-center g-10px">
               <strong class="font-size-1 font-weight-700">{{ json_decode(Auth::guard('users')->user()->paga_account)->account_number }}</strong>
                <span x-data="{ 
                    Copied : false
                 }" class="c-primary-light">
                    <svg x-on:click="
                    copy('{{ json_decode(Auth::guard('users')->user()->paga_account)->account_number }}');
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
               <div class="w-full br-5px g-5px border-bottom-width-1px border-bottom-color-rgt-01 border-bottom-style-dashed p-10px column">
               <span class="opacity-05 font-size-07">Bank</span>
               <div class="row align-center g-5px">
                <img src="{{ asset('banners/IMG_7927.png') }}" alt="" class="w-20px">
               <strong class="font-size-1 font-weight-700">{{ json_decode(Auth::guard('users')->user()->paga_account)->bank_name }}</strong>

               </div>
               </div>
                 {{-- new --}}
               <div class="w-full br-5px g-5px p-10px column">
               <span class="opacity-05 font-size-07">Account Name</span>
               <strong class="font-size-1 font-weight-700">{{ json_decode(Auth::guard('users')->user()->paga_account)->account_name }}</strong>
               </div>
               <div class="hr" vitecss-type="dotted"></div>
               <small class="opacity-07 m-top-5px text-center">Your account is automatically funded upon making a successfull transfer</small>
              </div>
            @else
            {{-- new column --}}
            <div class="column w-full max-w-500 m-x-auto">
                <strong class="desc font-weight-900">Create your bank account</strong>
                <span class="opacity-07">Fill the form below to create your payment bank account</span>
            </div>
              <form method="POST" action="{{ url('users/post/generate/paga/account/process') }}" onsubmit="PostRequest(event,this,Updated)" class="analytics p-20px column br-10px box-shadow w-full bg-light max-w-500 m-x-auto column g-10">
               <div class="column w-full align-center g-10 justify-center">
            </div>
                {{-- csrf token --}}
               <input type="hidden" class="input inp required" name="_token" value="{{ @csrf_token() }}">
                {{-- new input --}}
                <div class="column g-5 w-full">
                 <label>Enter First Name</label>
                <div class="cont">
                    <input name="first_name" placeholder="First name" type="text" class="inp input required">
                </div>
               </div>
               {{-- new input --}}
                <div class="column g-5 w-full">
                 <label>Enter Last Name</label>
                <div class="cont">
                    <input name="last_name" placeholder="Last name" type="text" class="inp input required">
                </div>
               </div>
               {{-- new input --}}
                <div class="column g-5 w-full">
                 <label>Enter Email Address</label>
                <div class="cont">
                    <input name="email" placeholder="Email address" type="email" class="inp input required">
                </div>
               </div>
                
             <button class="post">Create my account</button>
            </form>
            @endisset
          
        
            @isset(Auth::guard('users')->user()->paga_account)
                   {{-- group --}}
          <section class="group w-full box-shadow column g-10">
             

              {{-- new div --}}
            <div class="column w-full bg-light br-10 g-10 p-20">
                <strong class="font-1 font-weight-800">Recharge Instructions</strong>
               
                 {{-- new row --}}
                <div class="row g-5">
                    <i class="c-green">
                    <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="15" width="15"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM17.4571 9.45711L11 15.9142L6.79289 11.7071L8.20711 10.2929L11 13.0858L16.0429 8.04289L17.4571 9.45711Z"></path></svg>

                    </i>
                    <span>Copy the account details above and login to your mobile banking or ussd to make the transfer</span>
                </div>
                  {{-- new row --}}
                <div class="row g-5">
                    <i class="c-green">
                    <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="15" width="15"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM17.4571 9.45711L11 15.9142L6.79289 11.7071L8.20711 10.2929L11 13.0858L16.0429 8.04289L17.4571 9.45711Z"></path></svg>

                    </i>
                    <span>Transfer your recharge amount into the account details</span>
                </div>
                 
                 {{-- new row --}}
                <div class="row g-5">
                    <i class="c-green">
                    <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="15" width="15"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM17.4571 9.45711L11 15.9142L6.79289 11.7071L8.20711 10.2929L11 13.0858L16.0429 8.04289L17.4571 9.45711Z"></path></svg>

                    </i>
                    <span>Your wallet would be automatically updated on transfer success, Note that the deposit is automatic.</span>
                </div>
            </div>
          </section>
            @endisset
          
        </section>
      
    </section>

    
@endsection
@section('js')
    <script class="js">
        function Updated(response){
            let data=JSON.parse(response);
            if(data.status == 'success'){
                Redirect('{{ url()->current() }}');
            }
        }
    </script>
@endsection