<x-user-layout>
@section('content')
    <div class="container">
        <form action="{{route('create-order')}}" method="post">
            @csrf
        <div class="row mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Basic Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">First Name</label>
                                    <input name="fname" id="" class="form-control fname" required></input>
                                    <span id="fname" class="text-danger"></span>
                                    @error('fname')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Last Name</label>
                                    <input name="lname" id="" class="form-control lname" required></input>
                                    <span id="lname" class="text-danger"></span>
                                    @error('lname')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input name="email" id="" class="form-control email" required></input>
                                    <span id="email" class="text-danger"></span>
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Phone Number</label>
                                    <input name="phone" id="" class="form-control phone" required></input>
                                    <span id="phone" class="text-danger"></span>
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <input name="address" id="" class="form-control address" required></input>
                                    <span id="address" class="text-danger"></span>
                                    @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Pincode</label>
                                    <input name="pincode" id="" class="form-control pincode" required></input>
                                    <span id="pincode" class="text-danger"></span>
                                    @error('pincode')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">City</label>
                                    <input name="city" id="" class="form-control city" required></input>
                                    <span id="city" class="text-danger"></span>
                                    @error('city')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="">State</label>
                                    <input name="state" id="" class="form-control state" required></input>
                                    <span id="state" class="text-danger"></span>
                                    @error('state')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Order Detail</p>
                    </div>
                    <div class="card-body">
                        @php $total = 0; @endphp
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartitems as $item)
                                    <tr>
                                        <td>{{$item->product->name}}</td>
                                        <td>{{$item->prod_qty}}</td>
                                            <input type="hidden" name="quantity" value="{{$item->prod_qty}}">
                                        <td>{{$item->product->price}}</td>
                                            <input type="hidden" name="price" value="{{$item->product->price}}">
                                    </tr>
                                   <input type="hidden" name="cart[]" value="{{$item->id}}">
                                    @php
                                        $total += $item->product->price * $item->prod_qty;
                                    @endphp
                                        <input type="hidden" name="total_price" value="{{$total}}" />
                                        <input type="hidden" name="product_id" value="{{$item->product->id}}">
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group">
                            <input type="checkbox" name="haveCouponCode" value="1" onclick="haveCoupon()" id="check" /><span> I have a coupon code</span>

                            <div class="summary-item" id="summary-item">
                                <form action="">

                                    <p class="row-in-form">
                                        <label for="">Enter your coupon code</label>
                                        <input type="text" name="coupon-code" >
                                    </p>
                                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                </form>
                            </div>
                        </div><hr>
                        <div class="form-group">
                            <label for="">Total : {{$total}}</label>
                        </div>
                        <div class="form-group">
                            <label for="">Payment Mode</label>
                            <select name="payment_type" id="payment_type" class="form-select" required>
                                <option value="">Select</option>
                                <option value="cod">COD</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning form-control cod-btn" id="cod"></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
@endsection
@section('scripts')
<script>
        $(document).ready(function () {
            $('.cod-btn').hide();
            $('.summary-item').hide();
        });
        $('#payment_type').change(function(){
            $('.cod-btn').show();
            const opt = $(this).val();
            $("#cod").text(opt);
        });

        function haveCoupon() {
        let checkBox = document.getElementById('check');
        let coupon = document.getElementById('summary-item');
        if(checkBox.checked == true){
            coupon.style.display = "block";
        }else{
            coupon.style.display = "none";
        }
       }
    </script>
@endsection
</x-user-layout>

