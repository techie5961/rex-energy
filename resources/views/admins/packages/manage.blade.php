@extends('layout.admins.app')
@section('title')
    Manage Packages
@endsection
@section('main')
    <section class="w-full column g-10">
      {{-- analytic --}}
        <div class="w-full p-20 row g-10 bg-light br-primary" style="border:1px solid var(--rgt-01)">
            <div class="h-50 perfect-square br-primary column align-center justify-center" style="border:1px solid #4caf50;background:rgba(0,255,0,0.1);color:#4caf50;">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="30" width="30"><path d="M80,172a12,12,0,1,1-12-12A12,12,0,0,1,80,172Zm40,0a52,52,0,1,1-52-52A52.06,52.06,0,0,1,120,172Zm-24,0a28,28,0,1,0-28,28A28,28,0,0,0,96,172Zm152,16a36,36,0,0,1-71.77,4H144a8,8,0,0,1-8-8V172a68.07,68.07,0,0,0-68-68H40a8,8,0,0,1,0-16h8V56H40a8,8,0,0,1,0-16H160a8,8,0,0,1,0,16h-8V97.88l24,6.5V72a8,8,0,0,1,16,0v36.71l36.39,9.86.21.06A15.89,15.89,0,0,1,240,134v31.46A35.8,35.8,0,0,1,248,188Zm-20,0a16,16,0,1,0-16,16A16,16,0,0,0,228,188Z"></path></svg>
            </div>
            <div class="column g-5">
                <span>Total Products</span>
                <strong class="font-1 font-weight-900">{{ number_format($total) }}</strong>
            </div>
        </div>
        {{-- packages --}}
        @if ($packages->isEmpty())
            @include('components.utilities',[
                'empty' => true,
                'text' => 'No Package Available'
            ])
        @else
           <div class="w-full grid pc-grid-2 g-10 place-center">
             @foreach ($packages as $data)
                <div class="p-20 w-full br-primary g-10 column bg-light" style="border:1px solid var(--rgt-01)">
                   {{-- new row --}}
                    <div style="border-bottom:1px dashed var(--rgt-01);padding-bottom:10px;" class="row flex-wrap space-between w-full g-10">
                     <img src="{{ asset('packages/'.$data->photo.'') }}" alt="Product photo" class="h-100 no-shrink br-5">
                  
                     <div class="column m-right-auto g-5">
                       <div class="w-fit p-5 p-x-10 br-5 no-select" style="background:var(--primary-01);"><span>{{ $data->uniqid }}</span></div>
                   <strong class="font-1 font-weight-900">{{ $data->name }}</strong>
                           </div>
                          
                           <div class="status {{ $data->status == 'active' ? 'green' : 'gold' }}">{{ $data->status }}</div>
                   </div>
                   {{-- new row --}}
                   <div class="row w-full g-10 space-between">
                    <div style="text-align:start;" class="column g-5">
                        <small class="opacity-07">Product Price/Cost</small>
                        <strong>&#8358;{{ number_format($data->cost,2) }}</strong>
                    </div>
                     <div style="text-align:end;" class="column g-5">
                        <small class="opacity-07">Validity</small>
                        <strong>{{ number_format($data->validity) }} Days</strong>        
                    </div>
                   </div>
                   {{-- new row --}}
                   <div class="row w-full g-10 space-between">
                    <div style="text-align:start;" class="column g-5">
                        <small class="opacity-07">Daily Earning</small>
                        <strong>&#8358;{{ number_format($data->earning,2) }}</strong>
                    </div>
                     <div style="text-align:end;" class="column g-5">
                         <small class="opacity-07">Total Earning</small>
                        <strong>&#8358;{{ number_format($data->validity * $data->earning,2) }}</strong>
                    </div>
                   </div>
                    {{-- new row --}}
                   <div class="row w-full g-10 space-between">
                    <div style="text-align:start;" class="column g-5">
                        <small class="opacity-07">Purchase Limit</small>
                        <strong>{{ number_format($data->purchase_limit) }}</strong>
                    </div>
                     <div style="text-align:end;" class="column g-5">
                        <small class="opacity-07">VIP Level</small>
                        <strong>VIP {{ number_format($data->vip_level ?? 0) }}</strong>
                    </div>
                   </div>
                   {{-- new row --}}
                   <div class="row w-full g-10 space-between">
                    <div style="text-align:start;" class="column g-5">
                        <small class="opacity-07">Available</small>
                        <strong>{{ number_format($data->available) }}</strong>
                    </div>
                     <div style="text-align:end;" class="column g-5">
                        <small class="opacity-07">Total Purchased</small>
                        <strong>{{ number_format($data->purchased ?? 0) }} Units</strong>
                    </div>
                   </div>
                     {{-- new row --}}
                   <div class="row w-full g-10 space-between">
                    <div style="text-align:start;" class="column g-5">
                        <small class="opacity-07">Last Updated</small>
                        <strong>{{ $data->updated_frame }}</strong>
                    </div>
                     <div style="text-align:end;" class="column g-5">
                        <small class="opacity-07">Added</small>
                        <strong>{{ $data->date_frame }}</strong>
                    </div>
                   </div>
                   {{-- new row --}}
                   <div style="border-top:1px dashed var(--rgt-01);padding-top:10px;" class="row w-full g-10 align-center space-between">
                    <button onclick="window.location.href='{{ url('admins/package/edit?id='.$data->id.'') }}'" class="btn-green-3d">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="15" width="15"><path d="M224,128v80a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h80a8,8,0,0,1,0,16H48V208H208V128a8,8,0,0,1,16,0Zm5.66-58.34-96,96A8,8,0,0,1,128,168H96a8,8,0,0,1-8-8V128a8,8,0,0,1,2.34-5.66l96-96a8,8,0,0,1,11.32,0l32,32A8,8,0,0,1,229.66,69.66Zm-17-5.66L192,43.31,179.31,56,200,76.69Z"></path></svg>
                         Edit
                    </button>
                    <button onclick="ShowDeleteModal('{{ $data->id }}')" class="btn-red-3d">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="15" width="15"><path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM112,168a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm0-120H96V40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8Z"></path></svg>
                         Delete
                    </button>
                   </div>
                   {{-- new row --}}
                   <div class="row align-center space-between">
                     <button onclick="window.location.href='{{ url('admins/packages/investment/records?package_id='.$data->id.'') }}'" class="btn-primary-3d">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="15" width="15"><path d="M230.14,58.87A8,8,0,0,0,224,56H62.68L56.6,22.57A8,8,0,0,0,48.73,16H24a8,8,0,0,0,0,16h18L67.56,172.29a24,24,0,0,0,5.33,11.27,28,28,0,1,0,44.4,8.44h45.42A27.75,27.75,0,0,0,160,204a28,28,0,1,0,28-28H91.17a8,8,0,0,1-7.87-6.57L80.13,152h116a24,24,0,0,0,23.61-19.71l12.16-66.86A8,8,0,0,0,230.14,58.87ZM104,204a12,12,0,1,1-12-12A12,12,0,0,1,104,204Zm96,0a12,12,0,1,1-12-12A12,12,0,0,1,200,204Z"></path></svg>
                        View Purchase History
                    </button>
                   </div>
                </div>
            @endforeach
           </div>
           @if ($packages->lastPage() > 1)
               @include('components.utilities',[
                'paginate' => true,
                'data' => $packages
               ])
           @endif
        @endif
    </section>
    {{-- delete modal --}}
    <section class="modal delete">
        <div class="child column align-center g-10 text-center">
            {{-- new row --}}
            <div class="w-50 perfect-square no-shrink circle bg-red c-white column align-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="30" width="30"><path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM112,168a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm0-120H96V40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8Z"></path></svg>

            </div>
            {{-- new row --}}
            <strong class="font-size-1">Delete this Product</strong>
            {{-- new row --}}
            <span>Are you sure you want to delete this Product?</span>
            {{-- new row --}}
            <span class="c-red"> Units already purchased won't be affected. This action cannot be undone</span>
            {{-- new row --}}
            <div class="w-full row g-10 align-center space-between">
                <div onclick="this.closest('.modal').classList.remove('active');" class="h-40 no-select pointer br-5 row align-center justify-center bg-black c-white p-10 w-full" style="border:1px solid var(--rgt-10);color:var(--rgt-10)">No, Cancel</div>
             <div onclick="window.location.href='{{ url('admins/package/delete?id=') }}' + this.dataset.id" class="h-40 confirm-delete br-5 no-select pointer bg-primary primary-text row align-center justify-center p-10 w-full">Yes, Delete</div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script class="js">
        function ShowDeleteModal(id){
            document.querySelector('.modal.delete .confirm-delete').dataset.id=id;
            document.querySelector('.modal.delete').classList.add('active');
        }
    </script>
@endsection