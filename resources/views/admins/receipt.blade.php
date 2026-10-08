@extends('layout.admins.app')
@section('title')
    Transaction Receipt
@endsection
@section('main')
    <section class="w-full column g-10">
        @session('error')
            <div class="w-full c-red br-10px p-15px bg-red-transparent">
                {{ $value }}
            </div>
        @endsession
         @session('success')
            <div class="w-full c-green br-10px p-15px bg-green-transparent">
                {{ $value }}
            </div>
        @endsession
        <div style="border:1px solid var(--rgt-01)" class="w-full p-20 br-10 column g-10 bg-light">
            {{-- new row --}}
            <div class="row align-center w-full space-between g-15">
                <img src="{{ asset(config('settings.logo')) }}" alt="" class="h-40 w-40 no-shrink no-pointer no-select">
                <span class="opacity-07">Transaction Receipt</span>
            </div>
            {{-- new column --}}
            <div style="border-bottom: 1px dashed var(--rgt-01);padding-bottom:10px;" class="column m-bottom-20 align-center g-10 text-center">
                <span class="font-weight-500 font-size-09">{{ $data->title }}</span>
                <strong class="font-size-1-5 font-weight-900 c-primary">{{ $data->user->currency.number_format($data->amount,2) }}</strong>
                <div class="status {{ $data->status == 'success' ? 'green' : ($data->status == 'pending' ? 'gold' : ($data->status == 'rejected' || $data->status == 'failed' ? 'red' : 'status-info')) }}">{{ $data->status }}</div>
                <small class="opacity-07 font-weight-500">{{ $data->day }} {{ $data->time }}</small>
            </div>

            {{-- new row --}}
            <div class="row w-full align-center space-between g-10">
                <span class="opacity-07">Transaction ID</span>
                <span class="font-weight-500 text-align-end">{{ $data->uniqid }}</span>
            </div>
             {{-- new row --}}
            <div class="row w-full align-center space-between g-10">
                <span class="opacity-07">Transaction Type</span>
                <span class="font-weight-500 text-align-end">{{ $data->title }}</span>
            </div>
            {{-- new row --}}
            <div class="row w-full align-center space-between g-10">
                <span class="opacity-07">Transaction Class</span>
                <span class="font-weight-500 {{ $data->class == 'credit' ? 'c-green' : 'c-red' }} text-align-end">{{ ucwords($data->class) }}</span>
            </div>
             {{-- new row --}}
            <div class="row w-full align-center space-between g-10">
                <span class="opacity-07">Transaction Fee</span>
                <span class="font-weight-500 text-align-end">{{ $data->user->currency.number_format($data->fee,2) }}</span>
            </div>
            {{-- new row --}}
            <div class="row w-full align-center space-between g-10">
                <span class="opacity-07">User Details</span>
                <span onclick="window.location.href='{{ url('admins/user?id='.$data->user_id.'') }}'" class="text-align-end font-weight-500 c-primary u pointer">Click to view</span>
            </div>
           @if ($data->type == 'withdrawal')
                {{-- new row --}}
            <div class="row w-full align-center space-between g-10">
                <span class="opacity-07">Copy Account Number</span>
                <span onclick="copy('{{ json_decode($data->wallet)->to->account_number }}')" class="text-align-end font-weight-500 c-primary u pointer">Click to copy</span>
            </div>
           @endif
            @isset($data->data)
                @foreach (json_decode($data->data) as $trx_key => $trx_data)
                     {{-- new row --}}
            <div class="row w-full align-center space-between g-10">
                <span class="opacity-07">{{ $trx_key }}</span>
                <span class="font-weight-500 text-align-end">{!! $trx_data !!}</span>
            </div>
                @endforeach
            @endisset
             {{-- new row --}}
            <div class="row bg-blue font-size-1 no-select c-white p-2px p-x-5px w-full align-center space-between g-10">
                <span>Processing Gateway :</span>
                <span class="text-align-end font-weight-500 uppercase">{{ json_decode(file_get_contents(database_path('data/gateways.json')))->withdrawal }}</span>
            </div>
            <div style="border-top:1px dashed var(--rgt-01);padding-top:10px;margin-top:10px;">
                <small class=" text-align-center row opacity-05">
                    This transaction is encrypted end-to-end, secured with AES-256 encryption, PCI-compliant encryption applied. Your data remains private and secure.

                </small>
            </div>
            
        </div>

      @if ($data->status == 'pending')
            <div style="border:1px solid var(--rgt-01)" class="w-full p-20 br-10 column g-10 bg-light">
 <div style="border-bottom:1px dashed var(--rgt-01)" class="row p-bottom-10 w-full">
                <span class="font-weight-500">More Actions</span>
            </div>
        {{-- new row --}}
        <div class="row align-center space-between g-10 w-ful">
           
            <button  onclick="document.querySelector('.modal.approve.{{ $data->type }}').classList.add('active')" class="btn-green-3d">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM17.4571 9.45711L11 15.9142L6.79289 11.7071L8.20711 10.2929L11 13.0858L16.0429 8.04289L17.4571 9.45711Z"></path></svg>

                Approve
            </button>
             <button onclick="document.querySelector('.modal.reject.{{ $data->type }}').classList.add('active')" class="btn-red-3d">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 10.5858L9.17157 7.75736L7.75736 9.17157L10.5858 12L7.75736 14.8284L9.17157 16.2426L12 13.4142L14.8284 16.2426L16.2426 14.8284L13.4142 12L16.2426 9.17157L14.8284 7.75736L12 10.5858Z"></path></svg>
                
                Reject
            </button>
        </div>
        </div>
      @endif
    </section>

     {{-- modals --}}
           {{-- approve withdrawal modal --}}
           <section onclick="this.classList.remove('active')" class="modal withdrawal approve">
            <div onclick="event.stopPropagation()" class="child column align-center text-center">
                <div class="w-50 perfect-square circle no-shrink column align-center justify-center bg-green c-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M243.31,90.91l-128.4,128.4a16,16,0,0,1-22.62,0l-71.62-72a16,16,0,0,1,0-22.61l20-20a16,16,0,0,1,22.58,0L104,144.22l96.76-95.57a16,16,0,0,1,22.59,0l19.95,19.54A16,16,0,0,1,243.31,90.91Z"></path></svg>

                </div>
                <strong class="font-size-1 font-weight-900">Approve Withdrawal</strong>
                <span>Confirm approval of <strong class="font-size-1 font-weight-800 c-green">{{ $data->user->currency }}{{ number_format($data->amount,2) }}</strong>?the user would be notified that his/her withdrawal has been approved.</span>
             
                @if ($gateways->withdrawal != 'manual')
                <small class="c-coral">Please ensure you API Balance is sufficient otherwise the withdrawal would fail</small>
                    @else
                <small class="c-coral">Please ensure you send the money first before approving</small>
                @endif
                <div class="row no-select w-full align-center g-10 space-between">
                <div onclick="this.closest('.modal').classList.remove('active')" class="p-10 h-full pc-pointer br-5 w-full p-x-20" style="border:1px solid var(--primary-01);background:var(--primary-005)">
                   No, Cancel
                </div>
                <div onclick="window.location.href='{{ url('admins/approve/transaction/process?id='.$data->id.'') }}'" class="h-full pointer overflow-hidden w-full p-10 br-5 bg-primary primary-text p-x-20">
                    Yes, proceed
                </div>
            </div>
            </div>
           </section>

            {{-- approve deposit modal --}}
           <section onclick="this.classList.remove('active')" class="modal deposit approve">
            <div onclick="event.stopPropagation()" class="child column align-center text-center">
                <div class="w-50 perfect-square circle no-shrink column align-center justify-center bg-green c-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M243.31,90.91l-128.4,128.4a16,16,0,0,1-22.62,0l-71.62-72a16,16,0,0,1,0-22.61l20-20a16,16,0,0,1,22.58,0L104,144.22l96.76-95.57a16,16,0,0,1,22.59,0l19.95,19.54A16,16,0,0,1,243.31,90.91Z"></path></svg>

                </div>
                <strong class="font-size-1 font-weight-900">Approve Deposit</strong>
                <span>Confirm approval of <strong class="c-green font-weight-800 font-size-1">{{ $data->user->currency }}{{ number_format($data->amount,2) }}</strong>?the user would be creditted the amount automatically into his/her {{ json_decode($data->json)->primary_wallet ?? 'Deposit Wallet' }}.</span>
            <div class="row no-select w-full align-center g-10 space-between">
                <div onclick="this.closest('.modal').classList.remove('active')" class="p-10 h-full pc-pointer br-5 w-full p-x-20" style="border:1px solid var(--primary-01);background:var(--primary-005)">
                    No, Cancel
                </div>
                <div onclick="window.location.href='{{ url('admins/approve/transaction/process?id='.$data->id.'') }}'" class="h-full pointer overflow-hidden w-full p-10 br-5 bg-primary primary-text p-x-20">
                    Yes, proceed
                </div>
            </div>
            </div>
           </section>



             {{-- reject withdrawal modal --}}
           <section onclick="this.classList.remove('active')" class="modal withdrawal reject">
            <div onclick="event.stopPropagation()" class="child column align-center text-center">
                <div class="w-50 perfect-square circle no-shrink column align-center justify-center bg-red c-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm37.66,130.34a8,8,0,0,1-11.32,11.32L128,139.31l-26.34,26.35a8,8,0,0,1-11.32-11.32L116.69,128,90.34,101.66a8,8,0,0,1,11.32-11.32L128,116.69l26.34-26.35a8,8,0,0,1,11.32,11.32L139.31,128Z"></path></svg>

                </div>
                <strong class="font-size-1 font-weight-900">Reject Withdrawal</strong>
                <span>Reject this withdrawal? the user would be refunded back <strong class="font-size-1 font-weight-800 c-green">{{ $data->user->currency.number_format($data->amount,2) }}</strong> into his/her {{ ucwords(json_decode($data->json)->primary_wallet ?? 'Main Wallet') }}. Action cannot be undone.</span>
            <div class="row no-select w-full align-center g-10 space-between">
                <div onclick="this.closest('.modal').classList.remove('active')" class="p-10 h-full pc-pointer br-5 w-full p-x-20" style="border:1px solid var(--primary-01);background:var(--primary-005)">
                    No, Cancel
                </div>
                <div onclick="window.location.href='{{ url('admins/reject/transaction/process?id='.$data->id.'') }}'" class="h-full pointer overflow-hidden w-full p-10 br-5 bg-primary primary-text p-x-20">
                    Yes, proceed
                </div>
            </div>
            </div>
           </section>

           
             {{-- reject deposit modal --}}
           <section onclick="this.classList.remove('active')" class="modal deposit reject">
            <div onclick="event.stopPropagation()" class="child column align-center text-center">
                <div class="w-50 perfect-square circle no-shrink column align-center justify-center bg-red c-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm37.66,130.34a8,8,0,0,1-11.32,11.32L128,139.31l-26.34,26.35a8,8,0,0,1-11.32-11.32L116.69,128,90.34,101.66a8,8,0,0,1,11.32-11.32L128,116.69l26.34-26.35a8,8,0,0,1,11.32,11.32L139.31,128Z"></path></svg>

                </div>
                <strong class="font-size-1 font-weight-900">Reject Deposit</strong>
                <span>Reject this deposit? Action cannot be undone.</span>
            <div class="row no-select w-full align-center g-10 space-between">
                <div onclick="this.closest('.modal').classList.remove('active')" class="p-10 h-full pc-pointer br-5 w-full p-x-20" style="border:1px solid var(--primary-01);background:var(--primary-005)">
                    No, Cancel
                </div>
                <div onclick="window.location.href='{{ url('admins/reject/transaction/process?id='.$data->id.'') }}'" class="h-full pointer overflow-hidden w-full p-10 br-5 bg-primary primary-text p-x-20">
                    Yes, proceed
                </div>
            </div>
            </div>
           </section>
@endsection