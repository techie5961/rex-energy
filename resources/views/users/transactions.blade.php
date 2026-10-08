@extends('layout.users.app')
@section('title')
    Transactions
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
            {{ request('type','Transaction') == 'package_earning' ? 'Income Details' : ucwords(request('type','Transaction').' Records') }}
        </span>
        <span></span>
    </div>
@endsection
@section('main')
    <section class="w-full column g-10px">
        <div class="row w-full align-center space-between g-10px">
            <div x-on:click="Vitecss.navigate('{{ url('users/transactions') }}')" class="p-10px w-full box-shadow {{ request('type','all') == 'all' ? 'bg-secondary secondary-text' : 'bg-light c-text' }} br-5px row align-center justify-center">
                All
            </div>
             <div x-on:click="Vitecss.navigate('{{ url('users/transactions?type=deposit') }}')" class="p-10px w-full box-shadow {{ request('type','all') == 'deposit' ? 'bg-secondary secondary-text' : 'bg-light c-text' }} br-5px row align-center justify-center">
                Deposit
            </div>
             <div x-on:click="Vitecss.navigate('{{ url('users/transactions?type=withdrawal') }}')" class="p-10px w-full box-shadow {{ request('type','all') == 'withdrawal' ? 'bg-secondary secondary-text' : 'bg-light c-text' }} br-5px row align-center justify-center">
                Withdrawal
            </div>
        </div>
        @if ($trx->isEmpty())
            @include('components.utilities',[
                'empty' => true
            ])
        @else
          <div style="grid-template-columns:repeat(auto-fit,minmax(min(100%,400px),1fr))" class="w-full grid place-center g-10px">
              @foreach ($trx as $data)
                <div class="w-full column g-10px br-10px p-15px bg-light box-shadow">
                    <div class="w-full row align-center flex-wrap space-between">
                        <span class="font-weight-700 font-size-09rem">{{ $data->title }}</span>
                    </div>
                    <div class="hr" vitecss-type="dotted" style="border-color:var(--rgt-05)"></div>
             
              <div class="w-full row align-center flex-wrap space-between">
                        <span class="opacity-07">Amount</span>
                        <span class="font-weight-900 font-size-09rem {{ $data->class == 'credit' ? 'c-green' : 'c-red' }}">{{ $data->class == 'credit' ? '+' : '-' }}&#8358;{{ number_format($data->amount) }}</span>
                    </div>
                    <div class="hr" vitecss-type="solid" style="border-color:var(--rgt-05)"></div>
                    <div class="w-full row align-center flex-wrap space-between">
                        <span class="opacity-07">Order Ref</span>
                        <div class="row g-5px align-center w-fit">
                            <span class="">{{ $data->uniqid }}</span>
                            <i x-data="{ 
                                Copied : false
                             }">
                                <svg x-on:click="
                                copy('{{ $data->uniqid }}',function(){
                                    Inform.Message = 'Copied';
                                    Inform.Status = 'success';
                                });
                                Copied = true;
                                setTimeout(() => {
                                    Copied = false
                                }, 2000);
                                " x-show="!Copied" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 20 20">
  <g fill="currentColor">
    <path d="m13,7h2c1.105,0,2,.895,2,2v6c0,1.105-.895,2-2,2h-6c-1.105,0-2-.895-2-2v-2" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
    <rect x="3" y="3" width="10" height="10" rx="2" ry="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" fill="currentColor"></rect>
  </g>
</svg>
<svg x-show="Copied" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 32 32">
  <g fill="currentColor">
    <path d="m16,1C7.729,1,1,7.729,1,16s6.729,15,15,15,15-6.729,15-15S24.271,1,16,1Zm-2.43,21.985l-5.984-5.985,1.414-1.414,4.43,4.429,9.437-11.423,1.542,1.273-10.838,13.119Z" stroke-width="0" fill="currentColor"></path>
  </g>
</svg>
                            </i>
                        </div>
                    </div>
                    <div class="hr" vitecss-type="solid" style="border-color:var(--rgt-05)"></div>
                <div class="w-full row align-center flex-wrap space-between">
                        <span class="opacity-07">Status</span>
                        <span class="capitalize {{ $data->status == 'success' ? 'c-green' : ($data->status == 'pending' ? 'c-gold' : ($data->status == 'rejected' ? 'c-red' : 'c-primary')) }}">{{ $data->status }}</span>
                    </div>
                    <div class="hr" vitecss-type="solid" style="border-color:var(--rgt-05)"></div>
 <div class="w-full row align-center flex-wrap space-between">
                        <span class="opacity-07">Time</span>
                        <span>{{ $data->frame }}</span>
                    </div>

                </div>
            @endforeach
          </div>
        @endif
    </section>
@endsection