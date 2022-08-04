@extends('components.user-layout')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Your Orders</h2>
                @foreach ($order_list as $list)
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <p>Order Placed <br><span>{{$list->created_at}}</span></p>
                            </div>
                            <div class="col-md-1">
                                <p>Total <br><span><i class="fa fa-indian-rupee-sign"></i> {{$list->total}}</span></p>
                            </div>
                            <div class="col-md-3">
                                <p>SHIP TO <br>{{$list->details->fname.' '. $list->details->lname}}</p>
                            </div>
                            <div class="col-md-2">
                                @if ($list->payment_status == 'unpaid')
                                    <p>Payment Status <br>
                                        @if ($list->payment_type == 'cod')
                                            <div class="badge bg-success">COD</div>
                                        @elseif ($list->payment_type == 'online')
                                            <form action="{{ route('razorpay.payment.store') }}" method="POST" >
                                                @csrf
                                                <script src="https://checkout.razorpay.com/v1/checkout.js"
                                                        data-key="{{ env('RAZORPAY_KEY') }}"
                                                        data-amount={{($list->quantity* $list->price) * 100}}
                                                        data-buttontext="Pay"
                                                        data-name="appdidinfotechLLP.com"
                                                        data-description="Razorpay"
                                                        data-image="{{asset($list->product->image)}}"
                                                        data-prefill.name="name"
                                                        data-prefill.email={{Auth::user()->email}}
                                                        data-theme.color="#0085ad">
                                                </script>
                                                    <input type="hidden" name="order_id[]" id="" value="{{$list->id}}">
                                                {{-- <input type="hidden" name="quantity" id="" value="{{$item->prod_qty}}"> --}}
                                            </form>
                                        @endif</p>
                                @elseif ($list->payment_status == 'paid')
                                <p>Payment Status <br><div class="badge bg-success">Paid</div></p>
                                @endif
                                {{-- <p>SHIP TO <br>{{$list->details->fname.' '. $list->details->lname}}</p> --}}
                            </div>
                            <div class="col-md-3 text-end">
                                <p>Transaction ID # {{$list->transaction_id}} <br>
                                    <a href="{{route('user-ordershow',$list->id)}}">View order details</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="carad-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <img src="{{asset($list->product->image)}}" alt="..." width="100">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5><a href="{{route('order-detail',$list->product->id)}}">{{$list->product->name}}</a></h5>
                                <p><i class="fa fa-indian-rupee-sign"></i> {{$list->price}}</p>
                                <a href="{{route('order-detail',$list->product->id)}}" class="btn btn-warning mb-4">Buy it again</a>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                @endforeach
            </div>
        </div>
    </div>
@endsection

