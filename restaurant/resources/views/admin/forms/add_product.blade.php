@extends('layouts.app')
@push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('something.css') }}"> --}}
@endpush
@section('title', 'Add Product')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Admin</a></li>
                            <li class="breadcrumb-item active">Add Product</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        {{-- Main Content Start --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('Add Product') }}</div>

                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data" action="{{ route('add_product_post') }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="restaurant_id"
                                                class="col-md-4 col-form-label text-md-end">Restaurant<span
                                                    class="text-danger">*</span></label>
                                            <select name="restaurant_id" id="restaurant_id" class="form-control"
                                                data-live-search="true" aria-label="Select Restaurant">
                                                <option value="">Select Your Restaurant</option>
                                                @foreach ($restaurants as $restaurant)
                                                    <option value="{{ $restaurant->id }}">{{ $restaurant->restaurant_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('restaurant_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="menu_id" class="col-md-4 col-form-label text-md-end">Menu<span
                                                    class="text-danger">*</span></label>
                                            <select name="menu_id" id="menu_id" class="form-control @error('menu_id') is-invalid @enderror"
                                                data-live-search="true" aria-label="Select Menu">
                                                <option>Select Menu</option>
                                            </select>
                                            @error('menu_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="product_name" class="col-md-4 col-form-label text-md-end">Product
                                            Name<span class="text-danger">*</span></label>

                                        <div class="col-md-6">
                                            <input id="product_name" type="text"
                                                class="form-control @error('product_name') is-invalid @enderror"
                                                name="product_name" value="{{ old('product_name') }}" required
                                                autocomplete="product_name" autofocus>

                                            @error('product_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="product_description"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Description') }}<span
                                                class="text-danger">*</span></label>

                                        <div class="col-md-6">
                                            <textarea id="product_description" class="form-control @error('product_description') is-invalid @enderror"
                                                rows="3" name="product_description" value="{{ old('product_description') }}" required
                                                autocomplete="product_description" autofocus></textarea>
                                            @error('product_description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="product_type" class="col-md-4 col-form-label text-md-end">Product
                                            Type<span class="text-danger">*</span></label>

                                        <div class="col-md-6">
                                            <input id="product_type" type="text"
                                                class="form-control @error('product_type') is-invalid @enderror"
                                                name="product_type" value="{{ old('product_type') }}"
                                                placeholder="Ex. Hot/Cold" required autocomplete="product_type" autofocus>

                                            @error('product_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="product_price" class="col-md-4 col-form-label text-md-end">Product price (৳)<span class="text-danger">*</span></label>

                                        <div class="col-md-6">
                                            <input type="number" id="product_price" name="product_price" class="form-control @error('product_price') is-invalid @enderror" min="0"
                                            value="0" step="1">

                                            @error('product_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-4 col-form-label text-md-end" for="input_photo">Product
                                            Image<span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <img id="preview-image" src="" alt="Product Picture"
                                                onerror="this.style.display='none'"
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
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-info">
                                                {{ __('Add Product') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {

                $("#restaurant_id").change(function() {
                    var id = $(this).val();
                    $('#menu_id').empty();

                    $('#menu_id').append('<option value="">Select Menu</option>');
                    // var url = '{{ route('search_menu', ['id' => 'id']) }}'
                    var url = '{{ route('search_menu', ':id') }}';
                    url = url.replace(':id', id);
                    console.log(url);
                    // var firstDropVal = $('#').val();
                    $.ajax({
                        url: url,
                        method: 'GET',
                        data: {},
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            $.each(data, function(key, value) {
                                console.log(data);
                                // '<td>'+value.menu_name'</td>'+'<td>'+value.menu_description'</td>'+'<td>'+value.menu_description'</td>'

                                $('#menu_id').append('<option value="' + value.id + '">' +
                                    value.menu_name + '</option>')
                            });

                        }
                    })
                });

                // $("label").click(function() {
                //     alert('Label Clicked');
                    // $("#product_name").prop("readonly",true);
                    // $.ajax({
                    //     url: url,
                    //     method: 'POST',
                    //     data: {
                    //         product_name: "Donald Duck",
                    //         city: "Duckburg"
                    //     },
                    //     dataType: 'json',
                    //     success: success,
                    //     dataType: dataType
                    // });
                // });

            });
        </script>

        <script src="{{ asset('js/admin/imagepreview.js') }}"></script>
    @endpush
@endsection
