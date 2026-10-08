@extends('layout.users.app')
@section('title')
    Income Details
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
            Income Details
        </span>
        <span></span>
    </div>
@endsection
@section('main')
      <section class="w-full column g-10px">
        <div class="row w-full align-center space-between g-10px">
           
             <div x-on:click="Vitecss.navigate('{{ url('users/products/active?status=active') }}')" class="p-10px w-full box-shadow {{ request('status','active') == 'active' ? 'bg-secondary secondary-text' : 'bg-light c-text' }} br-5px row align-center justify-center">
                Active
            </div>
             <div x-on:click="Vitecss.navigate('{{ url('users/products/active?status=completed') }}')" class="p-10px w-full box-shadow {{ request('status','active') == 'completed' ? 'bg-secondary secondary-text' : 'bg-light c-text' }} br-5px row align-center justify-center">
                Completed
            </div>
        </div>
        @if ($packages->isEmpty())
            @include('components.utilities',[
                'empty' => true
            ])
        @else
          <div style="grid-template-columns:repeat(auto-fit,minmax(min(100%,400px),1fr))" class="w-full grid place-center g-10px">
              @foreach ($packages as $data)
                <div class="w-full column g-10px br-10px p-15px bg-light box-shadow">
                    <div class="w-full row align-center flex-wrap space-between">
                        <span class="font-weight-700 font-size-09rem">{{ $data->package->name }}</span>
                    <span class="capitalize {{ $data->status == 'active' ? 'c-green' : 'c-primary-darker' }}">{{ $data->status }}</span>
                    </div>
                    <div class="hr" vitecss-type="dotted" style="border-color:var(--rgt-05)"></div>
              {{-- new --}}
                    <div class="w-full row align-center flex-wrap space-between">
                        <span class="opacity-07">Product Duration</span>
                        <span>{{ number_format($data->package->validity) }} Days</span>
                    </div>
                    <div class="hr" vitecss-type="solid" style="border-color:var(--rgt-05)"></div>
             {{-- new --}}
                    <div class="w-full row align-center flex-wrap space-between">
                        <span class="opacity-07">Days Left</span>
                        <span>{{ number_format($data->cycle) }} Days</span>
                    </div>
                    <div class="hr" vitecss-type="solid" style="border-color:var(--rgt-05)"></div>
            
                 {{-- new --}}
                    <div class="w-full row align-center flex-wrap space-between">
                        <span class="opacity-07">Daily Income</span>
                        <span>&#8358;{{ number_format($data->package->earning) }}</span>
                    </div>
                    <div class="hr" vitecss-type="solid" style="border-color:var(--rgt-05)"></div>
            
                     {{-- new --}}
                    <div class="w-full row align-center flex-wrap space-between">
                        <span class="opacity-07">Total Income</span>
                        <span>&#8358;{{ number_format($data->package->earning*$data->package->validity) }}</span>
                    </div>
                    <div class="hr" vitecss-type="solid" style="border-color:var(--rgt-05)"></div>
              {{-- new --}}
                    <div class="w-full row align-center flex-wrap space-between">
                        <span class="opacity-07">Income Time</span>
                        <span>Everyday at {{ $data->income_time }}</span>
                    </div>
            
                </div>
            @endforeach
          </div>
        @endif
    </section>
@endsection