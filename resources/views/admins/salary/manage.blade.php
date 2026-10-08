@extends('layout.admins.app')
@section('title')
    Manage salary
@endsection
@section('main')
    <section x-data="{ 
        Modal : false,
        Link : ''
     }" x-init="
     $watch('Modal', (value) => {
        if(value){
            document.body.classList.add('overflow-hidden');
        }else{
            document.body.classList.remove('overflow-hidden');

        }
     })
     " class="w-full column g-15px">
        {{-- new analytic --}}
        <div class="w-full bg-light p-20px br-10px box-shadow row g-10px">
           <div class="column no-shrink box-shadow h-50px perfect-square br-10px bg-green c-white align-center justify-center">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM17.4571 9.45711L11 15.9142L6.79289 11.7071L8.20711 10.2929L11 13.0858L16.0429 8.04289L17.4571 9.45711Z"></path></svg>

           </div>
           {{-- new column --}}
           <div class="column g-5px">
            <span class="opacity-07">Total salary tasks</span>
            <strong class="font-size-1-2 font-weight-900">{{ number_format($total) }}</strong>
           </div>
        </div>
        @if ($salary->isEmpty())
            @include('components.utilities',[
                'empty' => 'true',
                'text' => 'No salary added yet'
            ])
        @else
        <div class="w-full grid pc-grid-2 place-center g-15px m-top-10px">
            @foreach ($salary as $data)
                <div class="w-full g-10px column br-10px p-20px bg-light box-shadow">
                    {{-- new row --}}
                    <div class="row flex-wrap space-between w-full g-10px">
                        <strong class="font-size-1 u font-weight-900 no-select c-primary">{{ $data->uniqid }}</strong>
                        <div class="status green">{{ $data->status }}</div>
                    </div>
                    <div class="hr" vitecss-type="solid"></div>
                    {{-- new row --}}
                    <div class="row w-full g-5px">
                        <span class="opacity-07">Referral Count:</span>
                        <span>{{ number_format($data->referrals) }} Active referrals</span>
                    </div>
                    {{-- new row --}}
                    <div class="row w-full g-5px">
                        <span class="opacity-07">Salary Reward:</span>
                        <span>&#8358;{{ number_format($data->reward) }}</span>
                    </div>
                     {{-- new row --}}
                    <div class="row w-full g-5px">
                        <span class="opacity-07">Total Completed:</span>
                        <span>{{ number_format($data->completed) }} users</span>
                    </div>
                     {{-- new row --}}
                    <div class="row w-full g-5px">
                        <span class="opacity-07">Added:</span>
                        <span>{{ $data->added }}</span>
                    </div>
                    {{-- new row --}}
                    <div class="hr" vitecss-type="dashed"></div>
                    <div class="row align-center flex-wrap g-10px space-between">
                        <button x-on:click="window.location.href='{{ url('admins/salary/edit?id='.$data->id.'') }}'" class="btn-green">Edit salary</button>
                        <button x-on:click="Modal = true;Link = '{{ url('admins/salary/delete?id='.$data->id.'') }}';" class="btn-red">Delete salary</button>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($salary->lastPage() > 1)
            @include('components.utilities',[
                'paginate' => true,
                'data' => $salary
            ])
        @endif
        @endif

        {{-- modal --}}
        <section x-on:click="Modal=false;" x-show="Modal" x-transition:enter-start="fade-enter" x-transition:enter-end="fade-enter-end" x-transition:leave-start="fade-leave" x-transition:leave-end="fade-leave-end" class="pos-fixed transition-all column align-center justify-center p-40px inset-0 bg-black-transparent backdrop-blur-10px z-index-3000">
            <div x-on:click.stop="" class="w-full max-w-500px text-center align-center br-10px bg p-20px column g-10px">
                {{-- new --}}
                <div class="h-70px w-70px circle box-shadow column align-center justify-center bg-red c-white">
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z"></path></svg>

                </div>
                {{-- new --}}
                <strong class="font-size-1 font-weight-800">Delete this salary task?</strong>
                <span class="opacity-07">Are you sure you want to delete this salary task? this action cannot be undone.</span>
                {{-- new row --}}
                <div class="row no-select m-top-10px w-full align-center space-between g-10px">
                   <div x-on:click="Modal=false;" class="w-full p-10px br-5px bg-black c-white row align-center justify-center">No, cancel</div>
                   <div x-on:click="window.location.href=Link" class="w-full p-10px br-5px bg-primary primary-text row align-center justify-center">Yes, delete</div>
                </div>
            </div>
        </section>
    </section>
@endsection