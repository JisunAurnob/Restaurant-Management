@extends('layouts.app')
@push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('something.css') }}"> --}}
@endpush
@section('title', 'Add Restaurant')
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
                            <li class="breadcrumb-item active">Add Restaurant</li>
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
                        <div class="card-header">{{ __('Add Restaurant') }}</div>
        
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data" action="{{ route('add_restaurant_post') }}">
                                @csrf
                                <input type="hidden" name="client_id" value="{{Auth::user()->id}}">
                                <div class="row mb-3">
                                    <label for="restaurant_name" class="col-md-4 col-form-label text-md-end">Restaurant Name<span class="text-danger">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="restaurant_name" type="text" class="form-control @error('restaurant_name') is-invalid @enderror" name="restaurant_name" value="{{ old('restaurant_name') }}" required autocomplete="restaurant_name" autofocus>
        
                                        @error('restaurant_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}<span class="text-danger">*</span></label>
        
                                    <div class="col-md-6">
                                        <textarea id="address" class="form-control @error('address') is-invalid @enderror" rows="3" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus></textarea>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="restaurant_type" class="col-md-4 col-form-label text-md-end">Restaurant Type<span class="text-danger">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="restaurant_type" type="text" class="form-control @error('restaurant_type') is-invalid @enderror" name="restaurant_type" value="{{ old('restaurant_type') }}" required autocomplete="restaurant_type" autofocus>
        
                                        @error('restaurant_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="row mb-3">
                                    <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}<span class="text-danger">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>
        
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
        
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="slogan" class="col-md-4 col-form-label text-md-end">Slogan<span class="text-danger">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="slogan" type="text" class="form-control @error('slogan') is-invalid @enderror" name="slogan" value="{{ old('slogan') }}" required autocomplete="slogan" autofocus>
        
                                        @error('slogan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-md-4 col-form-label text-md-end" for="restaurant_photo">Restaurant Image<span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <img id="preview-image" src=""
                                        alt="Restaurant Picture" onerror="this.style.display='none'" style="max-height: 250px; max-width: 250px;">
                                        <input id="input_photo" type="file" class="form-control-file @error('restaurant_photo') is-invalid @enderror" name="restaurant_photo" value="">
                                        
                                        @error('restaurant_photo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="opening_time" class="col-md-4 col-form-label text-md-end">Opening Time<span class="text-danger">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="opening_time" type="time" class="form-control @error('opening_time') is-invalid @enderror" name="opening_time" value="{{ old('opening_time') }}" required autocomplete="opening_time" autofocus>
        
                                        @error('opening_time')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="closing_time" class="col-md-4 col-form-label text-md-end">Closing Time<span class="text-danger">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="closing_time" type="time" class="form-control @error('closing_time') is-invalid @enderror" name="closing_time" value="{{ old('closing_time') }}" required autocomplete="closing_time" autofocus>
        
                                        @error('closing_time')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="business_days" class="col-md-4 col-form-label text-md-end">Business Days<span class="text-danger">*</span></label>
        
                                    <div class="col-md-6">
                                        <input id="business_days" type="text" class="form-control @error('business_days') is-invalid @enderror" name="business_days" value="{{ old('business_days') }}" required autocomplete="business_days" autofocus placeholder="Ex: Open 7 Days A Week">
        
                                        @error('business_days')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-info">
                                            {{ __('Add Restaurant') }}
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
