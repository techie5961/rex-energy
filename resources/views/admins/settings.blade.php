@extends('layout.admins.app')
@section('title')
    Site Settings
@endsection
@section('css')
   <style class="css">
    form{
        border:1px solid var(--rgt-01);
        
    }
   </style>
@endsection
@section('main')
    <section class="w-full column g-20">
       <div class="column g-5">
         <strong style="font-size:1.5rem;">Settings</strong>
        <span class="opacity-07">preferences & configuration</span>

       </div>
         {{-- FINANCE SETTINGS --}}
        <form method="POST" onsubmit="PostRequest(event,this)" action="{{ url('admins/post/finance/settings/process') }}" class="w-full column social-settings-form settings-form g-10 bg-light br-primary p-20">
           
            <div class="row m-bottom-10 c-primary g-5 align-center">
                <span>
<svg viewBox="0 0 24 24" fill="CurrentColor" xmlns="http://www.w3.org/2000/svg" height="30" width="30"><path d="M12.0049 22.0027C6.48204 22.0027 2.00488 17.5256 2.00488 12.0027C2.00488 6.4799 6.48204 2.00275 12.0049 2.00275C17.5277 2.00275 22.0049 6.4799 22.0049 12.0027C22.0049 17.5256 17.5277 22.0027 12.0049 22.0027ZM9.00488 13.0027V15.0027H8.00488V17.0027H16.0049V15.0027H11.0049V13.0027H14.0049V11.0027H11.0049V10.0027C11.0049 9.17432 11.6765 8.50275 12.5049 8.50275C13.0329 8.50275 13.4971 8.77553 13.7644 9.18786L15.7509 8.69125C15.2319 7.40804 13.9741 6.50275 12.5049 6.50275C10.5719 6.50275 9.00488 8.06975 9.00488 10.0027V11.0027H8.00488V13.0027H9.00488Z"></path></svg>

                </span>
                <strong class="desc font-weight-900">Finance Settings</strong>
            </div>
            {{-- csrf token --}}
            <input type="hidden" class="inp input" name="_token" value="{{ @csrf_token() }}">
            
            {{-- new input --}}
            <div class="row align-center space-between g-5 w-full">
               <div class="column g-2">
                 <label class="font-weight-900">Withdrawal portal</label>
                <small class="opacity-05">Enable or disable withdrawal portal</small>
                </div> 
                <div class="toggle {{ ($finance_settings->withdrawal->portal ?? 'off') == 'on' ? 'active' : '' }}">
                    <div onclick="MyFunc.ToggleBar(this,'withdrawal_portal')" class="child"></div>
                </div>
                <input type="hidden" name="withdrawal_portal" value="{{ $general_settings->withdrawal->portal ?? 'off' }}" class="inp input">
            </div>

              {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Welcome Bonus(₦)</label>
                <small class="opacity-05">Set to zero if no welcome bonus</small>
                </div> 
                <div class="cont">
                    <input value="{{ $finance_settings->welcome_bonus ?? '' }}" name="welcome_bonus" type="number" placeholder="E.g ₦1000" class="inp required input">
                </div>
              
                  </div>
             
            {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Minimum Withdrawal(₦)</label>
                <small class="opacity-05">Set to zero if no minimum</small>
                </div> 
                <div class="cont">
                    <input value="{{ $finance_settings->withdrawal->minimum ?? '' }}" name="minimum_withdrawal" type="number" placeholder="E.g ₦1000" class="inp required input">
                </div>
              
                  </div>

                   {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Maximum Withdrawal(₦)</label>
                <small class="opacity-05">Set to zero if no maximum</small>
                </div> 
                <div class="cont">
                    <input value="{{ $finance_settings->withdrawal->maximum ?? '' }}" name="maximum_withdrawal" type="number" placeholder="E.g ₦50000" class="inp required input">
                </div>
              
                  </div>

                   {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Withdrawal Fee(%)</label>
                <small class="opacity-05">Set to zero if no fee</small>
                </div> 
                <div class="cont">
                    <input value="{{ $finance_settings->withdrawal->fee ?? '' }}" name="withdrawal_fee" type="number" placeholder="E.g 15%" class="inp required input">
                </div>
              
                  </div>
                  
                   {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Withdrawal Time</label>
                </div> 
               <div class="row align-center g-10px space-between">
                <div class="column w-full g-5px">
                    <small>Start</small>
                     <div class="cont">
                    <input value="{{ $finance_settings->withdrawal->start_time  }}" name="withdrawal_start_time" type="time" placeholder="E.g 8AM" class="inp required input">
                </div>
                </div>
                <small class="ws-nowrap">TO</small>
                  <div class="column w-full g-5px">
                    <small>End</small>
                     <div class="cont">
                    <input value="{{ $finance_settings->withdrawal->end_time  }}" name="withdrawal_end_time" type="time" placeholder="E.g 9PM" class="inp required input">
                </div>
                </div>
               </div>
              
                  </div>
                    
                  
                   {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Maximum daily withdrawal</label>
                <small class="opacity-05">How many times a user can withdraw daily</small>
                </div> 
                <div class="cont">
                    <input value="{{ $finance_settings->withdrawal->daily ?? '' }}" name="max_daily_withdrawal" type="number" placeholder="E.g 5" class="inp required input">
                </div>
              
                  </div>
                    
                        
           
           
            {{-- submit button --}}
            <button class="post">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M208,32H83.31A15.86,15.86,0,0,0,72,36.69L36.69,72A15.86,15.86,0,0,0,32,83.31V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM128,184a32,32,0,1,1,32-32A32,32,0,0,1,128,184ZM172,80a4,4,0,0,1-4,4H88a4,4,0,0,1-4-4V48h88Z"></path></svg>

                </span>
                <span>Save Changes</span>
            </button>
        </form>

        {{-- GENERAL SETTINGS --}}
        <form method="POST" onsubmit="PostRequest(event,this)" action="{{ url('admins/post/general/settings/process') }}" class="w-full active column general-settings-form settings-form g-10 bg-light br-primary p-20">
           
            <div class="row m-bottom-10 c-primary g-5 align-center">
                <span>
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="30" width="30"><path d="M128,24h0A104,104,0,1,0,232,128,104.12,104.12,0,0,0,128,24Zm78.36,64H170.71a135.28,135.28,0,0,0-22.3-45.6A88.29,88.29,0,0,1,206.37,88ZM216,128a87.61,87.61,0,0,1-3.33,24H174.16a157.44,157.44,0,0,0,0-48h38.51A87.61,87.61,0,0,1,216,128ZM128,43a115.27,115.27,0,0,1,26,45H102A115.11,115.11,0,0,1,128,43ZM102,168H154a115.11,115.11,0,0,1-26,45A115.27,115.27,0,0,1,102,168Zm-3.9-16a140.84,140.84,0,0,1,0-48h59.88a140.84,140.84,0,0,1,0,48Zm50.35,61.6a135.28,135.28,0,0,0,22.3-45.6h35.66A88.29,88.29,0,0,1,148.41,213.6Z"></path></svg>
                </span>
                <strong class="desc font-weight-900">General Settings</strong>
            </div>
            {{-- csrf token --}}
            <input type="hidden" class="inp input" name="_token" value="{{ @csrf_token() }}">
            {{-- new input --}}
            <div class="row align-center space-between g-5 w-full">
               <div class="column g-2">
                 <label>Email Verification</label>
                <small class="opacity-05">Enable or disable email verification for signups</small>
                </div> 
                <div class="toggle {{ ($general_settings->email_verification ?? 'off') == 'on' ? 'active' : '' }}">
                    <div onclick="MyFunc.ToggleBar(this,'email_verification')" class="child"></div>
                </div>
                <input type="hidden" name="email_verification" value="{{ $general_settings->email_verification ?? 'off' }}" class="inp input">
            </div>
             {{-- new input --}}
            <div class="row align-center space-between g-5 w-full">
               <div class="column g-2">
                 <label>Maintenance Mode</label>
                <small class="opacity-05">Temporarily disable access for non-admins</small>
                </div> 
                <div class="toggle {{ ($general_settings->maintenance_mode ?? 'off') == 'on' ? 'active' : '' }}">
                    <div onclick="MyFunc.ToggleBar(this,'maintenance_mode')" class="child"></div>
                </div>
                <input type="hidden" name="maintenance_mode" value="{{ $general_settings->maintenance_mode ?? 'off' }}" class="inp input">
            </div>
            {{-- submit button --}}
            <button class="post">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M208,32H83.31A15.86,15.86,0,0,0,72,36.69L36.69,72A15.86,15.86,0,0,0,32,83.31V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM128,184a32,32,0,1,1,32-32A32,32,0,0,1,128,184ZM172,80a4,4,0,0,1-4,4H88a4,4,0,0,1-4-4V48h88Z"></path></svg>

                </span>
                <span>Save Changes</span>
            </button>
        </form>

         {{-- SOCIAL SETTINGS --}}
        <form method="POST" onsubmit="PostRequest(event,this)" action="{{ url('admins/post/social/settings/process') }}" class="w-full column social-settings-form settings-form g-10 bg-light br-primary p-20">
           
            <div class="row m-bottom-10 c-primary g-5 align-center">
                <span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="30" width="30"><path d="M111.59,181.47A8,8,0,0,1,104,192H24a8,8,0,0,1-7.59-10.53l40-120a8,8,0,0,1,15.18,0ZM208,76a52,52,0,1,0-52,52A52.06,52.06,0,0,0,208,76Zm16,68H136a8,8,0,0,0-8,8v56a8,8,0,0,0,8,8h88a8,8,0,0,0,8-8V152A8,8,0,0,0,224,144Z"></path></svg>
             </span>
                <strong class="desc font-weight-900">Social Settings</strong>
            </div>
            {{-- csrf token --}}
            <input type="hidden" class="inp input" name="_token" value="{{ @csrf_token() }}">
            {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Whatsapp Community</label>
                <small class="opacity-05">Leave empty if the platform does not have a whatsappp community</small>
                </div> 
                <div class="cont">
                    <input value="{{ $social_settings->whatsapp_community ?? '' }}" name="whatsapp_community" type="url" placeholder="E.g https://wa.me/platform-whatsapp-community" class="inp input">
                </div>
              
                  </div>
                    {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Telegram Community</label>
                <small class="opacity-05">Leave empty if the platform does not have a telegram community</small>
                </div> 
                <div class="cont">
                    <input value="{{ $social_settings->telegram_community ?? '' }}" name="telegram_community" type="url" placeholder="E.g https://wa.me/platform-telegram-community" class="inp input">
                </div>
              
                  </div>
                           {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Whatsapp Number</label>
                <small class="opacity-05">Leave empty if you have a whatsapp support number</small>
                </div> 
                <div class="cont">
                    <input value="{{ $social_settings->whatsapp_number ?? '' }}" name="whatsapp_number" type="number" inputmode="numeric" placeholder="E.g 09013350351" class="inp input">
                </div>
              
                  </div>
                      {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Telegram Username</label>
                <small class="opacity-05">Leave empty if you have a telegram support number</small>
                </div> 
                <div class="cont">
                    <input value="{{ $social_settings->telegram_username ?? '' }}" name="telegram_username" type="text" placeholder="E.g techie5961" class="inp input">
                </div>
              
                  </div>
      {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Customer Service</label>
                <small class="opacity-05">Leave empty if the platform does not have a customer service</small>
                </div> 
                <div class="cont">
                    <input value="{{ $social_settings->customer_service ?? '' }}" name="customer_service" type="url" placeholder="E.g https://platform-customer-service" class="inp input">
                </div>
              
                  </div>
                          {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Site Notification</label>
                <small class="opacity-05">Leave empty if you are not sending any notification</small>
                </div> 
                <div class="cont">
                    <textarea placeholder="Enter site notification to be displayed to users on login...." name="site_notification" class="inp no-resize input required">{{ $social_settings->site_notification ?? '' }}</textarea>
                     </div>
              
                  </div>
                      {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Marquee Notification</label>
                <small class="opacity-05">Leave empty if you are not sending any notification</small>
                </div> 
                <div class="cont">
                    <input type="text" class="inp input" name="marquee_notification" value="{{ $social_settings->marquee_notification ?? '' }}">
                </div>
              
                  </div>
           
           
            {{-- submit button --}}
            <button class="post">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M208,32H83.31A15.86,15.86,0,0,0,72,36.69L36.69,72A15.86,15.86,0,0,0,32,83.31V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM128,184a32,32,0,1,1,32-32A32,32,0,0,1,128,184ZM172,80a4,4,0,0,1-4,4H88a4,4,0,0,1-4-4V48h88Z"></path></svg>

                </span>
                <span>Save Changes</span>
            </button>
        </form>

          {{-- REFERRAL SETTINGS --}}
        <form method="POST" onsubmit="PostRequest(event,this)" action="{{ url('admins/post/referral/settings/process') }}" class="w-full column social-settings-form settings-form g-10 bg-light br-primary p-20">
           
            <div class="row m-bottom-10 c-primary g-5 align-center">
                <span>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="30" width="30"><path d="M254.3,107.91,228.78,56.85a16,16,0,0,0-21.47-7.15L182.44,62.13,130.05,48.27a8.14,8.14,0,0,0-4.1,0L73.56,62.13,48.69,49.7a16,16,0,0,0-21.47,7.15L1.7,107.9a16,16,0,0,0,7.15,21.47l27,13.51,55.49,39.63a8.06,8.06,0,0,0,2.71,1.25l64,16a8,8,0,0,0,7.6-2.1l40-40,15.08-15.08,26.42-13.21a16,16,0,0,0,7.15-21.46Zm-54.89,33.37L165,113.72a8,8,0,0,0-10.68.61C136.51,132.27,116.66,130,104,122L147.24,80h31.81l27.21,54.41Zm-41.87,41.86L99.42,168.61l-49.2-35.14,28-56L128,64.28l9.8,2.59-45,43.68-.08.09a16,16,0,0,0,2.72,24.81c20.56,13.13,45.37,11,64.91-5L188,152.66Zm-25.72,34.8a8,8,0,0,1-7.75,6.06,8.13,8.13,0,0,1-1.95-.24L80.41,213.33a7.89,7.89,0,0,1-2.71-1.25L51.35,193.26a8,8,0,0,1,9.3-13l25.11,17.94L126,208.24A8,8,0,0,1,131.82,217.94Z"></path></svg>
              </span>
                <strong class="desc font-weight-900">Referral Settings</strong>
            </div>
            {{-- csrf token --}}
            <input type="hidden" class="inp input" name="_token" value="{{ @csrf_token() }}">
            {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Level 1 commission(%)</label>
                <small class="opacity-05">Enter Zero(0) if no level 1 commission</small>
                </div> 
                <div class="cont">
                    <input value="{{ $referral_settings->level_1 ?? '' }}" name="level_1" type="number" placeholder="E.g 10%" class="inp input">
                </div>
              
                  </div>
                    {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Level 2 commission(%)</label>
                <small class="opacity-05">Enter Zero(0) if no level 2 commission</small>
                </div> 
                <div class="cont">
                    <input value="{{ $referral_settings->level_2 ?? '' }}" name="level_2" type="number" placeholder="E.g 5%" class="inp input">
                </div>
              
                  </div>

                      {{-- new input --}}
            <div class="column g-5 w-full">
               <div class="column g-2">
                 <label>Level 3 commission(%)</label>
                <small class="opacity-05">Enter Zero(0) if no level 3 commission</small>
                </div> 
                <div class="cont">
                    <input value="{{ $referral_settings->level_3 ?? '' }}" name="level_3" type="number" placeholder="E.g 2%" class="inp input">
                </div>
              
                  </div>

                
           
           
            {{-- submit button --}}
            <button class="post">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M208,32H83.31A15.86,15.86,0,0,0,72,36.69L36.69,72A15.86,15.86,0,0,0,32,83.31V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM128,184a32,32,0,1,1,32-32A32,32,0,0,1,128,184ZM172,80a4,4,0,0,1-4,4H88a4,4,0,0,1-4-4V48h88Z"></path></svg>

                </span>
                <span>Save Changes</span>
            </button>
        </form>
    </section>
@endsection
@section('js')
    <script class="js">
        window.MyFunc = {
            ToggleBar : function(element,input_name){
                if(element.closest('.toggle').classList.contains('active')){
                    element.closest('.toggle').classList.remove('active');
                    element.closest('form').querySelector(`input[name=${input_name}]`).value='off';
                }else{
                    element.closest('.toggle').classList.add('active');
                    element.closest('form').querySelector(`input[name=${input_name}]`).value='on';
                }
            },
            SwitchForm : function(element,form_type){
             try{
                
               
                document.querySelectorAll('.settings-head').forEach((data)=>{
                    data.classList.remove('active');
                    
                });
                document.querySelectorAll('.settings-form').forEach((data)=>{
                    data.classList.remove('active');
                });
                element.classList.add('active');
                document.querySelector(form_type).classList.add('active');
                
            
             }catch(error){
                alert(error.stack)
             }
            
            }

           
        }
       
    </script>
@endsection