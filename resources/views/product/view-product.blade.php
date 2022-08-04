@extends('layouts.welcome')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Live Product List</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Manage Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->description }}</td>
                                <td>
                                    {!! $product->status == 1
                                        ? '<span class="badge rounded-pill bg-success">Live</span>'
                                        : '<span class="badge rounded-pill bg-danger">Pending</span>' !!}
                                </td>
                                <td>
                                    <select name="status " id="{{ $product->id }}" class="form-select changeStatus">
                                        <option value="">Select</option>
                                        <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Unpublish
                                        </option>
                                        <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Publish
                                        </option>
                                        <option value="2">Delete</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="#" id=" {{ $product->id }}" class="btn btn-primary btn-edit"><i
                                            class="fa fa-pencil"></i></a>
                                    <a href="#" id=" {{ $product->id }}" class="btn btn-danger btn-delete"><i
                                            class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).on("change", ".changeStatus", function(e) {
            const status = $(this).val();
            const id = $(this).attr("id");
            $.ajax({
                type: "get",
                url: '{{ route('product.changestatus') }}',
                data: {
                    'id': id,
                    'status': status
                },
                success: function(data) {
                    alert(data);
                    location.reload();
                }
            });
        });
    </script>
@endsection
