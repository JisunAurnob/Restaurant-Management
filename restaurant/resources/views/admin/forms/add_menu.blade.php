@extends('layouts.app')
@push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('something.css') }}"> --}}
@endpush
@section('title', 'Add Menu')
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
                            <li class="breadcrumb-item active">Add Menu</li>
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
                        <div class="card-header">{{ __('Add Menu') }}</div>
        
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data" action="{{ route('add_menu_post') }}">
                                @csrf
                                {{-- {{dd($restaurants)}} --}}
                                {{-- <input type="text" name="client_id" value="{{$restaurant[0]['id']}}"> --}}
                                <div class="row mb-3">
                                    <label for="menu_name" class="col-md-4 col-form-label text-md-end">Select Restaurant<span class="text-danger">*</span></label>
                                    
                                    <div class="col-md-6">
                                        <select name="restaurant_id" id="restaurant_id" class="form-control"  data-live-search="true" aria-label="Select Restaurant">
                                            @foreach ($restaurants as $restaurant)
                                            <option value="{{$restaurant->id}}">{{$restaurant->restaurant_name}}</option> 
                                            @endforeach                   
                                            </select> 
                                        @error('restaurant_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="menu_name" class="col-md-4 col-form-label text-md-end">Menu Name<span class="text-danger">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="menu_name" type="text" class="form-control @error('menu_name') is-invalid @enderror" name="menu_name" value="{{ old('menu_name') }}" required autocomplete="menu_name" autofocus>
        
                                        @error('menu_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="menu_description" class="col-md-4 col-form-label text-md-end">{{ __('Menu Description') }}<span class="text-danger">*</span></label>
        
                                    <div class="col-md-6">
                                        <textarea id="menu_description" class="form-control @error('menu_description') is-invalid @enderror" rows="3" name="menu_description" value="{{ old('menu_description') }}" required autocomplete="menu_description" autofocus></textarea>
                                        @error('menu_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-md-4 col-form-label text-md-end" for="input_photo">Menu Image<span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <img id="preview-image" src=""
                                        alt="Restaurant Picture" onerror="this.style.display='none'" style="max-height: 250px; max-width: 250px;">
                                        <input id="input_photo" type="file" class="form-control-file @error('menu_picture') is-invalid @enderror" name="menu_picture" value="">
                                        
                                        @error('menu_picture')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-info">
                                            {{ __('Add Menu') }}
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

            });
        </script>

        <script src="{{ asset('js/admin/imagepreview.js') }}"></script>
    @endpush
@endsection
