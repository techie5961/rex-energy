@extends('layout.admins.app')
@section('title')
    Manual deposit settings
@endsection
@section('main')
    <section x-data="{ 
        WithdrawalGateway : '{{ $gateways->withdrawal }}',
        DepositGateway : @js($gateways->deposit ?? [])
     }" class="w-full column g-10px">
         <div class="column bg-light p-15px br-15px box-shadow w-full g-5px">
            <div class="column g-5px">
          <strong class="desc font-weight-900 c-primary">Withdrawal Gateway</strong>
        <small class="opacity-07">Select the default gateway for withrawals, note that the selected would be used to process all withdrawals, if not manual , please ensure your API balance is sufficient enough else withdrawal wont go through.</small>
      </div>
      <div x-data="{ 

       }" style="grid-template-columns: repeat(auto-fit,minmax(min(50%,150px),1fr))" class="grid align-center w-full place-center g-10px">
  <span class="grid-full row w-full m-top-5px text-align-start">Server IP(For IP whitelisting)</span>   
  
     <div x-data="{ 
        ServerIP : '{{ $ip }}',
        Copied : false
       }" class="w-full grid-full row align-center g-10px br-10px border-width-1px border-style-solid border-color-rgt-01 p-10px h-50px">
    <span x-text="ServerIP"></span>
    <div x-on:click="
    copy(ServerIP);
    Copied = true;
    setTimeout(() => {
        Copied = false;
    }, 2000);
    " class="h-full m-left-auto perfect-square br-5px bg-primary primary-text column align-center g-10px justify-center">
