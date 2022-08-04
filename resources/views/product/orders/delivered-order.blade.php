@extends('layouts.welcome')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="card-title">Delivered Order List</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>User Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Pincode</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Payment Type</th>
                                        <th>Payment Status</th>
                                        <th>Transaction Id</th>
                                        <th>Status</th>
                                        <th>Manage Status</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($order as $orders)
                                    <tr>
                                        <td>{{$orders->product->name}}</td>
                                        <td>{{$orders->product->price}}</td>
                                        <td>{{$orders->quantity}}</td>
                                        <td>{{$orders->total}}</td>
                                        <td>{{$orders->details->fname .' ' . $orders->details->lname}}</td>
                                        <td>{{$orders->details->phone}}</td>
                                        <td>{{$orders->details->email}}</td>
                                        <td>{{$orders->details->address}}</td>
                                        <td>{{$orders->details->pincode}}</td>
                                        <td>{{$orders->details->city}}</td>
                                        <td>{{$orders->details->state}}</td>
                                        <td>{{$orders->payment_type}}</td>
                                        <td>{{$orders->payment_status}}</td>
                                        <td>{{$orders->transaction_id}}</td>
                                        <td>
                                            @if ($orders->status == 'delivered')
                                                <div class="badge rounded-pill bg-info">Delivered</div>
                                            @else
                                                <div class="badge rounded-pill bg-danger">Pending</div>
                                            @endif

                                        </td>
                                        <td>
                                            <select name="status" id="{{$orders->id}}" class="form-select orderstatus">
                                                <option value="">Select</option>
                                                <option value="pending" {{($orders->status == 'pending')?'selected':'Select'}}>Pending</option>
                                                <option value="accepted" {{($orders->status == 'accepted')?'selected':'Select'}}>Accepted</option>
                                                <option value="shipped" {{($orders->status == 'shipped')?'selected':'Select'}}>Shipped</option>
                                                <option value="delivered" {{($orders->status == 'delivered')?'selected':'Select'}}>Delivered</option>
                                                <option value="cancelled" {{($orders->status == 'cancelled')?'selected':'Select'}}>Cancelled</option>

                                            </select>
                                        </td>
                                        <td>{{$orders->created_at}}</td>
                                        <td>{{$orders->updated_at}}</td>
                                    </tr>
                                    @empty
                                        <div class="alert alert-warning">
                                            No data available
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on("change",".orderstatus", function(e) {
            const status = $(this).val();
            const id = $(this).attr('id');
            $.ajax({
                type: "get",
                url: '{{ route('order.orderstatus') }}',
                data: {
                    'id': id,
                    'status': status
                },
                success: function (data) {
                  alert(data);
                    location.reload();
                }
            });
        });
    </script>
@endsection
