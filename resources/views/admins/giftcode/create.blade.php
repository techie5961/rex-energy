@extends('layout.admins.app')
@section('title')
    Create Gift Create
@endsection
@section('main')
    <section class="w-full column g-10">
        <form onsubmit="PostRequest(event,this,Created)" action="{{ url('admins/post/create/gift/code/process') }}" style="border:1px solid var(--rgt-01)" class="w-full bg-light form br-10 column g-10 p-20">
           
            <div class="row w-full align-center g-10">
                <i class="column h-fit c-primary">
                    <svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="20" width="20"><path d="M11.0049 20.9997C11.0049 20.1712 10.3333 19.4997 9.50488 19.4997C8.67646 19.4997 8.00488 20.1712 8.00488 20.9997H3.00488C2.4526 20.9997 2.00488 20.5519 2.00488 19.9997V3.99966C2.00488 3.44738 2.4526 2.99966 3.00488 2.99966H8.00488C8.00488 3.82809 8.67646 4.49966 9.50488 4.49966C10.3333 4.49966 11.0049 3.82809 11.0049 2.99966H21.0049C21.5572 2.99966 22.0049 3.44738 22.0049 3.99966V9.49966C20.6242 9.49966 19.5049 10.619 19.5049 11.9997C19.5049 13.3804 20.6242 14.4997 22.0049 14.4997V19.9997C22.0049 20.5519 21.5572 20.9997 21.0049 20.9997H11.0049ZM9.50488 10.4997C10.3333 10.4997 11.0049 9.82809 11.0049 8.99966C11.0049 8.17124 10.3333 7.49966 9.50488 7.49966C8.67646 7.49966 8.00488 8.17124 8.00488 8.99966C8.00488 9.82809 8.67646 10.4997 9.50488 10.4997ZM9.50488 16.4997C10.3333 16.4997 11.0049 15.8281 11.0049 14.9997C11.0049 14.1712 10.3333 13.4997 9.50488 13.4997C8.67646 13.4997 8.00488 14.1712 8.00488 14.9997C8.00488 15.8281 8.67646 16.4997 9.50488 16.4997Z"></path></svg>

                </i>
                <strong class="desc font-weight-900 c-primary no-select c-primary">Create New Gift Code</strong>
            </div>
            {{-- csrf token --}}
            <input type="hidden" class="inp input" name="_token" value="{{ @csrf_token() }}">

            {{-- new input --}}
            <div class="w-full column g-5">
                <label for="" class="column g-2">
                    <span>Code Reward</span>
                    <small class="opacity-07">The reward earned whenever a user redeems the code ( &#8358; ).</small>
                </label>
                <div class="cont">
                    <input placeholder="e.g {!! '&#8358;' !!}500" type="number" inputmode="numeric" name="reward" class="inp input required">
                </div>
            </div>
             {{-- new input --}}
            <div class="w-full column g-5">
                <label for="" class="column g-2">
                    <span>Code Limit</span>
                    <small class="opacity-07">How many users can redeem this code ( the code is rendered invalid if the limit is met ).</small>
                </label>
                <div class="cont">
                    <input placeholder="e.g 100" type="number" inputmode="numeric" name="limit" class="inp input required">
                </div>
            </div>
            {{-- new input --}}
            <div class="w-full row g-10 space-between">
                <div class="column g-5">
                    <span>Invest before redeeming?</span>
                    <small class="opacity-07">When turned on, only users who have active investments can redeem this code.</small>

                </div>
                <div class="toggle">
                    <div onclick="ToggleElement(this)" class="child"></div>
                </div>
            </div>
            
                <input type="hidden" class="inp input" name="invest_before_redeeming" value="no">
            <small class="opacity-07">
                Note: the gift code is generated internally based on your submission ensure to check inputs clearly before submitting. Each gift code can only be redeemed once per user.
            </small>
            {{-- button --}}
            <button class="post">Create Gift Code</button>
        </form>
    </section>
@endsection
@section('js')
    <script class="js">
        function Created(response){
            let data=JSON.parse(response);
            if(data.status == 'success'){
                window.location.href='{{ url('admins/gift/codes/manage') }}';
            }
        }
        // new
        function ToggleElement(element){
            try{
                if(element.closest('.toggle').classList.contains('active')){
                    element.closest('.toggle').classList.remove('active');
                    element.closest('.form').querySelector('input[name=invest_before_redeeming]').value='no';
                }else{
                     element.closest('.toggle').classList.add('active');
                     element.closest('.form').querySelector('input[name=invest_before_redeeming]').value='yes';
                    

                }
            }catch(error){
                        alert(error)
                    }
        }
    </script>
@endsection