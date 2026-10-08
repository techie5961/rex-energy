@extends('layout.admins.app')
@section('title')
    Login Settings
@endsection
@section('main')
    <section class="w-full column g-10px">
      <div class="column g-5px">
          <strong class="desc font-weight-900 c-primary">Login Settings</strong>
        <small class="opacity-07">Manage and update your account login settings</small>
      </div>
        <form x-data="{ 
            Logout : false
         }" x-on:submit="
        PostRequest(event,$el,function(response){
            let data= JSON.parse(response);
            if(data.status == 'success'){
                window.location.reload();
            }
        })
        " action="{{ url('admins/post/login/settings/process') }}" method="POST" class="w-full column bg-light box-shadow br-15px p-20px g-10px">
         {{-- csrf token --}}
         <input name="_token" type="hidden" value="{{ @csrf_token() }}" class="inp input required">
         {{-- new input --}}
            <div class="w-full column g-5px">
                <label>New Tag</label>
                <div class="cont">
                    <input name="tag" type="text" placeholder="Enter new tag" class="inp input required">
                </div>
            </div>
             {{-- new input --}}
            <div class="w-full column g-5px">
                <label>Current Login password</label>
                <div class="cont">
                    <input name="current_password" type="password" placeholder="Enter current account password" class="inp input required">
                </div>
            </div>
             {{-- new input --}}
            <div class="w-full column g-5px">
                <label>New Login password</label>
                <div class="cont">
                    <input name="new_password" type="password" placeholder="Enter new account password" class="inp input required">
                </div>
            </div>
             {{-- new input --}}
            <div class="w-full column g-5px">
                <label>Confirm new Login password</label>
                <div class="cont">
                    <input name="confirm_password" type="password" placeholder="Retype new account password" class="inp input required">
                </div>
            </div>
            {{-- new --}}
           <div class="row align-center space-between g-10px w-full">
           <div class="column">
             <label>Logout other devices</label>
           </div>
             <div x-bind:class="Logout ? 'active' : ''" class="toggle">
                <div x-on:click="Logout = !Logout" class="child"></div>
            </div>
           </div>
            <button class="post">Submit</button>
        </form>
    </section>
@endsection