@extends('layouts.welcome')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title"> Coupon list </h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="#" class="btn btn-info" data-bs-toggle="offcanvas" data-bs-target="#addCoupon" aria-controls="offcanvasRight"><i class="fa fa-plus"></i> New Coupon</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Cart Value</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{$coupon->id}}</td>
                                    <td>{{$coupon->code}}</td>
                                    <td>{{$coupon->type}}</td>
                                    @if ($coupon->type == 'flat')
                                        <td>{{$coupon->value}}</td>
                                    @else
                                        <td>{{$coupon->value}}%</td>
                                    @endif
                                    <td>{{$coupon->cart_value}}</td>
                                    <td>
                                        <a title="Edit" href="#" id="{{$coupon->id}}" data-bs-target="#editCoupon" data-bs-toggle="offcanvas" class="btnedit btn btn-primary"><i class="fa fa-pencil"></i></a>
                                        <a href="{{route('coupon.delete',$coupon->id)}}" title="Delete" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{--add coupon offcanvas--}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="addCoupon" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasRightLabel">Add New Coupon</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form action="{{route('coupon.addCoupon')}}" method="post">
                    @csrf
                    <div class="form-group">
                            <label for="">Coupon Code</label>
                            <input type="text" name="code" placeholder="Coupon Code" class="form-control"/>
                            @error('name')<p class="text-danger">{{$message}}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label for="">Coupon Type</label>
                        <select name="coupontype" id="" class="form-select">
                            <option value="">Select</option>
                            <option value="flat">Flat</option>
                            <option value="percent">Percent</option>
                        </select>
                        @error('coupontype')<p class="text-danger">{{$message}}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label for="">Coupon Value</label>
                        <input type="text" name="couponvalue" placeholder="Coupon Code" class="form-control"/>
                        @error('couponvalue')<p class="text-danger">{{$message}}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label for="">Cart Value</label>
                        <input type="text" name="cartvalue" placeholder="Cart Value" class="form-control"/>
                        @error('cartvalue')<p class="text-danger">{{$message}}</p>@enderror
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        {{--edit coupon offcanvas--}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="editCoupon" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasRightLabel">Edit New Coupon</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form action="{{route('coupon.update')}}" method="post">
                    @csrf
                    <div class="form-group">
                            <label for="">Coupon Code</label>
                            <input type="text" name="code" id="code" placeholder="Coupon Code" class="form-control"/>
                            <input type="hidden" name="id" id="id">
                            @error('name')<p class="text-danger">{{$message}}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label for="">Coupon Type</label>
                        <select name="coupontype" id="type" class="form-select">
                            <option value="">Select</option>
                            <option value="flat">Flat</option>
                            <option value="percent">Percent</option>
                        </select>
                        @error('coupontype')<p class="text-danger">{{$message}}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label for="">Coupon Value</label>
                        <input type="text" name="couponvalue" id="value" placeholder="Coupon Code" class="form-control"/>
                        @error('couponvalue')<p class="text-danger">{{$message}}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label for="">Cart Value</label>
                        <input type="text" name="cartvalue" id="cartval" placeholder="Cart Value" class="form-control"/>
                        @error('cartvalue')<p class="text-danger">{{$message}}</p>@enderror
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
    $(document).on("click",".btnedit", function () {
        const id = $(this).attr('id');
        // alert(id);
        $.ajax({
            type: "get",
            url: "{{route('coupon.edit')}}",
            data: {
                id:id
            },
            success: function (response) {
                const d = response;
                console.log(response);
                $('#id').val(d.id);
                $('#code').val(d.code);
                $('#type').val(d.type);
                $('#value').val(d.value);
                $('#cartval').val(d.cart_value);
                $('#editCoupon').offcanvas('show');
            }

        });
    });
</script>
@endsection
