@extends('layouts.welcome')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Pending Product List</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#add-product"
                            aria-controls="offcanvasRight">Add Product</button>
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
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->description }}</td>
                                <td>
                                    @if ($product->status == 0)
                                        <span class="badge rounded-pill bg-danger">Pending</span>
                                    @else
                                        <span class="badge rounded-pill bg-success">Live</span>
                                    @endif
                                </td>
                                <td>
                                    <select name="status " id="{{ $product->id }}" class="form-select changeStatus">
                                        <option value="">Select</option>
                                        <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Unpublish
                                        </option>
                                        <option value="1">Publish</option>
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


    <div class="offcanvas offcanvas-end" tabindex="-1" id="add-product" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Add Product</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form enctype="multipart/form-data" action="{{ route('product.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Product Name">
                            @error('name')
                                <p class="">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Price</label>
                            <input type="number" class="form-control" name="price" placeholder="Enter Product price">
                            @error('price')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" class="form-control" name="image" />
                            @error('image')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea type="text" class="form-control" name="description" placeholder="Enter Product Description"></textarea>
                        </div>
                        @error('description')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--Edit product offcanvas-->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="editproduct" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Add Product</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form enctype="multipart/form-data" action="{{ route('product.update') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Product Name">
                            <input type="hidden" id="id" name="id">
                            @error('name')
                                <p class="">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Price</label>
                            <input type="number" class="form-control" id="price" name="price"
                                placeholder="Enter Product price">
                            @error('price')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" class="form-control" name="image" id="image" />
                            @error('image')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mt-1">
                        <img src="" height="100" width="100" alt="..." id="preview">
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea type="text" class="form-control" name="description" id="description"
                                placeholder="Enter Product Description"></textarea>
                        </div>
                        @error('description')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).on("click", ".btn-edit", function() {
            const id = $(this).attr('id');
            $.ajax({
                type: "get",
                url: "{{ route('product.edit') }}",
                data: {
                    id: id
                },
                success: function(response) {
                    const d = response;
                    console.log(d.id);
                    $('#id').val(d.id);
                    $('#name').val(d.name);
                    $('#price').val(d.price);
                    $('#preview').attr('src', d.image);
                    $('#description').val(d.description);
                    $("#editproduct").offcanvas('show');
                },
                error: function(response) {
                    console.error(response);
                }
            });
        });
        const imgInp = document.querySelector('#image');

        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                const prv = document.querySelector("#preview");
                prv.src = URL.createObjectURL(file)
            }
        }

        $(".btn-delete").click(function(e) {
            const id = $(this).attr('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "get",
                        url: "{{ route('product.delete') }}",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            // toastr.success('Record deleted successfully...');
                            Swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            )
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        },
                        error: function() {
                            Swal.fire(
                                "Opps!",
                                "something went wrong.",
                                "error"
                            )
                        }
                    });
                } else if (result.dismiss === "cancel") {
                    Swal.fire(
                        "Cancelled",
                        "Your file is safe :)",
                        "error"
                    )
                }
            });
        });
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
