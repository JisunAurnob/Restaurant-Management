@extends('layouts.app')
@push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('something.css') }}"> --}}
@endpush
@section('title', 'Product')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product Edit</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Product Edit</li>
                        </ol>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        {{-- Main Content Start --}}
        <section class="content">
            {{-- {{ dd($product) }} --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">General</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data" action="{{ route('edit_product_post') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product[0]->id }}">
                                <div class="form-group">
                                    <label for="product_name">Product
                                        Name<span class="text-danger">*</span></label>
                                    <input id="product_name" type="text"
                                        class="form-control @error('product_name') is-invalid @enderror" name="product_name"
                                        value="{{ $product[0]->product_name }}" required autocomplete="product_name"
                                        autofocus>
                                    @error('product_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_description">Product Description<span class="text-danger">*</span></label>
                                    <textarea id="product_description" class="form-control @error('product_description') is-invalid @enderror"
                                        rows="4" name="product_description" required autocomplete="product_description" autofocus>{{ $product[0]->product_description }}</textarea>
                                    @error('product_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_type">Product Type<span class="text-danger">*</span></label>
                                    <input id="product_type" type="text"
                                        class="form-control @error('product_type') is-invalid @enderror" name="product_type"
                                        value="{{ $product[0]->product_type }}" placeholder="Ex. Hot/Cold" required
                                        autocomplete="product_type" autofocus>
                                    @error('product_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_price">Product price (৳)<span class="text-danger">*</span></label>
                                        <input type="number" id="product_price" name="product_price" class="form-control @error('product_price') is-invalid @enderror" min="0"
                                        value="{{ $product[0]->product_price }}" step="1">
                                        @error('product_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="input_photo">Product Image<span class="text-danger">*</span></label><br>
                                    <img id="preview-image" src="{{ asset($product[0]->product_picture) }}"
                                        alt="Product Picture" onerror="this.style.display='none'"
                                        style="max-height: 250px; max-width: 250px;">
                                    <input id="input_photo" type="file"
                                        class="form-control-file @error('product_picture') is-invalid @enderror"
                                        name="product_picture" value="">
                                    @error('product_picture')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="availability">Availability<span class="text-danger">*</span></label>
                                    <select id="availability" name="availability" class="form-control custom-select">
                                        <option>Select one</option>
                                        <option value="upcoming" @if ($product[0]->availability == 'upcoming') selected @endif>Upcoming
                                        </option>
                                        <option value="available" @if ($product[0]->availability == 'available') selected @endif>
                                            Available</option>
                                        <option value="outofstock" @if ($product[0]->availability == 'outofstock') selected @endif>Out Of
                                            Stock</option>
                                    </select>
                                    @error('availability')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="product_status"
                                        value="popular" id="product_status" @if ($product[0]->product_status == 'popular') checked @endif>
                                    <label class="form-check-label" for="product_status">Show the item in
                                        popular section</label>
                                </div>
                                <input type="submit" value="Save Changes" class="btn btn-success float-right">
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Add Attribute</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data" action="{{ route('edit_product_with_attributes_post') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product[0]->id }}">
                                <div class="form-group">
                                    <label for="product_size">Product size<span class="text-danger">*</span></label>
                                    <select id="product_size" name="product_size" class="form-control custom-select @error('product_size') is-invalid @enderror">
                                        <option value="">Select one</option>
                                        <option value="small">Small</option>
                                        <option value="medium">Medium</option>
                                        <option value="large">Large</option>
                                    </select>
                                    @error('product_size')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_price">Product price (৳)<span class="text-danger">*</span></label>
                                    <input type="number" id="product_price" name="product_price" class="form-control @error('product_price') is-invalid @enderror" min="0"
                                        value="0" step="1">
                                        @error('product_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_discount">Product discount %</label>
                                    <input type="number" id="product_discount" name="product_discount" class="form-control @error('product_discount') is-invalid @enderror"
                                        min="0" value="0" step="1">
                                        @error('product_discount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <input type="submit" value="Add Attribute" class="btn btn-info float-right">

                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Attributes</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product Size</th>
                                        <th>Product Price (৳)</th>
                                        <th>Product Discount</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product[0]->product_attributes as $product_attribute)
                                        <tr>
                                            <td>{{ $product_attribute->product_size }}</td>
                                            <td>{{ $product_attribute->product_price }} ৳</td>
                                            <td>{{ $product_attribute->product_discount }} %</td>
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{route('delete_product_attribute', ['slug' => Auth::user()->role, 'pid' => $product[0]->id, 'id' => $product_attribute->id])}}" class="btn btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this attribute?');"><i
                                                            class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

        </section>
    </div>

    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {

            });
        </script>

        <script src="{{ asset('js/admin/imagepreview.js') }}"></script>
    @endpush
@endsection
