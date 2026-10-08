@extends('layout.users.app')
@section('title')
    Share
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
           Change Password
        </span>
        <span></span>
    </div>
@endsection
@section('main')
    <section  x-data="{ 
      }" x-init="
     
     
      " class="w-full column g-10px">
         <form x-data="{ 
            Inputs : {

            },
            Saving : false,
            Submittable : false
          }" method="POST" action="{{ url('users/post/update/password/process') }}" x-on:submit.prevent="
          Submittable = true;
          $el.querySelectorAll('input[name]').forEach((inp)=>{
            inp.dispatchEvent(new Event('validate'));
            Inputs[inp.name] = inp.value;
          });
          if(!Submittable){
            return;
          }
          Loading = true;
         SendPostRequest($el.action,Inputs,function(response){
          Loading = false;

                let data=JSON.parse(response);
                Inform.Status = data.status;
                Inform.Message = data.message;
                if(data.status == 'success'){
                    Vitecss.navigate('{{ url()->current() }}');
                
                }
            })" class="w-full column p-15px br-10px g-10px box-shadow">



          

               {{-- csrf token --}}
               <input type="hidden" class="input inp required" name="_token" value="{{ @csrf_token() }}">
              
              
               
               
              
              
                {{-- new input --}}
                <div x-data="{ 
                    InputEmpty : false
                 }" class="column g-5 w-full">
                 <label>Current Password</label>
                <div class="w-full bg-rgt-005 border-width-1px border-style-solid border-color-rgt-01 h-45px br-10px">
                    <input x-on:validate="
                    if($el.value == ''){
                        Submittable = false;
                        InputEmpty = true;
                    }
                    " x-on:input="InputEmpty = false;" name="current_password" type="password" placeholder="Enter your current password" class="w-full border-none br-inherit c-text bg-transparent h-full w-full">
                </div>
                <small x-show="InputEmpty" class="c-red">Please enter current password</small>
               </div>
                {{-- new input --}}
                <div x-data="{ 
                    InputEmpty : false
                 }" class="column g-5 w-full">
                 <label>New Password</label>
                <div class="w-full bg-rgt-005 border-width-1px border-style-solid border-color-rgt-01 h-45px br-10px">
                    <input x-on:validate="
                    if($el.value == ''){
                        Submittable = false;
                        InputEmpty = true;
                    }
                    " x-on:input="InputEmpty = false;" name="new_password" type="password" placeholder="Enter your new password" class="w-full border-none br-inherit c-text bg-transparent h-full w-full">
                </div>
                <small x-show="InputEmpty" class="c-red">Please enter new password</small>
               </div>
                {{-- new input --}}
                <div x-data="{ 
                    InputEmpty : false
                 }" class="column g-5 w-full">
                 <label>Confirm Password</label>
                <div class="w-full bg-rgt-005 border-width-1px border-style-solid border-color-rgt-01 h-45px br-10px">
                    <input x-on:validate="
                    if($el.value == ''){
                        Submittable = false;
                        InputEmpty = true;
                    }
                    " x-on:input="InputEmpty = false;" name="confirm_password" type="password" placeholder="Enter new password again" class="w-full border-none br-inherit c-text bg-transparent h-full w-full">
                </div>
                <small x-show="InputEmpty" class="c-red">Please confirm new password</small>
               </div>
              
             <button style="background:linear-gradient(to right,var(--secondary),var(--secondary-light)) !important;" class="bg-secondary h-50px br-10px secondary-text no-select m-top-20px">
              Confirm
             </button>
            
            </form>
            
    </section>
@endsection