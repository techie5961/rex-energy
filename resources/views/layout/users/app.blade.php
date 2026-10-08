<!DOCTYPE html>
<html lang="en">
<head>
    {{-- include meta tags --}}
   @include('components.utilities',[
    'meta_tags' => true
   ])
{{-- include favicon --}}
@include('components.utilities',[
    'favicon' => true
])
{{-- include vite css --}}
@include('components.utilities',[
    'vite_css' => true
])
      @include('components.utilities',[
    'vite_js' => true
  ])
  <script>
    function Redirect(url,element=false){
        if(element){
            element.classList.add('animate');

            element.addEventListener('animationend',()=>{
                element.classList.remove('animate');
            })
        }
       Vitecss.navigate(url);
    }
    window.addEventListener('load',()=>{
        document.body.style.paddingBottom=document.querySelector('footer').offsetHeight + 'px';
    })
  </script>
    <title>{{ config('app.name') }} • Users • @yield('title') </title>
    <style>
        main{
            background:var(--bg);
            color:var(--text);
        }
        body{
            background:var(--primary);
            color:var(--primary-text);
        }
       header{
        background:var(--bg);
       }
        header.overlayed,.group.overlayed{
                transform:translateY(5px) scale(0.95);
        }
        header.overlayed{
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .cont{
            height:40px;
            border:1px solid var(--primary-05);
            background:rgb(0,0,0,0.5)
        }
        .inform{
    position: fixed;
    top:20px;
    left:50%;
    transform:translateX(-50%);
    padding:10px;
    border-radius:10px;
    display:flex;
    flex-direction: row;
    gap:10px;
    z-index:7000 !important;
    max-width:80%;

}
.inform.success{
    background: #4caf50;
    z-index:5000;
    color:white;
    
}
.inform.error{
    background: red;
    z-index:5000;
    color:white;
    
}
.inform.info{
    background: #444;
    z-index:5000;
    color:white;
    
}
       
        @media(min-width:800px){
            footer,main{
                padding-left:15vw;
                padding-right:15vw;
            }
        }
       
    </style>

    {{-- yield css --}}
     @yield('css')
     {{-- stack css --}}
     @stack('css')
</head>
<body x-on:vitecss:navigated.document="
Inform.Status = '';
Inform.Message = '';
" x-data="{ 
    Inform : {
        Status : '',
        Message : ''
    },
    Loading : false,
 }" x-init="
 $watch('Inform.Status', (value) => {
   $nextTick(() => {
     if(value != ''){
        setTimeout(() => {
            Inform.Status = '';
            Inform.Message = '';
        }, 4000);
    }
   })
 });
 $nextTick(() => {
     if(Inform.Status != ''){
        setTimeout(() => {
            Inform.Status = '';
            Inform.Message = '';
        }, 4000);
    }
   });
 $watch('Loading', (value) => {
    if(value){
        $el.classList.add('overflow-hidden');
    }else{
        $el.classList.remove('overflow-hidden');
    }
 });
 
 ">
    <section x-show="Loading" class="pos-fixed inset-0 z-index-9000 bg-transparent column align-center justify-center">
<div class="h-100px w-100px column align-center br-10px backdrop-blur-10px justify-center bg-black-transparent c-white">
    <?xml version="1.0" encoding="utf-8"?><svg height="50" width="50" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 2400 2400" xml:space="preserve"><g stroke-width="200" stroke-linecap="round" stroke="currentColor" fill="none" id="spinner"><line x1="1200" y1="600" x2="1200" y2="100"/><line opacity="0.5" x1="1200" y1="2300" x2="1200" y2="1800"/><line opacity="0.917" x1="900" y1="680.4" x2="650" y2="247.4"/><line opacity="0.417" x1="1750" y1="2152.6" x2="1500" y2="1719.6"/><line opacity="0.833" x1="680.4" y1="900" x2="247.4" y2="650"/><line opacity="0.333" x1="2152.6" y1="1750" x2="1719.6" y2="1500"/><line opacity="0.75" x1="600" y1="1200" x2="100" y2="1200"/><line opacity="0.25" x1="2300" y1="1200" x2="1800" y2="1200"/><line opacity="0.667" x1="680.4" y1="1500" x2="247.4" y2="1750"/><line opacity="0.167" x1="2152.6" y1="650" x2="1719.6" y2="900"/><line opacity="0.583" x1="900" y1="1719.6" x2="650" y2="2152.6"/><line opacity="0.083" x1="1750" y1="247.4" x2="1500" y2="680.4"/><animateTransform attributeName="transform" attributeType="XML" type="rotate" keyTimes="0;0.08333;0.16667;0.25;0.33333;0.41667;0.5;0.58333;0.66667;0.75;0.83333;0.91667" values="0 1199 1199;30 1199 1199;60 1199 1199;90 1199 1199;120 1199 1199;150 1199 1199;180 1199 1199;210 1199 1199;240 1199 1199;270 1199 1199;300 1199 1199;330 1199 1199" dur="0.83333s" begin="0s" repeatCount="indefinite" calcMode="discrete"/></g></svg>

</div>
 </section>
    <div x-show="Inform.Message !== '' && Inform.Status !== ''" x-bind:class="Inform.Status" x-transition:enter-start="fade-enter" x-transition:enter-end="fade-enter-end" x-transition:leave-start="fade-leave" x-transition:leave-end="fade-leave-end" class="transition-all inform">
       <div x-show="Inform.Status == 'success'" class="w-20px h-20px no-shrink">
         <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
  <g fill="currentColor">
    <path d="m16,1C7.729,1,1,7.729,1,16s6.729,15,15,15,15-6.729,15-15S24.271,1,16,1Zm-2.43,21.985l-5.984-5.985,1.414-1.414,4.43,4.429,9.437-11.423,1.542,1.273-10.838,13.119Z" stroke-width="0" fill="currentColor"></path>
  </g>
</svg>
       </div>
       <div x-show="Inform.Status == 'error'" class="w-20px h-20px no-shrink">

<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
  <g fill="currentColor">
    <path d="m16,1C7.729,1,1,7.729,1,16s6.729,15,15,15,15-6.729,15-15S24.271,1,16,1Zm6.414,20l-1.414,1.414-5-5-5,5-1.414-1.414,5-5-5-5,1.414-1.414,5,5,5-5,1.414,1.414-5,5,5,5Z" stroke-width="0" fill="currentColor"></path>
  </g>
</svg>
       </div>
       <div x-show="Inform.Status == 'info'" class="w-20px h-20px no-shrink">

<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 12 12">
  <g fill="currentColor">
    <path d="m6,0C2.691,0,0,2.691,0,6s2.691,6,6,6,6-2.691,6-6S9.309,0,6,0Zm.75,8.5c0,.414-.336.75-.75.75s-.75-.336-.75-.75v-3c0-.414.336-.75.75-.75s.75.336.75.75v3Zm-.75-4.5c-.482,0-.875-.393-.875-.875s.393-.875.875-.875.875.393.875.875-.393.875-.875.875Z" stroke-width="0" fill="currentColor"></path>
  </g>
</svg>
       </div>
<span x-text="Inform.Message"></span>
    </div>
    {{-- include action loader for post requests,get requests and spa loading --}}
    @include('components.utilities',[
        'action_loader' => true
    ])  
{{-- include general codes --}}
    @include('components.utilities',[
        'general_codes' => true
    ])
        <header class="transition-all">
   @hasSection ('header')
       @yield('header')
 
   @endif
    </header>

    <main>
        
        {{-- yield main --}}
        @yield('main')
    </main>
    <footer class="w-full br-top-right-10px br-top-left-10px pos-fixed bottom-0 bg-light row align-center space-between z-index-3000">
    {{-- new link --}}
    @php
        $url = url('users/dashboard')
    @endphp
        <div x-on:click="Vitecss.navigate('{{ $url }}')" class="w-full column align-center {{ $url == url()->current() ? 'c-secondary border-bottom-width-3px border-bottom-style-solid border-bottom-color-secondary' : 'c-rgt-07' }} p-10px">
        <i style="background:{{ $url == url()->current() ? 'var(--secondary-01)' : '' }} " class="br-1000px p-5px w-full row align-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
  <g fill="currentColor">
    <path d="M7.94127 1.36281C8.56694 0.887445 9.4333 0.886569 10.0591 1.36312L15.3088 5.35287C15.7448 5.68398 16 6.20008 16 6.746V14.25C16 15.7692 14.7692 17 13.25 17H9.75V13.75C9.75 13.3358 9.41421 13 9 13C8.58579 13 8.25 13.3358 8.25 13.75V17H4.75C3.23079 17 2 15.7692 2 14.25V6.746C2 6.19867 2.2559 5.68346 2.69155 5.3526L7.94127 1.36281Z" fill="currentColor"></path>
  </g>
</svg>
        </i>
        <small class="font-weight-700">Home</small>
      </div>
       {{-- new link --}}
    @php
        $url = url('users/products/active')
    @endphp
        <div x-on:click="Vitecss.navigate('{{ $url }}')" class="w-full column align-center {{ $url == url()->current() ? 'c-secondary border-bottom-width-3px border-bottom-style-solid border-bottom-color-secondary' : 'c-rgt-07' }} p-10px">
        <i style="background:{{ $url == url()->current() ? 'var(--secondary-01)' : '' }} " class="br-1000px p-5px w-full row align-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
  <g fill="currentColor">
    <path d="m7.382,11l2.618-5.236,4,8,1.382-2.764h6.618v-6c0-1.654-1.346-3-3-3H5c-1.654,0-3,1.346-3,3v6h5.382Z" stroke-width="0" fill="currentColor"></path>
    <path d="m16.618,13l-2.618,5.236-4-8-1.382,2.764H2v6c0,1.654,1.346,3,3,3h14c1.654,0,3-1.346,3-3v-6h-5.382Z" fill="currentColor" stroke-width="0"></path>
  </g>
</svg>
        </i>
        <small class="font-weight-700">Income</small>
      </div>
          {{-- new link --}}
    @php
        $url = url('users/referrals')
    @endphp
        <div x-on:click="Vitecss.navigate('{{ $url }}')" class="w-full column align-center {{ $url == url()->current() ? 'c-secondary border-bottom-width-3px border-bottom-style-solid border-bottom-color-secondary' : 'c-rgt-07' }} p-10px">
        <i style="background:{{ $url == url()->current() ? 'var(--secondary-01)' : '' }} " class="br-1000px p-5px w-full row align-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="18" width="18"><path d="M64.12,147.8a4,4,0,0,1-4,4.2H16a8,8,0,0,1-7.8-6.17,8.35,8.35,0,0,1,1.62-6.93A67.79,67.79,0,0,1,37,117.51a40,40,0,1,1,66.46-35.8,3.94,3.94,0,0,1-2.27,4.18A64.08,64.08,0,0,0,64,144C64,145.28,64,146.54,64.12,147.8Zm182-8.91A67.76,67.76,0,0,0,219,117.51a40,40,0,1,0-66.46-35.8,3.94,3.94,0,0,0,2.27,4.18A64.08,64.08,0,0,1,192,144c0,1.28,0,2.54-.12,3.8a4,4,0,0,0,4,4.2H240a8,8,0,0,0,7.8-6.17A8.33,8.33,0,0,0,246.17,138.89Zm-89,43.18a48,48,0,1,0-58.37,0A72.13,72.13,0,0,0,65.07,212,8,8,0,0,0,72,224H184a8,8,0,0,0,6.93-12A72.15,72.15,0,0,0,157.19,182.07Z"></path></svg>

        </i>
        <small class="font-weight-700">Team</small>
      </div>
            {{-- new link --}}
    @php
        $url = url('users/invite')
    @endphp
        <div x-on:click="Vitecss.navigate('{{ $url }}')" class="w-full column align-center {{ $url == url()->current() ? 'c-secondary border-bottom-width-3px border-bottom-style-solid border-bottom-color-secondary' : 'c-rgt-07' }} p-10px">
        <i style="background:{{ $url == url()->current() ? 'var(--secondary-01)' : '' }} " class="br-1000px p-5px w-full row align-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="18" width="18"><path d="M212,200a36,36,0,1,1-69.85-12.25l-53-34.05a36,36,0,1,1,0-51.4l53-34a36.09,36.09,0,1,1,8.67,13.45l-53,34.05a36,36,0,0,1,0,24.5l53,34.05A36,36,0,0,1,212,200Z"></path></svg>

        </i>
        <small class="font-weight-700">Share</small>
      </div>
           {{-- new link --}}
    @php
        $url = url('users/profile')
    @endphp
        <div x-on:click="Vitecss.navigate('{{ $url }}')" class="w-full column align-center {{ $url == url()->current() ? 'c-secondary border-bottom-width-3px border-bottom-style-solid border-bottom-color-secondary' : 'c-rgt-07' }} p-10px">
        <i style="background:{{ $url == url()->current() ? 'var(--secondary-01)' : '' }} " class="br-1000px p-5px w-full row align-center justify-center">
<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 12 12">
  <g fill="currentColor">
    <circle cx="6" cy="2.491" r="2.5" fill="currentColor" stroke-width="0"></circle>
    <path d="m10.533,8.639c-.932-1.628-2.669-2.639-4.533-2.639s-3.602,1.011-4.533,2.639c-.249.434-.305.954-.154,1.428.15.472.496.863.947,1.072,1.241.574,2.49.861,3.74.861s2.499-.287,3.74-.861h0c.451-.209.796-.6.947-1.072.151-.474.095-.994-.154-1.427Z" stroke-width="0" fill="currentColor"></path>
  </g>
</svg>
        </i>
        <small class="font-weight-700">Me</small>
      </div>

    </footer>
  {{-- yield js --}}
    @yield('js')
    {{-- stack js --}}
    @stack('js')
    
</body>
</html>