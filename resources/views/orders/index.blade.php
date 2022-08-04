<x-user-layout>
@section('content')
<div class="container">
    <form action="/addtocart" method="post">
        @csrf
        <div class="row mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">Shopping Cart</h4>
                            </div>
                            <div class="col-md-6 text-end mt-2">
                                <span>Price</span>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                              <img src="{{asset($product->image)}}" alt="..." width="160">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>{{$product->name}}</h4>
                                        <span class="badge bg-success">In Stock</span><br><br>
                                        <span>Qty : </span><select class="form-select-sm qty" name="quantity" id="mySelect" aria-label=".form-select-sm example">
                                            {{-- <option selected>Qty :</option> --}}
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                          </select>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <h4 data-price='{{$product->price}}' >{{$product->price}}</h4>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <h4>Subtotal (<span  id="subtotal"></span> Item): <i class="fa-solid fa-indian-rupee-sign"></i> <span class="total"></span></h4>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <p>Enter delivery address and proceed</p>
                    </div>
                    <div class="card-body">

                        <div>
                            <input type="hidden" hidden name="product_id" id="product" value="{{$product->id}}">
                            <p name="price">Price : {{$product->price}}</p>
                            <input type="hidden" hidden name="price" id="price">
                            <p class="quantity"></p>
                        </div>
                        <div  class=="mt-5">
                            <h4>Subtotal (<span  class="subtotal"></span> Item): <i class="fa-solid fa-indian-rupee-sign"></i> <span class="total"></span></h4>
                            <input type="hidden" name="subtotal" id="st">
                        </div>
                        @auth
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning button form-control">Add To Cart</button>
                        </div>
                        @endauth
                        @guest
                            <div class="form-group">
                                <a href="{{route('login')}}" type="button" class="btn btn-warning form-control">Login to proceed</a>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


@endsection

@section('scripts')

<script>
    //set price
    var p = {{$product->price}}
    $('#price').val(p);

function calculatePrice(){
    var x = document.getElementById("mySelect").value;
      document.getElementById("subtotal").innerHTML = x;
      const quantity = document.getElementsByClassName("subtotal");
      quantity[0].innerHTML = x;
      const totalQuantity = document.getElementsByClassName("quantity");
      totalQuantity[0].innerHTML ="Total Quantity : " + x;

    var prices = $('[data-price]').map(function () {
    return parseInt($(this).text()) * parseInt($(this).closest('.row').find('.qty').val());
 }).get();

 const total = prices.reduce((a, b) => a + b);
 $('.total').text(total);
 $('#st').val(total);
 return total;
}
calculatePrice();
$(document).on('change', '.qty',function () {
    calculatePrice()
});
</script>

@endsection
</x-user-layout>
