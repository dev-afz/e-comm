@extends('components.user-layout')
@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                @php $total = 0; @endphp
                @forelse ($cartItem as $cartitem)
                    <div class="row product_data">
                        <div class="col-md-2">
                            <img src="{{$cartitem->product->image}}" width="70" alt="image here...">
                        </div>
                        <div class="col-md-3">
                            <p>{{$cartitem->product->name}}</p>
                        </div>
                        <div class="col-md-2">
                            <h6>Rs {{$cartitem->product->price}}</h6>
                        </div>
                        <div class="col-md-3">
                            <label for="">Quantity</label>
                            <p>{{$cartitem->prod_qty}}</p>
                            <input type="hidden" name="quantity" value="{{$cartitem->prod_qty}}">
                            <input type="hidden" name="product_id" class="prod_id" value="{{$cartitem->product_id}}">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-danger delete-cart-item"><i class="fa fa-trash"></i> Remove</button>
                        </div>
                    </div>
                    <br>
                    @php
                        $total += $cartitem->product->price * $cartitem->prod_qty;
                    @endphp
                @empty
                <div class="alert alert-warning">Your Cart is Empty</div>
                @endforelse
            </div>
            <div class="card-footer">
                <h6>Total Price : {{$total}}
                @if ($total != 0)
                    <a href="{{route('checkout-payment')}}" class="btn btn-outline-success float-end">Proceed to Checkout</a></h6>
                @else
                    <a href="/" class="btn btn-outline-success float-end">Continue Shopping</a></h6>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $('.delete-cart-item').click(function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var prod_id = $(this).closest('.product_data').find('.prod_id').val();
            $.ajax({
            type: "post",
            url: "{{route('delete-cart-item')}}",
            data: {
                product_id:prod_id,
            },
            success: function (response) {
                window.location.reload();
            }
        });
    });
</script>
@endsection

