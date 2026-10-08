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
{{-- yield css --}}
     @yield('css')
    <title>{{ config('app.name') }} • Users • @yield('title') </title>
    <style>
main{
    background:white;
}
.input-container{
    border-radius:1000px;
    background:var(--primary-005);
    box-shadow:0 0 10px 10px rgba(0,0,0,0.03);
    height:45px;
    background:white;
    display:flex;
    flex-direction: row;

}
.input-container:has(input:focus){
box-shadow: 0 0 5px 5px var(--secondary-02)
}
.input-container input{
    border:none;
    height:100%;
    width:100%;
    border-radius:inherit;
    background:transparent;
    padding: 10px 20px !important;
}
form{
    display:flex;
    flex-direction:column;
    gap:15px;
    width:100%;
}
button.post{
    background:var(--primary);
    color:var(--primary-text);
    border-radius:100px;
    text-transform: uppercase;
    font-weight: 800;
    font-size:0.8rem;
    height:45px;

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
    header img{
        max-height:200px;
    }
    form{
        max-width:500px;
    }
}
      
    </style>
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
    Language : false
 }" x-init="
 $watch('Inform.Status', (value) => {
   $nextTick(() => {
     if(value != ''){
        setTimeout(() => {
            Inform.Status = '';
            Inform.Message = '';
        }, 2000);
    }
   })
 });
 $nextTick(() => {
     if(Inform.Status != ''){
        setTimeout(() => {
            Inform.Status = '';
            Inform.Message = '';
        }, 2000);
    }
   });
 $watch('Loading', (value) => {
    if(value){
        $el.classList.add('overflow-hidden');
    }else{
        $el.classList.remove('overflow-hidden');
    }
 });
 $watch('Language', (value) => {
    if(value){
        $el.classList.add('overflow-hidden');
    }else{
        $el.classList.remove('overflow-hidden');
    }
 })
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
    <header class="pos-relative bg-light">
<img src="{{ asset('banners/D37EE46C-7C7E-4BF4-9EAD-590D56C22F8C-compressed.jpeg') }}" alt="" class="w-full no-pointer no-select max-w-full">
 <div x-on:click="Language = true" class="pos-absolute box-shadow top-10px right-10px br-5px bg-light c-secondary no-select p-10px">
    Language
 </div>
<div style="background:linear-gradient(to bottom,transparent,rgba(255,255,255,0.7),rgba(255,255,255,1));height:50%;" class="pos-absolute w-full column p-20px align-center bottom-0 left-0 right-0">
    <img src="{{ asset(config('settings.logo')) }}" alt="" class="h-full perfect-square no-shrink no-select circle">
 </div>
</header>
    <main>
        {{-- yield main --}}
       
          @yield('main')
          <section x-show="Language" x-transition:enter-start="fade-enter" x-transition:enter-end="fade-enter-end" x-transition:leave-start="fade-leave" x-transition:leave-end="fade-leave-end" class="pos-fixed transition-all z-index-3000 inset-0 column align-center justify-end bg-black-transparent">
            <div x-on:click.outside="Language = false" x-show="Language" x-transition:enter-start="bottom-enter" x-transition:enter-end="bottom-enter-end" x-transition:leave-start="bottom-leave" x-transition:leave-end="bottom-leave-end" class="w-full transition-all p-bottom-30px bg-light column align-center p-15px">
                <span class="font-size-1rem">English</span>
            </div>
          </section>
    </main>
    <footer>

    </footer>
  @include('components.utilities',[
    'vite_js' => true
  ])
  {{-- yield js --}}
    @yield('js')
</body>
</html>