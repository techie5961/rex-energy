@extends('layout.admins.app')
@section('title')
    Manage Gift Codes
@endsection
@section('css')
    <style class="css">
        button{
            box-shadow: 0 0 10px rgba(0,0,0,0.2) !important;
            clip-path:none !important;
        }
    </style>
@endsection
@section('main')
<section class="w-full column g-10">
     {{-- analytic --}}
        <div class="w-full p-20 row g-10 bg-light br-primary" style="border:1px solid var(--rgt-01)">
            <div class="h-50 perfect-square br-primary column align-center justify-center" style="border:1px solid #4caf50;background:rgba(0,255,0,0.1);color:#4caf50;">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M11.0049 20.9997C11.0049 20.1712 10.3333 19.4997 9.50488 19.4997C8.67646 19.4997 8.00488 20.1712 8.00488 20.9997H3.00488C2.4526 20.9997 2.00488 20.5519 2.00488 19.9997V3.99966C2.00488 3.44738 2.4526 2.99966 3.00488 2.99966H8.00488C8.00488 3.82809 8.67646 4.49966 9.50488 4.49966C10.3333 4.49966 11.0049 3.82809 11.0049 2.99966H21.0049C21.5572 2.99966 22.0049 3.44738 22.0049 3.99966V9.49966C20.6242 9.49966 19.5049 10.619 19.5049 11.9997C19.5049 13.3804 20.6242 14.4997 22.0049 14.4997V19.9997C22.0049 20.5519 21.5572 20.9997 21.0049 20.9997H11.0049ZM9.50488 10.4997C10.3333 10.4997 11.0049 9.82809 11.0049 8.99966C11.0049 8.17124 10.3333 7.49966 9.50488 7.49966C8.67646 7.49966 8.00488 8.17124 8.00488 8.99966C8.00488 9.82809 8.67646 10.4997 9.50488 10.4997ZM9.50488 16.4997C10.3333 16.4997 11.0049 15.8281 11.0049 14.9997C11.0049 14.1712 10.3333 13.4997 9.50488 13.4997C8.67646 13.4997 8.00488 14.1712 8.00488 14.9997C8.00488 15.8281 8.67646 16.4997 9.50488 16.4997Z"></path></svg>
            </div>
            <div class="column g-5">
                <span>Total Gift Codes</span>
                <strong class="font-1 font-weight-900">{{ number_format($total) }}</strong>
            </div>
        </div>
         {{-- analytic --}}
        <div class="w-full p-20 row g-10 bg-light br-primary" style="border:1px solid var(--rgt-01)">
            <div class="h-50 perfect-square br-primary column align-center justify-center" style="border:1px solid #4caf50;background:rgba(0,255,0,0.1);color:#4caf50;">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M14.0049 2.99966V20.9997H3.00488C2.4526 20.9997 2.00488 20.5519 2.00488 19.9997V14.4997C3.38559 14.4997 4.50488 13.3804 4.50488 11.9997C4.50488 10.619 3.38559 9.49966 2.00488 9.49966V3.99966C2.00488 3.44738 2.4526 2.99966 3.00488 2.99966H14.0049ZM16.0049 2.99966H21.0049C21.5572 2.99966 22.0049 3.44738 22.0049 3.99966V9.49966C20.6242 9.49966 19.5049 10.619 19.5049 11.9997C19.5049 13.3804 20.6242 14.4997 22.0049 14.4997V19.9997C22.0049 20.5519 21.5572 20.9997 21.0049 20.9997H16.0049V2.99966Z"></path></svg>
            </div>
            <div class="column g-5">
                <span>Total Active Codes</span>
                <strong class="font-1 font-weight-900">{{ number_format($total_active) }}</strong>
            </div>
        </div>
         {{-- analytic --}}
        <div class="w-full p-20 row g-10 bg-light br-primary" style="border:1px solid var(--rgt-01)">
            <div class="h-50 perfect-square br-primary column align-center justify-center" style="border:1px solid #4caf50;background:rgba(0,255,0,0.1);color:#4caf50;">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M2.00488 9.49966V3.99966C2.00488 3.44738 2.4526 2.99966 3.00488 2.99966H21.0049C21.5572 2.99966 22.0049 3.44738 22.0049 3.99966V9.49966C20.6242 9.49966 19.5049 10.619 19.5049 11.9997C19.5049 13.3804 20.6242 14.4997 22.0049 14.4997V19.9997C22.0049 20.5519 21.5572 20.9997 21.0049 20.9997H3.00488C2.4526 20.9997 2.00488 20.5519 2.00488 19.9997V14.4997C3.38559 14.4997 4.50488 13.3804 4.50488 11.9997C4.50488 10.619 3.38559 9.49966 2.00488 9.49966ZM9.00488 8.99966V10.9997H15.0049V8.99966H9.00488ZM9.00488 12.9997V14.9997H15.0049V12.9997H9.00488Z"></path></svg>
            </div>
            <div class="column g-5">
                <span>Total Redeemed/Completed Codes</span>
                <strong class="font-1 font-weight-900">{{ number_format($total_redeemed) }}</strong>
            </div>
        </div>

        @if ($codes->isEmpty())
            @include('components.utilities',[
                'empty' => true,
                'text' => 'No gift code found',
                'icon' => '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="50" width="50"><path d="M10.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979H10.0049C10.0049 4.10436 10.9003 4.99979 12.0049 4.99979C13.1095 4.99979 14.0049 4.10436 14.0049 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H14.0049C14.0049 19.8952 13.1095 18.9998 12.0049 18.9998C10.9003 18.9998 10.0049 19.8952 10.0049 20.9998ZM8.54001 18.9998C9.23163 17.8042 10.5243 16.9998 12.0049 16.9998C13.4854 16.9998 14.7781 17.8042 15.4698 18.9998H20.0049V4.99979H15.4698C14.7781 6.19539 13.4854 6.99979 12.0049 6.99979C10.5243 6.99979 9.23163 6.19539 8.54001 4.99979H4.00488V18.9998H8.54001ZM6.00488 7.99979H8.00488V15.9998H6.00488V7.99979ZM16.0049 7.99979H18.0049V15.9998H16.0049V7.99979Z"></path></svg>'
            ])
        @else
            <div class="w-full grid pc-grid-2 g-10 place-center">
                @foreach ($codes as $data)
                    <div style="border:1px solid var(--rgt-01)" class="w-full column bg-light p-20 g-10 br-10">
                        {{-- new row --}}
                        <div style="border-bottom:1px dashed var(--rgt-01);padding-bottom:10px;" class="row w-full align-center g-10 flex-wrap space-between">
                            <div style="background:var(--primary-01);" class="w-fit p-10 font-weight-500 br-5">
                                {{ $data->code }}
                               
                            </div>
                            <div class="status {{ $data->status == 'active' ? 'green' : 'primary' }}">{{ $data->status }}</div>
                        </div>
                        <span onclick="copy('{{ $data->code }}')" class="c-primary u no-select pointer">Click to Copy Gift Code</span>
                        {{-- new row --}}
                        <div class="row w-full g-10 align-center">
                            <span class="opacity-07">Code Reward: </span>
                            <span class="font-weight-500">{!! '&#8358;'.number_format($data->reward,2) !!}</span>
                        </div>
                        {{-- new row --}}
                        <div class="row w-full g-10 align-center">
                            <span class="opacity-07">Code Limit: </span>
                            <span class="font-weight-500">{{ number_format($data->limit) }}</span>
                        </div>
                        {{-- new row --}}
                        <div class="row w-full g-10 align-center">
                            <span class="opacity-07">Total Redeemed: </span>
                            <span class="font-weight-500">{{ number_format($data->redeemed) }}</span>
                        </div>
                         {{-- new row --}}
                        <div class="row w-full g-10 align-center">
                            <span class="opacity-07">Invest Before Redeeming: </span>
                            <span class="font-weight-500 {{ $data->invest_before_redeeming == 'yes' ? 'c-green' : 'c-red' }}">{{ ucwords($data->invest_before_redeeming) }}</span>
                        </div>
                        {{-- new row --}}
                        <div class="row w-full g-10 align-center">
                            <span class="opacity-07">Created: </span>
                            <span class="font-weight-500">{{ $data->date }}</span>
                        </div>
                          {{-- new row --}}
                        <div class="row w-full g-10 align-center">
                            <span class="opacity-07">Last Updated: </span>
                            <span class="font-weight-500">{{ $data->updated }}</span>
                        </div>
                        {{-- new row --}}
                        <div style="border-top:1px dashed var(--rgt-01);padding-top:10px;margin-top:10px;" class="row flex-wrap w-full align-center g-10 space-between">
                            <button onclick="window.location.href='{{ url('users/gift/code/edit?id='.$data->id.'') }}'" class="btn-green-3d">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M16.7574 2.99678L14.7574 4.99678H5V18.9968H19V9.23943L21 7.23943V19.9968C21 20.5491 20.5523 20.9968 20 20.9968H4C3.44772 20.9968 3 20.5491 3 19.9968V3.99678C3 3.4445 3.44772 2.99678 4 2.99678H16.7574ZM20.4853 2.09729L21.8995 3.5115L12.7071 12.7039L11.2954 12.7064L11.2929 11.2897L20.4853 2.09729Z"></path></svg>

                                Edit</button>
                            <button onclick="window.location.href='{{ url('admins/transactions?giftcode=true&giftcode_id='.$data->id.'') }}'" class="btn-primary-3d">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M20 22H4C3.44772 22 3 21.5523 3 21V3C3 2.44772 3.44772 2 4 2H20C20.5523 2 21 2.44772 21 3V21C21 21.5523 20.5523 22 20 22ZM8 7V9H16V7H8ZM8 11V13H16V11H8ZM8 15V17H13V15H8Z"></path></svg>

                                View Transactions</button>
                                <button onclick="ShowDeleteModal('{{ $data->id }}')" class="btn-red-3d">
                                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM9 11V17H11V11H9ZM13 11V17H15V11H13ZM9 4V6H15V4H9Z"></path></svg>

                                Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($codes->lastPage() > 1)
            @include('components.utilities',[
                'paginate' => true,
                'data' => $codes
            ])
        @endif
        @endif
        
