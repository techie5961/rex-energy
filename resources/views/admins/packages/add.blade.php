@extends('layout.admins.app')
@section('title')
    Add Product
@endsection
@section('css')
    <style class="css">
        .preview-photo img{
            display:none;
        }
        .preview-photo.active img{
            display:flex;
        }
        .preview-photo.active span{
            display:none;
        }
    </style>
@endsection
@section('main')
    <section class="w-full column g-10">
        <form action="{{ url('admins/post/add/package/process') }}" method="POST" onsubmit="PostRequest(event,this,Completed)" class="w-full column bg-light p-20 g-10 br-primary" style="border:1px solid var(--rgt-01)">
            {{-- head --}}
            <div class="row c-primary no-select font-weight-900 w-full align-center g-10">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="CurrentColor" height="20" width="20"><path d="M24,80a8,8,0,0,1,4-6.91l96-56a8,8,0,0,1,8.06,0l96,56a8,8,0,0,1,0,13.82l-96,56a8,8,0,0,1-8.06,0l-96-56A8,8,0,0,1,24,80Zm196,41.09-92,53.65L36,121.09A8,8,0,0,0,28,134.91l96,56a8,8,0,0,0,8.06,0l96-56A8,8,0,1,0,220,121.09ZM232,192H216V176a8,8,0,0,0-16,0v16H184a8,8,0,0,0,0,16h16v16a8,8,0,0,0,16,0V208h16a8,8,0,0,0,0-16Zm-92,23.76-12,7L36,169.09A8,8,0,0,0,28,182.91l96,56a8,8,0,0,0,8.06,0l16-9.33A8,8,0,1,0,140,215.76Z"></path></svg>

                <strong class="desc font-weight-900">Add New Product</strong>
            </div>
            {{-- csrf token --}}
            <input type="hidden" class="input inp" name="_token" value="{{ @csrf_token() }}">
             {{-- new input --}}
            <div class="column w-full g-5">
                <label class="column g-2">
                    <span>Product Photo</span>
                    <small class="opacity-07">The display photo of the Product</small>
                </label>
                <label class="cont preview-photo column align-center p-20 justify-center h-150">
                    <span class="opacity-05">Product photo(Tap to upload)</span>
                    <img src="" alt="" class="h-full">
                    <input name="photo" onchange="PreviewPhoto(this)" type="file" accept="image/*" class="inp input required display-none">
                </lable>
            </div>
            {{-- new input --}}
            <div class="column w-full g-5">
                <label class="column g-2">
                    <span>Product Name</span>
                    <small class="opacity-07">The name of the Product</small>
                </label>
                <div class="cont">
                    <input name="name" placeholder="E.g VIP 1" type="text" class="inp input required">
                </div>
            </div>
             {{-- new input --}}
            <div class="column w-full g-5">
                <label class="column g-2">
                    <span>Product Price</span>
                    <small class="opacity-07">The Cost/Purchasing price of the Product(in ₦)</small>
                </label>
                <div class="cont">
                    <input name="cost" placeholder="E.g ₦5,000" type="number" class="inp input required">
                </div>
            </div>
            {{-- new input --}}
            <div class="column w-full g-5">
                <label class="column g-2">
                    <span>Daily Earning</span>
                    <small class="opacity-07">The amount earned daily on this Product(in ₦)</small>
                </label>
                <div class="cont">
                    <input name="earning" placeholder="E.g ₦500" type="number" class="inp input required">
                </div>
            </div>
             {{-- new input --}}
            <div class="column w-full g-5">
                <label class="column g-2">
                    <span>Validity</span>
                    <small class="opacity-07">How long the Product would last before expiry(in days)</small>
                </label>
                <div class="cont">
                    <input name="validity" placeholder="E.g 20 days" type="number" class="inp input required">
                </div>
            </div>
              {{-- new input --}}
            <div class="column w-full g-5">
                <label class="column g-2">
                    <span>Purchase Limit</span>
                    <small class="opacity-07">How many of this product a user can purchase</small>
                </label>
                <div class="cont">
                    <input name="purchase_limit" placeholder="E.g 100" type="number" class="inp input required">
                </div>
            </div>
               {{-- new input --}}
            <div class="column w-full g-5">
                <label class="column g-2">
                    <span>VIP Level</span>
                    <small class="opacity-07">Vip level the product is on</small>
                </label>
                <div class="cont">
                    <input name="vip_level" placeholder="E.g 1" type="number" class="inp input required">
                </div>
            </div>
             {{-- new input --}}
            <div class="column w-full g-5">
                <label class="column g-2">
                    <span>Available</span>
                    <small class="opacity-07">How many of the Product is availble (Note that the Product is removed from purchasing when the availability is met)</small>
                </label>
                <div class="cont">
                    <input name="available" placeholder="E.g 200" value="1000" type="number" class="inp input required">
                </div>
            </div>
            <button class="post">Add Product</button>
        </form>
    </section>
@endsection
@section('js')
    <script class="js">
        function PreviewPhoto(element){
            let file=element.files[0];
            if(file){
                element.closest('.preview-photo').querySelector('img').src=URL.createObjectURL(file);
                element.closest('.preview-photo').classList.add('active');
            }else{
                 element.closest('.preview-photo').classList.remove('active');
            }
        }

        function Completed(response){
            let data=JSON.parse(response);
            if(data.status == 'success'){
                window.location.href='{{ url('admins/packages/manage') }}';
            }
        }
    </script>
@endsection