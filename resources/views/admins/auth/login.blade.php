@extends('layout.admins.auth')
@section('title')
    Login
@endsection
@section('main')
    <section class="w-full flex-auto align-center justify-center column g-10">
        {{-- form --}}
        <form method="POST" onsubmit="PostRequest(event,this,MyFunc.LoggedIn)" action="{{ url('admins/post/login/process') }}" class="w-full align-center column g-10 br-15px box-shadow p-20 bg-light max-w-500">
        {{-- logo image --}}
            <img src="{{ asset(config('settings.logo')) }}" alt="Site Logo" class="h-70">
            <strong class="font-1-5 font-weight-900">Admins Login</strong>
          {{-- csrf token --}}
          <input type="hidden" value="{{ @csrf_token() }}" name="_token" class="inp input">
            {{-- new input column --}}
            <div class="column g-5 w-full">
                <label>Admin Tag</label>
            <div class="cont br-10">
                <input name="id"  placeholder="Enter Admin Tag" type="text" class="inp input required">
            </div>
            </div>
             {{-- new input column --}}
            <div class="column g-5 w-full">
                <label>Password</label>
            <div class="cont br-10">
                <input name="password" placeholder="Enter account password" type="password" class="inp input required">
            </div>
            </div>
           
            {{-- submit button --}}
            <button class="post br-10">Login Safely</button>
            {{-- encryption prompt --}}
             <div class="row justify-center align-center g-10 w-full">
                <small class="row align-center g-5 opacity-07">
                    <span>
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.5" d="M2 16C2 13.1716 2 11.7574 2.87868 10.8787C3.75736 10 5.17157 10 8 10H16C18.8284 10 20.2426 10 21.1213 10.8787C22 11.7574 22 13.1716 22 16C22 18.8284 22 20.2426 21.1213 21.1213C20.2426 22 18.8284 22 16 22H8C5.17157 22 3.75736 22 2.87868 21.1213C2 20.2426 2 18.8284 2 16Z" fill="CurrentColor"></path>
<path d="M12.75 14C12.75 13.5858 12.4142 13.25 12 13.25C11.5858 13.25 11.25 13.5858 11.25 14V18C11.25 18.4142 11.5858 18.75 12 18.75C12.4142 18.75 12.75 18.4142 12.75 18V14Z" fill="CurrentColor"></path>
<path d="M6.75 8C6.75 5.10051 9.10051 2.75 12 2.75C14.8995 2.75 17.25 5.10051 17.25 8V10.0036C17.8174 10.0089 18.3135 10.022 18.75 10.0546V8C18.75 4.27208 15.7279 1.25 12 1.25C8.27208 1.25 5.25 4.27208 5.25 8V10.0546C5.68651 10.022 6.18264 10.0089 6.75 10.0036V8Z" fill="CurrentColor"></path>
</svg>

                    </span>
                    <span>Secure Login</span>
                </small>
                <small class="row align-center g-5 opacity-07">
                    <span>
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.5" d="M3.37752 5.08241C3 5.62028 3 7.21907 3 10.4167V11.9914C3 17.6294 7.23896 20.3655 9.89856 21.5273C10.62 21.8424 10.9807 22 12 22C13.0193 22 13.38 21.8424 14.1014 21.5273C16.761 20.3655 21 17.6294 21 11.9914V10.4167C21 7.21907 21 5.62028 20.6225 5.08241C20.245 4.54454 18.7417 4.02996 15.7351 3.00079L15.1623 2.80472C13.595 2.26824 12.8114 2 12 2C11.1886 2 10.405 2.26824 8.83772 2.80472L8.26491 3.00079C5.25832 4.02996 3.75503 4.54454 3.37752 5.08241Z" fill="CurrentColor"></path>
<path d="M15.0595 10.4995C15.3353 10.1905 15.3085 9.71643 14.9995 9.44055C14.6905 9.16468 14.2164 9.19152 13.9406 9.5005L10.9286 12.8739L10.0595 11.9005C9.78359 11.5915 9.30947 11.5647 9.0005 11.8406C8.69152 12.1164 8.66468 12.5905 8.94055 12.8995L10.3691 14.4995C10.5114 14.6589 10.7149 14.75 10.9286 14.75C11.1422 14.75 11.3457 14.6589 11.488 14.4995L15.0595 10.4995Z" fill="CurrentColor"></path>
</svg>


                    </span>
                    <span>Encrypted</span>
                </small>
                 <small class="row align-center g-5 opacity-07">
                    <span>
                      <svg width="10" height="10" viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.5" d="M3 10.4167C3 7.21907 3 5.62028 3.37752 5.08241C3.75503 4.54454 5.25832 4.02996 8.26491 3.00079L8.83772 2.80472C10.405 2.26824 11.1886 2 12 2C12.8114 2 13.595 2.26824 15.1623 2.80472L15.7351 3.00079C18.7417 4.02996 20.245 4.54454 20.6225 5.08241C21 5.62028 21 7.21907 21 10.4167V11.9914C21 17.6294 16.761 20.3655 14.1014 21.5273C13.38 21.8424 13.0193 22 12 22C10.9807 22 10.62 21.8424 9.89856 21.5273C7.23896 20.3655 3 17.6294 3 11.9914V10.4167Z" fill="CurrentColor"></path>
<path d="M14 9C14 10.1046 13.1046 11 12 11C10.8954 11 10 10.1046 10 9C10 7.89543 10.8954 7 12 7C13.1046 7 14 7.89543 14 9Z" fill="CurrentColor"></path>
<path d="M12 17C16 17 16 16.1046 16 15C16 13.8954 14.2091 13 12 13C9.79086 13 8 13.8954 8 15C8 16.1046 8 17 12 17Z" fill="CurrentColor"></path>
</svg>




                    </span>
                    <span>Private</span>
                </small>
            </div>
        </form>
    </section>
@endsection
@section('js')
    <script class="js">
        window.MyFunc = {
            LoggedIn : function(response){
                let data=JSON.parse(response);
                if(data.status == 'success'){
                    window.location.href='{{ url('admins/dashboard') }}';
                }
            }
        }
    </script>
@endsection