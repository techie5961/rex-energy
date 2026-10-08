@extends('layout.admins.app')
@section('title')
    Investment Records
@endsection
@section('main')
    <section class="w-full column g-10">
         {{-- analytic --}}
        <div class="w-full p-20 row g-10 bg-light br-primary" style="border:1px solid var(--rgt-01)">
            <div class="h-50 perfect-square br-primary column align-center justify-center" style="border:1px solid #4caf50;background:rgba(0,255,0,0.1);color:#4caf50;">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3ZM9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12H20V5H4V12H9Z"></path></svg>
            </div>
            <div class="column g-5">
                <span>Total Investments</span>
                <strong class="font-1 font-weight-900">{{ number_format($total) }}</strong>
            </div>
        </div>
         {{-- analytic --}}
        <div class="w-full p-20 row g-10 bg-light br-primary" style="border:1px solid var(--rgt-01)">
            <div class="h-50 perfect-square br-primary column align-center justify-center" style="border:1px solid #4caf50;background:rgba(0,255,0,0.1);color:#4caf50;">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M4 3H20L22 7V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V7.00353L4 3ZM13 14V10H11V14H8L12 18L16 14H13ZM19.7639 7L18.7639 5H5.23656L4.23744 7H19.7639Z"></path></svg>
            </div>
            <div class="column g-5">
                <span>Active Investments</span>
                <strong class="font-1 font-weight-900">{{ number_format($active) }}</strong>
            </div>
        </div>
         {{-- analytic --}}
        <div class="w-full p-20 row g-10 bg-light br-primary" style="border:1px solid var(--rgt-01)">
            <div class="h-50 perfect-square br-primary column align-center justify-center" style="border:1px solid #4caf50;background:rgba(0,255,0,0.1);color:#4caf50;">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M12.0049 22.0027C6.48204 22.0027 2.00488 17.5256 2.00488 12.0027C2.00488 6.4799 6.48204 2.00275 12.0049 2.00275C17.5277 2.00275 22.0049 6.4799 22.0049 12.0027C22.0049 17.5256 17.5277 22.0027 12.0049 22.0027ZM8.50488 14.0027V16.0027H11.0049V18.0027H13.0049V16.0027H14.0049C15.3856 16.0027 16.5049 14.8835 16.5049 13.5027C16.5049 12.122 15.3856 11.0027 14.0049 11.0027H10.0049C9.72874 11.0027 9.50488 10.7789 9.50488 10.5027C9.50488 10.2266 9.72874 10.0027 10.0049 10.0027H15.5049V8.00275H13.0049V6.00275H11.0049V8.00275H10.0049C8.62417 8.00275 7.50488 9.12203 7.50488 10.5027C7.50488 11.8835 8.62417 13.0027 10.0049 13.0027H14.0049C14.281 13.0027 14.5049 13.2266 14.5049 13.5027C14.5049 13.7789 14.281 14.0027 14.0049 14.0027H8.50488Z"></path></svg>
            </div>
            <div class="column g-5">
                <span>Total Amount</span>
                <strong class="font-1 font-weight-900">{{ $currency.number_format($sum,2) }}</strong>
            </div>
        </div>

        @if ($investments->isEmpty())
            @include('components.utilities',[
                'empty' => true,
                'text' => 'No Investments yet',
                'icon' => '<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="50" width="50"><path d="M4.02381 3.78307C4.12549 3.32553 4.5313 3 5 3H19C19.4687 3 19.8745 3.32553 19.9762 3.78307L21.9762 12.7831C21.992 12.8543 22 12.927 22 13V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V13C2 12.927 2.00799 12.8543 2.02381 12.7831L4.02381 3.78307ZM5.80217 5L4.24662 12H9C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12H19.7534L18.1978 5H5.80217ZM16.584 14C15.8124 15.7659 14.0503 17 12 17C9.94968 17 8.1876 15.7659 7.41604 14H4V19H20V14H16.584Z"></path></svg>'
            ])
        @else
            <div class="w-full grid pc-grid-2 place-center g-10">
                
                @foreach ($investments as $data)
                    <div style="border:1px solid var(--rgt-01)" class="w-full br-10 max-w-full overflow-hidden column p-20 bg-light g-10">
                        {{-- new row --}}
                        <div class="row flex-wrap w-full g-10">
                            {{-- new --}}
                            <img src="{{ asset('packages/'.$data->package->photo.'') }}" alt="" class="h-50 w-50 br-5 no-pointer">
                            {{-- new column --}}
                            <div class="colum g-5">
                                <strong class="font-size-1">{{ $data->package->name }}</strong>
                                <small class="opacity-07 row align-center">
                                    Purchased {{ $data->date }}
                                </small>
                                <span>{{ $data->uniqid }}</span>
                            </div>
                                <div class="status m-left-auto {{ $data->status == 'active' ? 'green' : ($data->status == 'supended' ? 'red' : 'primary') }}">{{ $data->status }}</div>

                        </div>
                        <hr>
                        {{-- new row --}}
                        <div class="row w-full g-5 align-center">
                            <span class="opacity-07 ws-nowrap">User: </span>
                            <span onclick="window.location.href='{{ url('admins/user?id='.$data->user_id.'') }}'" class="font-weight-600 c-primary u no-select text-overflow-ellipsis">
                              {{ $data->user->username }}
                            </span>
                        </div>
                        {{-- new row --}}
                        <div class="row w-full g-5 align-center">
                            <span class="opacity-07 ws-nowrap">Purchase Price: </span>
                            <span class="font-weight-600 text-overflow-ellipsis">
                                {{ $data->user->currency.number_format($data->package->cost,2) }}
                            </span>
                        </div>
                           {{-- new row --}}
                        <div class="row w-full g-5 align-center">
                            <span class="opacity-07 ws-nowrap">Daily Income: </span>
                            <span class="font-weight-600 text-overflow-ellipsis">
                                {{ $data->user->currency.number_format($data->package->earning,2) }}
                            </span>
                        </div>
                         {{-- new row --}}
                        <div class="row w-full g-5 align-center">
                            <span class="opacity-07 ws-nowrap">Total Income: </span>
                            <span class="font-weight-600 text-overflow-ellipsis">
                                {{ $data->user->currency.number_format($data->package->earning * $data->package->validity,2) }}
                            </span>
                        </div>
                          {{-- new row --}}
                        <div class="row w-full g-5 align-center">
                            <span class="opacity-07 ws-nowrap">Total Earned: </span>
                            <span class="font-weight-600 text-overflow-ellipsis">
                                {{ $data->user->currency.number_format($data->package->earning * ($data->package->validity - $data->cycle),2) }}
                            </span>
                        </div>
                        {{-- new row --}}
                        <div class="row w-full g-5 align-center">
                            <span class="opacity-07 ws-nowrap">Investment Cycle: </span>
                            <span class="font-weight-600 text-overflow-ellipsis">
                                {{ number_format($data->package->validity) }} Days
                            </span>
                        </div>
                         {{-- new row --}}
                        <div class="row w-full g-5 align-center">
                            <span class="opacity-07 ws-nowrap">Remaining Cycle: </span>
                            <span class="font-weight-600 text-overflow-ellipsis">
                                {{ number_format($data->cycle) }} Days
                            </span>
                        </div>
                         {{-- new row --}}
                        <div class="row w-full g-5 align-center">
                            <span class="opacity-07 ws-nowrap">Income Time: </span>
                            <span class="font-weight-600 text-overflow-ellipsis">
                               Everyday at {{ $data->time_format.' '.$data->meridian }}
                            </span>
                        </div>
                        {{-- new row --}}
                        <div class="row w-full flex-wrap g-10 align-center space-between">
                           @if ($data->cycle > 0)
                               @if ($data->status == 'active')
                                {{-- new btn --}}
                            <button onclick="ShowModal(document.querySelector('.modal.pause'),'{{ $data->id }}')" class="btn-primary-3d">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM9 9V15H11V9H9ZM13 9V15H15V9H13Z"></path></svg>

                                Pause Earning
                            </button>
                           @else
                                {{-- new btn --}}
                            <button onclick="ShowModal(document.querySelector('.modal.activate'),'{{ $data->id }}')" class="btn-green-3d">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM10.6219 8.41459C10.5562 8.37078 10.479 8.34741 10.4 8.34741C10.1791 8.34741 10 8.52649 10 8.74741V15.2526C10 15.3316 10.0234 15.4088 10.0672 15.4745C10.1897 15.6583 10.4381 15.708 10.6219 15.5854L15.5008 12.3328C15.5447 12.3035 15.5824 12.2658 15.6117 12.2219C15.7343 12.0381 15.6846 11.7897 15.5008 11.6672L10.6219 8.41459Z"></path></svg>

                                Activate Earning
                            </button>
                           @endif
                           @endif
                            <button onclick="ShowModal(document.querySelector('.modal.delete'),'{{ $data->id }}')" class="btn-red-3d">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M7 6V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7ZM13.4142 13.9997L15.182 12.232L13.7678 10.8178L12 12.5855L10.2322 10.8178L8.81802 12.232L10.5858 13.9997L8.81802 15.7675L10.2322 17.1817L12 15.4139L13.7678 17.1817L15.182 15.7675L13.4142 13.9997ZM9 4V6H15V4H9Z"></path></svg>

                                Delete
                            </button>
                             <button onclick="window.location.href='{{ url('admins/transactions?investment_id='.$data->id.'') }}'" class="btn-blue-3d">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M20 22H4C3.44772 22 3 21.5523 3 21V3C3 2.44772 3.44772 2 4 2H20C20.5523 2 21 2.44772 21 3V21C21 21.5523 20.5523 22 20 22ZM8 7V9H16V7H8ZM8 11V13H16V11H8ZM8 15V17H13V15H8Z"></path></svg>

                                View Transactions
                            </button>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
    {{-- pause modal  --}}
    <section onclick="this.classList.remove('active');" class="modal pause">
        <div onclick="event.stopPropagation()" class="child align-center text-center">
            <div class="h-50 w-50 circle column align-center justify-center bg-red c-white">
                <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM9 9V15H11V9H9ZM13 9V15H15V9H13Z"></path></svg>

            </div>
            <strong class="font-weight-700 font-size-1">Pause Investment Earning</strong>
            <span>Are you sure you want to pause earnings?</span>
            <small class="opacity-07 c-red">Note that the user wont earn his/her daily income until to re-activate the investment earning. This action can always be undone.</small>
        {{-- new row --}}
        <div class="row w-full align-center g-10">
            <div onclick="this.closest('.modal').classList.remove('active');" class="bg-black c-white br-5 p-10 w-full">No, Cancel</div>

            <div onclick="window.location.href='{{ url('admins/action/investment?id=') }}' + this.dataset.id" class="bg-primary confirm-btn pointer br-5 p-10 w-full primary-text">Yes, Pause</div>
        </div>
        </div>
    </section>
    {{-- continue modal  --}}
    <section onclick="this.classList.remove('active');" class="modal activate">
        <div onclick="event.stopPropagation()" class="child align-center text-center">
            <div class="h-50 w-50 circle column align-center justify-center bg-green c-white">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM10.6219 8.41459C10.5562 8.37078 10.479 8.34741 10.4 8.34741C10.1791 8.34741 10 8.52649 10 8.74741V15.2526C10 15.3316 10.0234 15.4088 10.0672 15.4745C10.1897 15.6583 10.4381 15.708 10.6219 15.5854L15.5008 12.3328C15.5447 12.3035 15.5824 12.2658 15.6117 12.2219C15.7343 12.0381 15.6846 11.7897 15.5008 11.6672L10.6219 8.41459Z"></path></svg>

            </div>
            <strong class="font-weight-700 font-size-1">Activate Investment Earning</strong>
            <span>Are you sure you want to activate earnings?</span>
            <small class="opacity-07 c-red">Note that the user would continue to earn his/her daily income. This action can always be undone.</small>
        {{-- new row --}}
        <div class="row w-full align-center g-10">
            <div onclick="this.closest('.modal').classList.remove('active');" class="bg-black c-white br-5 p-10 w-full">No, Cancel</div>

            <div onclick="window.location.href='{{ url('admins/action/investment?id=') }}' + this.dataset.id" class="bg-primary confirm-btn pointer br-5 p-10 w-full primary-text">Yes, Activate</div>
        </div>
        </div>
    </section>

    {{-- delete modal  --}}
    <section onclick="this.classList.remove('active');" class="modal delete">
        <div onclick="event.stopPropagation()" class="child align-center text-center">
            <div class="h-50 w-50 circle column align-center justify-center bg-red c-white">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M7 6V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7ZM9 4V6H15V4H9Z"></path></svg>

            </div>
            <strong class="font-weight-700 font-size-1">Delete Investment</strong>
            <span>Critical Action, are you sure you want to delete this investment?</span>
            <small class="opacity-07 c-red">Note that the investment would be deleted permanently. This action cannot be undone.</small>
        {{-- new row --}}
        <div class="row w-full align-center g-10">
            <div onclick="this.closest('.modal').classList.remove('active');" class="bg-black c-white br-5 p-10 w-full">No, Cancel</div>

            <div onclick="window.location.href='{{ url('admins/delete/investment?id=') }}' + this.dataset.id" class="bg-primary confirm-btn pointer br-5 p-10 w-full primary-text">Yes, Delete</div>
        </div>
        </div>
    </section>
@endsection
@section('js')
    <script class="js">
        // new 
        function ShowModal(modal,id){
            modal.querySelector('.confirm-btn').dataset.id=id;
            modal.classList.add('active');
        }
    </script>
@endsection