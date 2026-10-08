@extends('layout.admins.app')
@section('title')
    Notifications
@endsection
@section('main')
     <section class="column g-10 w-full">
         {{-- analytic --}}
        <div style="border:1px solid var(--primary-01)" class="p-20 w-full br-primary bg-light column g-10">
            <div class="row w-full g-10">
                <div style="color:green;background:rgba(0,255,0,0.3);border:1px solid green;" class="h-full p-10 br-10 column align-center justify-center perfect-square">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="30" width="30"><path d="M225.29,165.93C216.61,151,212,129.57,212,104a84,84,0,0,0-168,0c0,25.58-4.59,47-13.27,61.93A20.08,20.08,0,0,0,30.66,186,19.77,19.77,0,0,0,48,196H84.18a44,44,0,0,0,87.64,0H208a19.77,19.77,0,0,0,17.31-10A20.08,20.08,0,0,0,225.29,165.93ZM128,212a20,20,0,0,1-19.6-16h39.2A20,20,0,0,1,128,212ZM54.66,172C63.51,154,68,131.14,68,104a60,60,0,0,1,120,0c0,27.13,4.48,50,13.33,68Z"></path></svg>
                 </div>
                <div class="column g-5">
                    <span>Total Notifications</span>
                    <strong class="font-1-5">{{ number_format($total) }}</strong>
                </div>
            </div>
        </div>
          {{-- analytic --}}
        <div style="border:1px solid var(--primary-01)" class="p-20 w-full br-primary bg-light column g-10">
            <div class="row w-full g-10">
                <div style="color:green;background:rgba(0,255,0,0.3);border:1px solid green;" class="h-full p-10 br-10 column align-center justify-center perfect-square">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="30" width="30"><path d="M225.81,74.65A11.86,11.86,0,0,1,220.3,76a12,12,0,0,1-10.67-6.47,90.1,90.1,0,0,0-32-35.38,12,12,0,1,1,12.8-20.29,115.25,115.25,0,0,1,40.54,44.62A12,12,0,0,1,225.81,74.65ZM46.37,69.53a90.1,90.1,0,0,1,32-35.38A12,12,0,1,0,65.6,13.86,115.25,115.25,0,0,0,25.06,58.48a12,12,0,0,0,5.13,16.17A11.86,11.86,0,0,0,35.7,76,12,12,0,0,0,46.37,69.53Zm173.51,98.35A20,20,0,0,1,204,200H171.81a44,44,0,0,1-87.62,0H52a20,20,0,0,1-15.91-32.12c7.17-9.33,15.73-26.62,15.88-55.94A76,76,0,0,1,204,112C204.15,141.26,212.71,158.55,219.88,167.88ZM147.6,200H108.4a20,20,0,0,0,39.2,0Zm48.74-24c-8.16-13-16.19-33.57-16.34-63.94A52,52,0,1,0,76,112c-.15,30.42-8.18,51-16.34,64Z"></path></svg>
                 </div>
                <div class="column g-5">
                    <span>Unread</span>
                    <strong class="font-1-5">{{ number_format($unread) }}</strong>
                </div>
            </div>
        </div>
           {{-- analytic --}}
        <div style="border:1px solid var(--primary-01)" class="p-20 w-full br-primary bg-light column g-10">
            <div class="row w-full g-10">
                <div style="color:green;background:rgba(0,255,0,0.3);border:1px solid green;" class="h-full p-10 br-10 column align-center justify-center perfect-square">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="30" width="30"><path d="M216.88,207.93l-160-176A12,12,0,1,0,39.12,48.07l14.8,16.29A83.58,83.58,0,0,0,44,104c0,25.58-4.59,47-13.27,61.93A20.08,20.08,0,0,0,30.68,186,19.75,19.75,0,0,0,48,196H84.19a44,44,0,0,0,87.62,0h1.79l25.52,28.07a12,12,0,0,0,17.76-16.14ZM68,104a59.84,59.84,0,0,1,3.52-20.29L151.78,172H54.68C63.52,154,68,131.14,68,104Zm60,108a20,20,0,0,1-19.6-16h39.2A20,20,0,0,1,128,212ZM88.89,42.35a12,12,0,0,1,6.37-15.73A84,84,0,0,1,212,104c0,18.68,2.38,34.93,7.07,48.28a12,12,0,1,1-22.64,8C190.83,144.32,188,125.4,188,104a60,60,0,0,0-83.38-55.28A12,12,0,0,1,88.89,42.35Z"></path></svg>
                </div>
                <div class="column g-5">
                    <span>Read</span>
                    <strong class="font-1-5">{{ number_format($read) }}</strong>
                </div>
            </div>
        </div>
       @if ($unread > 0)
            <button class="btn-green-3d m-left-auto" onclick="window.location.href='{{ url('admins/notifications/mark/all/as/read') }}'">Mark all as read</button>
      
       @endif
       @if ($notifications->isEmpty())
           @include('components.utilities',[
            'empty' => true,
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="50" width="50"><path d="M221.84,192v0a1.85,1.85,0,0,1-3,.28L83.27,43.19a4,4,0,0,1,.8-6A79.55,79.55,0,0,1,129.17,24C173,24.66,207.8,61.1,208,104.92c.14,34.88,8.31,61.54,13.82,71A15.89,15.89,0,0,1,221.84,192ZM160,216H96.22A8.19,8.19,0,0,0,88,223.47,8,8,0,0,0,96,232h63.74a8.19,8.19,0,0,0,8.26-7.47A8,8,0,0,0,160,216ZM53.84,34.62A8,8,0,1,0,42,45.38L58.79,63.85A79.42,79.42,0,0,0,47.93,104c0,35.09-8.15,62-13.7,71.73a16.42,16.42,0,0,0,.09,16.68A15.78,15.78,0,0,0,47.91,200H182.62l19.45,21.38a8,8,0,0,0,11.85-10.76Z"></path></svg>',
            'text' => 'No Notification Found'
           ])
       @else
           <div class="grid w-full g-10 pc-grid-2 place-center">
               @foreach ($notifications as $data)
              <div style="border:1px solid var(--rgt-01);" class="w-full bg-light br-primary p-20 g-10 column">
             {{-- new row --}}
                <div class="row w-full align-center space-between">
                <div style="background:var(--primary-01)" class="w-40 circle perfect-square no-shrink column align-center justify-center">
                    @isset($data->icon)
                        {!! $data->icon !!}
                        @else 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06ZM128,216a24,24,0,0,1-22.62-16h45.24A24,24,0,0,1,128,216Z"></path></svg>

                    @endisset
                </div>
                <div class="status {{ json_decode($data->status)->admins == 'read' ? 'green' : 'gold' }}">{{ json_decode($data->status)->admins }}</div>
             </div>
             {{-- new row --}}
             <strong class="desc c-primary">{{ json_decode($data->title)->admins }}</strong>
             {{-- new row --}}
             <div>
                {!! json_decode($data->body)->admins !!}
             </div>
             {{-- new row --}}
             <div class="row align-center g-10 space-between">
                <a class="c-primary g-5 row align-center" href="{{ json_decode($data->url)->admins }}">
                    <span class="h-fit column">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="12" width="12"><path d="M232.49,215.51,185,168a92.12,92.12,0,1,0-17,17l47.53,47.54a12,12,0,0,0,17-17ZM44,112a68,68,0,1,1,68,68A68.07,68.07,0,0,1,44,112Z"></path></svg>

                    </span>
                   <span>
                     View More
                   </span>
                </a>
               @if (json_decode($data->status)->admins == 'unread')
                    <a class="c-primary g-5 row align-center" href="{{ url('admins/notification/mark/as/read?id='.$data->id.'') }}">
                    <span class="h-fit column">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="12" width="12"><path d="M152.41,88.56l-89.6,88a12,12,0,0,1-16.82,0L7.59,138.85a12,12,0,0,1,16.82-17.13l30,29.46,81.19-79.74a12,12,0,0,1,16.82,17.12Zm96.15-17a12,12,0,0,0-17-.15L150.4,151.18l-7.88-7.74a12,12,0,0,0-16.82,17.12l16.29,16a12,12,0,0,0,16.82,0l89.6-88A12,12,0,0,0,248.56,71.59Z"></path></svg>

                    </span>
                   <span>
                    Mark as Read
                   </span>
                </a>
               @endif
             </div>
             {{-- new row --}}
             <div class="p-5 p-x-10 br-1000 w-fit g-5 row align-center justify-center" style="background:var(--primary-01);color:var(--primary-08)">
               <span class="h-fit column">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="15" width="15"><path d="M236,137A108.13,108.13,0,1,1,119,20,12,12,0,0,1,121,44,84.12,84.12,0,1,0,212,135,12,12,0,1,1,236,137ZM116,76v52a12,12,0,0,0,12,12h52a12,12,0,0,0,0-24H140V76a12,12,0,0,0-24,0Zm92,20a16,16,0,1,0-16-16A16,16,0,0,0,208,96ZM176,64a16,16,0,1,0-16-16A16,16,0,0,0,176,64Z"></path></svg>

               </span>
                {{ $data->frame }}
            </div>

            </div>
        @endforeach
           </div>
           @if ($notifications->lastPage() > 1)
               @include('components.utilities',[
                'data' => $notifications,
                'paginate' => true
               ])
           @endif
       @endif
     
     </section>
@endsection