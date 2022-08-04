<x-user-layout>
@section('content')
    <div class="container">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        <div class="row mt-5">
            @foreach ($products as $product)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <img src="{{$product->image}}" alt="..." width="230" height="200">
                        <div class="mt-2">
                            <a href="#" style="color:black"><h5>{{$product->name}}</h5></a><span><i class="fa-solid fa-indian-rupee-sign"></i> {{$product->price}}</span>
                        </div>
                        <div>
                            <p>{{substr($product->description,0,140)}}</p>
                        </div>
                        <div>
                            <a href="{{route('order-detail',$product->id)}}" class="btn btn-primary form-control"><i class="fa-solid fa-cart-shopping"></i> Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
</x-user-layout>