</section>
     {{-- delete modal --}}
    <section class="modal delete">
        <div class="child column align-center g-10 text-center">
            {{-- new row --}}
            <div class="w-50 perfect-square no-shrink circle bg-red c-white column align-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="30" width="30"><path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM112,168a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm0-120H96V40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8Z"></path></svg>

            </div>
            {{-- new row --}}
            <strong class="font-size-1">Delete this Gift Code</strong>
            {{-- new row --}}
            <span>Are you sure you want to delete this code?</span>
            {{-- new row --}}
            <span class="c-red"> Units already redeemed won't be affected. This action cannot be undone</span>
            {{-- new row --}}
            <div class="w-full row g-10 align-center space-between">
                <div onclick="this.closest('.modal').classList.remove('active');" class="h-40 no-select pointer br-5 row align-center justify-center bg-black c-white p-10 w-full" style="border:1px solid var(--rgt-10);color:var(--rgt-10)">No, Cancel</div>
             <div onclick="window.location.href='{{ url('admins/gift/code/delete?id=') }}' + this.dataset.id" class="h-40 confirm-delete br-5 no-select pointer bg-primary primary-text row align-center justify-center p-10 w-full">Yes, Delete</div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script class="js">
        function ShowDeleteModal(id){
            document.querySelector('.modal.delete .confirm-delete').dataset.id=id;
            document.querySelector('.modal.delete').classList.add('active');
        }
    </script>
@endsection