<svg x-show="!Copied" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="16" width="16"><path d="M192,72V216a8,8,0,0,1-8,8H40a8,8,0,0,1-8-8V72a8,8,0,0,1,8-8H184A8,8,0,0,1,192,72Zm24-40H72a8,8,0,0,0,0,16H208V184a8,8,0,0,0,16,0V40A8,8,0,0,0,216,32Z"></path></svg>
        <svg x-show="Copied" viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="16" width="16"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM17.4571 9.45711L11 15.9142L6.79289 11.7071L8.20711 10.2929L11 13.0858L16.0429 8.04289L17.4571 9.45711Z"></path></svg>

    </div>
      </div>
      {{-- new --}}
        <div x-on:click="
        WithdrawalGateway = 'manual';
            SendPostRequest('{{ url('admins/post/change/withdrawal/gateway') }}',{
                '_token' : '{{ @csrf_token() }}',
                'gateway' : 'manual'
            },function(response,error){
                let data=JSON.parse(response);
                CreateNotify(data.status,data.message)
            })
        " x-bind:class="WithdrawalGateway == 'manual' ? 'border-color-primary bg-primary-01' : 'border-color-rgt-01 bg-light'" class="border-width-1px border-style-solid no-select row w-full g-10px align-center br-10px p-15px">
            <div class="p-5px column align-center justify-center  w-30px circle no-shrink bg-primary primary-text">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M24 12L18.3431 17.6569L16.9289 16.2426L21.1716 12L16.9289 7.75736L18.3431 6.34315L24 12ZM2.82843 12L7.07107 16.2426L5.65685 17.6569L0 12L5.65685 6.34315L7.07107 7.75736L2.82843 12ZM9.78845 21H7.66009L14.2116 3H16.3399L9.78845 21Z"></path></svg>

            </div>
            <span class="font-weight-700">Manual</span>
        </div>
        {{-- new --}}
        <div x-on:click="
        WithdrawalGateway = 'nekpay';
            SendPostRequest('{{ url('admins/post/change/withdrawal/gateway') }}',{
                '_token' : '{{ @csrf_token() }}',
                'gateway' : 'nekpay'
            },function(response,error){
                let data=JSON.parse(response);
                CreateNotify(data.status,data.message)
            })
        " x-bind:class="WithdrawalGateway == 'nekpay' ? 'border-color-primary bg-primary-01' : 'border-color-rgt-01 bg-light'" class="border-width-1px border-style-solid no-select row w-full g-10px align-center br-10px p-15px">
            <div class="p-5px column align-center justify-center  w-30px circle no-shrink bg-primary primary-text">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M24 12L18.3431 17.6569L16.9289 16.2426L21.1716 12L16.9289 7.75736L18.3431 6.34315L24 12ZM2.82843 12L7.07107 16.2426L5.65685 17.6569L0 12L5.65685 6.34315L7.07107 7.75736L2.82843 12ZM9.78845 21H7.66009L14.2116 3H16.3399L9.78845 21Z"></path></svg>

            </div>
            <span class="font-weight-700">Nekpay</span>
        </div>
        {{-- new --}}
        <div x-on:click="
        WithdrawalGateway = 'kkpay';
            SendPostRequest('{{ url('admins/post/change/withdrawal/gateway') }}',{
                '_token' : '{{ @csrf_token() }}',
                'gateway' : 'kkpay'
            },function(response,error){
                let data=JSON.parse(response);
                CreateNotify(data.status,data.message)
            })
        " x-bind:class="WithdrawalGateway == 'kkpay' ? 'border-color-primary bg-primary-01' : 'border-color-rgt-01 bg-light'" class="border-width-1px border-style-solid no-select row w-full g-10px align-center br-10px p-15px">
            <div class="p-5px column align-center justify-center  w-30px circle no-shrink bg-primary primary-text">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M24 12L18.3431 17.6569L16.9289 16.2426L21.1716 12L16.9289 7.75736L18.3431 6.34315L24 12ZM2.82843 12L7.07107 16.2426L5.65685 17.6569L0 12L5.65685 6.34315L7.07107 7.75736L2.82843 12ZM9.78845 21H7.66009L14.2116 3H16.3399L9.78845 21Z"></path></svg>

            </div>
            <span class="font-weight-700">KKPay</span>
        </div>
      </div>
      
         </div>
          <div class="column bg-light p-15px br-15px box-shadow w-full g-5px">
            <div class="column g-5px">
          <strong class="desc font-weight-900 c-primary">Deposit Gateway</strong>
        <small class="opacity-07">Tap on each gateway to disable/enable it, upon disabling a gateway, users wont be able to recharge through that gateway.</small>
      </div>
      <div x-data="{ 

       }" style="grid-template-columns: repeat(auto-fit,minmax(min(50%,150px),1fr))" class="grid align-center w-full place-center g-10px">
      {{-- new --}}
        <div x-on:click="
        DepositGateway.manual = (DepositGateway.manual == 'active' ? 'inactive' : 'active');
            SendPostRequest('{{ url('admins/post/change/deposit/gateway') }}',{
                '_token' : '{{ @csrf_token() }}',
                'gateway' : 'manual',
                'status' : DepositGateway.manual

            },function(response,error){
                let data=JSON.parse(response);
                CreateNotify(data.status,data.message)
            })
        " x-bind:class="(DepositGateway.manual ?? 'active') == 'active' ? 'border-color-primary bg-primary-01' : 'border-color-rgt-01 bg-light'" class="pos-relative border-width-1px border-style-solid no-select row w-full g-10px align-center br-10px p-15px">
            <div class="p-5px column align-center justify-center  w-30px circle no-shrink bg-primary primary-text">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M24 12L18.3431 17.6569L16.9289 16.2426L21.1716 12L16.9289 7.75736L18.3431 6.34315L24 12ZM2.82843 12L7.07107 16.2426L5.65685 17.6569L0 12L5.65685 6.34315L7.07107 7.75736L2.82843 12ZM9.78845 21H7.66009L14.2116 3H16.3399L9.78845 21Z"></path></svg>

            </div>
            <span class="font-weight-700">Manual</span>
            <i x-show="(DepositGateway.manual ?? 'active') == 'active'" class="pos-absolute top-5px right-5px c-green">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="15" width="15"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM17.4571 9.45711L11 15.9142L6.79289 11.7071L8.20711 10.2929L11 13.0858L16.0429 8.04289L17.4571 9.45711Z"></path></svg>

            </i>
        </div>
        {{-- new --}}
        <div x-on:click="
        DepositGateway.nekpay = (DepositGateway.nekpay == 'active' ? 'inactive' : 'active');
            SendPostRequest('{{ url('admins/post/change/deposit/gateway') }}',{
                '_token' : '{{ @csrf_token() }}',
                'gateway' : 'nekpay',
                'status' : DepositGateway.nekpay

            },function(response,error){
                let data=JSON.parse(response);
                CreateNotify(data.status,data.message)
            })
        " x-bind:class="(DepositGateway.nekpay ?? 'active') == 'active' ? 'border-color-primary bg-primary-01' : 'border-color-rgt-01 bg-light'" class="pos-relative border-width-1px border-style-solid no-select row w-full g-10px align-center br-10px p-15px">
            <div class="p-5px column align-center justify-center  w-30px circle no-shrink bg-primary primary-text">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M24 12L18.3431 17.6569L16.9289 16.2426L21.1716 12L16.9289 7.75736L18.3431 6.34315L24 12ZM2.82843 12L7.07107 16.2426L5.65685 17.6569L0 12L5.65685 6.34315L7.07107 7.75736L2.82843 12ZM9.78845 21H7.66009L14.2116 3H16.3399L9.78845 21Z"></path></svg>

            </div>
            <span class="font-weight-700">Nekpay</span>
             <i x-show="(DepositGateway.nekpay ?? 'active') == 'active'" class="pos-absolute top-5px right-5px c-green">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="15" width="15"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM17.4571 9.45711L11 15.9142L6.79289 11.7071L8.20711 10.2929L11 13.0858L16.0429 8.04289L17.4571 9.45711Z"></path></svg>

            </i>
        </div>
        {{-- new --}}
        <div x-on:click="
        DepositGateway.kkpay = (DepositGateway.kkpay == 'active' ? 'inactive' : 'active');
            SendPostRequest('{{ url('admins/post/change/deposit/gateway') }}',{
                '_token' : '{{ @csrf_token() }}',
                'gateway' : 'kkpay',
                'status' : DepositGateway.kkpay
            },function(response,error){
                let data=JSON.parse(response);
                CreateNotify(data.status,data.message)
            })
        " x-bind:class="(DepositGateway.kkpay ?? 'active') == 'active' ? 'border-color-primary bg-primary-01' : 'border-color-rgt-01 bg-light'" class="pos-relative border-width-1px border-style-solid no-select row w-full g-10px align-center br-10px p-15px">
            <div class="p-5px column align-center justify-center  w-30px circle no-shrink bg-primary primary-text">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M24 12L18.3431 17.6569L16.9289 16.2426L21.1716 12L16.9289 7.75736L18.3431 6.34315L24 12ZM2.82843 12L7.07107 16.2426L5.65685 17.6569L0 12L5.65685 6.34315L7.07107 7.75736L2.82843 12ZM9.78845 21H7.66009L14.2116 3H16.3399L9.78845 21Z"></path></svg>

            </div>
            <span class="font-weight-700">KKPay</span>
             <i x-show="(DepositGateway.kkpay ?? 'active') == 'active'" class="pos-absolute top-5px right-5px c-green">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="15" width="15"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM17.4571 9.45711L11 15.9142L6.79289 11.7071L8.20711 10.2929L11 13.0858L16.0429 8.04289L17.4571 9.45711Z"></path></svg>

            </i>
        </div>
      </div>
      
         </div>
          <div class="column g-5px">
          <strong class="desc font-weight-900 c-primary">Bank Settings</strong>
        <small class="opacity-07">Manage and update your bank details for manual deposits</small>
      </div>
        <form x-data="{ 
         }" x-on:submit="
        PostRequest(event,$el,function(response){
            let data= JSON.parse(response);
            if(data.status == 'success'){
                window.location.reload();
            }
        })
        " action="{{ url('admins/post/manual/deposit/bank/settings/process') }}" method="POST" class="w-full column bg-light box-shadow br-15px p-20px g-10px">
         {{-- csrf token --}}
         <input name="_token" type="hidden" value="{{ @csrf_token() }}" class="inp input required">
         {{-- new input --}}
            <div class="w-full column g-5px">
                <label>Account Number</label>
                <div class="cont">
                    <input value="{{ $bank_settings->account_number ?? '' }}" name="account_number" type="number" inputmode="numeric" placeholder="Enter account number" class="inp input required">
                </div>
            </div>
             {{-- new input --}}
            <div class="w-full column g-5px">
                <label>Bank Name</label>
                <div class="cont">
                    <input value="{{ $bank_settings->bank_name ?? '' }}" name="bank_name" type="text" placeholder="Enter bank name" class="inp input required">
                </div>
            </div>
             {{-- new input --}}
            <div class="w-full column g-5px">
                <label>Account Name</label>
                <div class="cont">
                    <input value="{{ $bank_settings->account_name ?? '' }}" name="account_name" type="text" placeholder="Enter account name" class="inp input required">
                </div>
            </div>
            
           
            <button class="post">Save</button>
        </form>

         <div class="column g-5px">
          <strong class="desc font-weight-900 c-primary">Crypto/USDT Settings</strong>
        <small class="opacity-07">Manage and update your USDT adress for crypto deposits</small>
      </div>
        <form x-data="{ 
         }" x-on:submit="
        PostRequest(event,$el,function(response){
            let data= JSON.parse(response);
            if(data.status == 'success'){
                window.location.reload();
            }
        })
        " action="{{ url('admins/post/crypto/settings/process') }}" method="POST" class="w-full column bg-light box-shadow br-15px p-20px g-10px">
         {{-- csrf token --}}
         <input name="_token" type="hidden" value="{{ @csrf_token() }}" class="inp input required">
         {{-- new input --}}
            <div class="w-full column g-5px">
                <label>USDT Wallet Address</label>
                <div class="cont">
                    <input value="{{ $crypto_settings->address ?? '' }}" name="address" type="text" placeholder="Enter wallet address" class="inp input required">
                </div>
            </div>
             {{-- new input --}}
            <div class="w-full column g-5px">
                <label>Network</label>
                <div class="cont">
                    <input value="{{ $crypto_settings->network ?? '' }}" name="network" type="text" placeholder="Eg TRC-20" class="inp input required">
                </div>
            </div>
           
           
            <button class="post">Save</button>
        </form>
    </section>
@endsection