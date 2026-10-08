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
            Share
        </span>
        <span></span>
    </div>
@endsection
@section('main')
    <section class="w-full column g-10px">
        <div class="w-full parent pos-relative column g-20px bg-light br-10px p-15px box-shadow">
         <div class="w-full align-center column g-30px">
                <span>My Invite Code</span>
                <strong class="font-weight-900 font-size-1-5rem">{{ Auth::guard('users')->user()->uniqid }}</strong>
              </div>
              <div class="hr" style="border-color:var(--rgt)" vitecss-type="dashed"></div>
          <strong style="font-family:'bar code';width:100%;" class="font-size-3-5rem ws-nowrap overflow-hidden text-align-center">
            {{ Auth::guard('users')->user()->uniqid }}
          </strong>
              <div class="w-full bg-rgt-005 br-10px p-10px row align-center g-10px">
             
                <div class="ws-nowrap text-overflow-ellipsis">
                    {{ url('register?ref='.Auth::guard('users')->user()->uniqid.'') }}
                </div>
                <div x-data="{ 
                    Copied : false
                 }" x-on:click="
                copy('{{ url('register?ref='.Auth::guard('users')->user()->uniqid.'') }}');
                Inform.Message = 'Copied';
                Inform.Status = 'success';
                Copied = true;
                setTimeout(() => {
                    Copied = false;
                }, 2000);
                " x-text="Copied ? 'Copied' : 'Copy'" class="p-5px secondary-text no-select pointer no-shrink ws-nowrap bg-secondary br-10px p-10px">
                </div>
            </div>
        </div>
        <div class="w-full column g-10px bg-light br-10px p-15px box-shadow">
            <span>Share your referral link to friends and families accross social media platforms like Facebook, Tiktok, and Whatsapp groups easily to earn money from home. Commissions are paid instantly and can be withdrawn anytime.</span>
        <div style="border:1px solid var(--secondary-05);color:var(--secondary)" class="w-full column border-width-1px border-style-solid border-color-primary-05">
            <div class="w-full font-weight-800 font-size-1rem p-15px row align-center space-between">
                <span>Level 1</span>
                <span>{{ $referral_settings->level_1 }}%</span>
            </div>
             <div style="border-top:1px solid var(--secondary-05);background:var(--secondary-02)" class="w-full font-weight-800 font-size-1rem p-15px row align-center space-between">
                <span>Level 2</span>
                <span>{{ $referral_settings->level_2 }}%</span>
            </div>
             <div style="border-top:1px solid var(--secondary-05);" class="w-full font-weight-800 font-size-1rem p-15px row align-center space-between">
                <span>Level 3</span>
                <span>{{ $referral_settings->level_3 }}%</span>
            </div>
        </div>
        </div>
    </section>
@endsection