@extends('layout.admins.app')
@section('title')
    API Management
@endsection
@section('main')
    <section class="w-full column g-10px">
        {{-- new row --}}
        <div class="row align-center g-10px space-between">
            <strong class="font-weight-900 font-size-1-3">API Overview</strong>
            <div class="br-5px bg-primary primary-text p-5px p-x-15px">NGN</div>
        </div>
        {{-- new --}}
        <div style="background:linear-gradient(to bottom right,var(--primary),var(--primary-dark))" class="w-full bg-primary primary-text br-10px column g-10px p-20px box-shadow">
            <span class="opacity-05 font-size-09">TOTAL BALANCE</span>
            <div class="column g-5px">
            <span class="opacity-07">Available balance (NGN)</span>
            <strong class="font-size-1-5 m-bottom-20px font-weight-900">&#8358;{{ number_format($balance,2) }}</strong>
                <div class="row align-center g-10px space-between">
                    <span class="opacity-07">Account Number:</span>
                    <span x-data="{ 
                        Copied : false
                     }" class="font-weight-700">
                        6378198322
                        <svg x-on:click="
                        copy('6378198322');
                        Copied = true;
                        setTimeout(() => {
                            Copied = false;
                        }, 2000);
                        " x-show="!Copied" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M180,64H40A12,12,0,0,0,28,76V216a12,12,0,0,0,12,12H180a12,12,0,0,0,12-12V76A12,12,0,0,0,180,64ZM168,204H52V88H168ZM228,40V180a12,12,0,0,1-24,0V52H76a12,12,0,0,1,0-24H216A12,12,0,0,1,228,40Z"></path></svg>
                        <svg x-show="Copied" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M176.49,95.51a12,12,0,0,1,0,17l-56,56a12,12,0,0,1-17,0l-24-24a12,12,0,1,1,17-17L112,143l47.51-47.52A12,12,0,0,1,176.49,95.51ZM236,128A108,108,0,1,1,128,20,108.12,108.12,0,0,1,236,128Zm-24,0a84,84,0,1,0-84,84A84.09,84.09,0,0,0,212,128Z"></path></svg>

                    </span>
                </div>
                <div class="row align-center g-10px space-between">
                    <span class="opacity-07">Bank Name:</span>
                    <span class="font-weight-700">Moniepoint Microfinance Bank</span>
                </div>
                <div class="row align-center g-10px space-between">
                    <span class="opacity-07">Account Name:</span>
                    <span class="font-weight-700">Dev-RSRVD</span>
                </div>
                <small class="text-center opacity-05">To fund API,kindly send the exact amount into the account details above</small>
            </div>
        </div>

        @if (empty($history))
            @include('components.utilities',[
                'empty' => true,
                'text' => 'No transaction yet'
            ])

            @else
         <div style="grid-template-columns: repeat(auto-fit,minmax(min(100%,400px),1fr))" class="grid place-center g-10px w-full">
               @foreach ($history as $data)
                <div class="w-full box-shadow column p-20px g-10px br-10px bg-light">
                    {{-- new row --}}
                    <div class="row align-center g-10px space-between">
                        <div class="p-5px w-fit ws-nowrap text-overflow-ellipsis p-x-10px br-5px bg-primary-01 c-primary no-select no-pointer">{{ $data['source_reference'] }}</div>
                        <div class="status {{ $data['direction'] == 'debit' ? 'red' : 'green' }}">{{ $data['direction'] }}</div>
                    </div>
                    <div class="hr" vitecss-type="dashed"></div>
                    {{-- new row --}}
                    <div class="row align-center g-5px">
                        <span class="opacity-07 ws-nowrap">Description: </span>
                        <span class="font-weight-700 ws-nowrap text-overflow-ellipsis">{{ $data['description'] }}</span>
                    </div>
                     {{-- new row --}}
                    <div class="row align-center g-5px">
                        <span class="opacity-07 ws-nowrap">Balance Before: </span>
                        <span class="font-weight-700 ws-nowrap text-overflow-ellipsis">&#8358;{{ number_format($data['balance_before'],2) }}</span>
                    </div>
                    {{-- new row --}}
                    <div class="row align-center g-5px">
                        <span class="opacity-07 ws-nowrap">Balance After: </span>
                        <span class="font-weight-700 ws-nowrap text-overflow-ellipsis">&#8358;{{ number_format($data['balance_after'],2) }}</span>
                    </div>
                     {{-- new row --}}
                    <div class="row align-center g-5px">
                        <span class="opacity-07 ws-nowrap">Date Created: </span>
                        <span class="font-weight-700 ws-nowrap text-overflow-ellipsis">{{ $data['date_created'] }}</span>
                    </div>
                     {{-- new row --}}
                    <div class="row align-center g-5px">
                        <span class="opacity-07 ws-nowrap">Source: </span>
                        <span class="font-weight-700 ws-nowrap text-overflow-ellipsis">{{ $data['source'] }}</span>
                    </div>
                    <div class="hr" vitecss-type="dashed"></div>
                    <div class="row align-center g-10px space-between">
                        <span>Amount</span>
                    <strong class="desc font-weight-900 {{ $data['direction'] == 'credit' ? 'c-green' : 'c-red' }}">{{ $data['direction'] == 'credit' ? '+' : '-' }}&#8358;{{ number_format($data['amount'],2) }}</strong>

                    </div>
                </div>
            @endforeach
         </div>
        @endif
    </section>
@endsection