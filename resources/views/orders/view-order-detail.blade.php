@extends('components.user-layout')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Order Details</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p>Ordered on {{$show->created_at}} | Order {{$show->transaction_id}}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        @if ($show->status == 'pending')
                            <a class="btn btn-warning" style="cursor: none">Pending</a>
                        @elseif ($show->status == 'accepted')
                            <a class="btn btn-success">Accepted</a>
                        @elseif ($show->status == 'shipped')
                        <a class="btn btn-primary">Shipped</a>
                        @elseif ($show->status == 'delivered')
                        <a class="btn btn-info">Delivered</a>
                        @elseif ($show->status == 'cancelled')
                        <a class="btn btn-danger">Cancelled</a>
                        @endif

                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Shipping Address</h6>
                                <p>{{$show->details->fname .' '. $show->details->lname}}  <br>{{$show->details->address.', '.$show->details->city.', '.$show->details->state .' - '.$show->details->pincode}} </p>
                            </div>
                            <div class="col-md-4">
                                <h6>Payment Method</h6>
                                <p>Cash On Delivery</p>
                            </div>
                            <div class="col-md-4">
                                <h6>Order Summary</h6>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-5"><h6>Name : </h6></div>
                                        <div class="col-md-7 text-end">
                                            <p>{{$show->product->name}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-5"><h6>Quantity : </h6></div>
                                        <div class="col-md-7 text-end">
                                            <p>{{$show->quantity}} </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-5"><h6>Price : </h6></div>
                                        <div class="col-md-7 text-end">
                                            <p><i class="fa fa-indian-rupee-sign"></i> {{$show->price}} </p>
                                        </div>
                                    </div>
                                </div><hr>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-5"><h6>Grand Total : </h6></div>
                                        <div class="col-md-7 text-end">
                                            <p><i class="fa fa-indian-rupee-sign"></i> {{$show->total}} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
