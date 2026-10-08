@extends('layout.users.app')
@section('title')
    Recharge
@endsection
@section('main')

    <section class="w-full column g-10px">
            <div class="row w-full g-10 align-center space-between">
               <i onclick="Redirect('{{ url()->previous() }}')" class="h-40px w-40px no-shrink no-select pointer circle bg-secondary secondary-text column align-center justify-center box-shadow">

                    <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"></path></svg>
                </i>
                <span class="font-weight-900 block font-1">Recharge</span>
                <span>

                </span>
           
            </div>
            <div class="w-full border-bottom-width-2px border-bottom-style-solid border-bottom-color-primary-light box-shadow bg-primary primary-text max-w-500 m-x-auto br-10 p-20 column g-10">
                <strong class="desc font-weight-900">{{ $CurrencyHelper::format(Auth::guard('users')->user()->deposit_balance,'NGN',$display_currency) }}</strong>
                <span class="opacity-07">Current Deposit balance</span>
            </div>
          
            {{-- new --}}
            <form x-data="{ 
                Amount : ''
             }" x-on:submit.prevent="PostRequest(event,$el,function(response){
                let data=JSON.parse(response);
                if(data.status == 'success'){
                    window.location.href=data.url;
                }
             })" action="{{ url('users/post/nekpay/deposit/initiate/process') }}" method="POST" class="w-full m-top-10px bg-light p-15px br-10px column g-10px">
                {{-- csrf token --}}
                <input type="hidden" class="inp input" name="_token" value="{{ @csrf_token() }}">
                {{-- new --}}
            <span>Payment Method</span>
            <div style="border-color:goldenrod;" class="w-full no-select pc-pointer g-10px row align-center p-20px max-w-500px br-10px m-x-auto border-width-1px border-style-solid border-color-gold bg-gold-transparent">
               <i style="color:goldenrod;">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M2 20H22V22H2V20ZM4 12H6V19H4V12ZM9 12H11V19H9V12ZM13 12H15V19H13V12ZM18 12H20V19H18V12ZM2 7L12 2L22 7V11H2V7ZM12 8C12.5523 8 13 7.55228 13 7C13 6.44772 12.5523 6 12 6C11.4477 6 11 6.44772 11 7C11 7.55228 11.4477 8 12 8Z"></path></svg>

               </i>
                <div class="row align-center m-right-auto g-10px">
                    <span>Gateway-1</span>
                    <small style="color:goldenrod" class="c-gold font-weight-700">Recommended</small>
                </div>
                <div style="border-color:goldenrod;" class="h-20px perfect-square p-2px border-width-2px border-style-solid border-color-gold circle">
                    <div style="background:goldenrod;" class="h-full w-full circle bg-gold"></div>
                </div>
            </div>
                {{-- new input --}}
                <div class="w-full column g-5px">
                    <label>Deposit Amount</label>
                    <div class="cont">
                        <span class="h-full perfect-square row align-center justify-center font-size-1-5rem font-weight-900 no-select c-primary no-shrink">{{ $CurrencyHelper::symbol($display_currency) }}</span>
                        <input name="Amount" x-model="Amount" x-bind:value="Amount" type="number" placeholder="Enter Amount" inputmode="numeric" class="inp input required">
                    </div>
                </div>
                <div class="w-full no-select row align-center g-5px c-secondary p-10px bg-rgt-005 font-weight-300 font-size-07 br-10px">
                    <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="15" width="15"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 7H13V9H11V7ZM11 11H13V17H11V11Z"></path></svg>

                    <span>Minimum deposit: {{ $CurrencyHelper::format($packages[0]->cost,'NGN',$display_currency) }}</span>
                </div>
               @if (!$packages->isEmpty())
                    {{-- new grid --}}
                <div style="grid-template-columns: repeat(auto-fit,minmax(min(100px,30%),1fr))" class="w-full grid g-10px place-center">
                    @foreach ($packages as $data)
                        <div x-bind:style="Amount == '{{ $CurrencyHelper::convert($data->cost,'NGN',$display_currency) }}' ? {'background' : 'rgba(76,175,80,0.2)','color' : '#4caf50'} : {}" x-on:click="Amount='{{ $CurrencyHelper::convert($data->cost,'NGN',$display_currency) }}'" class="w-full transition-fast pointer font-weight-800 no-select row p-10px br-5px align-center justify-center bg-rgt-005 c-text">
                            {{ $CurrencyHelper::format($data->cost,'NGN',$display_currency) }}
                        </div>
                    @endforeach
                </div> 
               @endif
                {{-- post btn --}}
                <button class="post">Proceed to Payment</button>
            </form>
            {{-- new --}}
            <div class="w-full column p-20px g-5px bg-light box-shadow br-10px">
                {{-- new row --}}
                <div class="row m-bottom-10px align-center g-5px">
                    <i class="c-primary">
                        <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 7H13V9H11V7ZM11 11H13V17H11V11Z"></path></svg>
                    </i>
                    <strong class="font-size-1rem font-weight-900">Deposit Instructions</strong>
                </div>
                {{-- new --}}
                <span class="font-weight-800 opacity-05">1. Minimum deposit: {{ $CurrencyHelper::format($packages[0]->cost,'NGN',$display_currency) }}.</span>
                {{-- new --}}
                <span class="font-weight-800 opacity-05">2. Please carefully verify your account information before transferring funds to avoid payment errors.</span>
                {{-- new --}}
                <span class="font-weight-800 opacity-05">3. Always contact customer support if you encounter issues with your deposit.</span>
                {{-- new --}}
                <span class="font-weight-800 opacity-05">4. For security reasons, Only initiate deposits through the platform.</span>
               {{-- new --}}
                <span class="font-weight-800 opacity-05">5. No {{ config('app.name') }} official personnel will ever ask you for account information or password, don't fall for scams.</span>

            </div>
    </section>
@endsection