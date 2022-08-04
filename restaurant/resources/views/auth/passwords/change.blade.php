@extends('layouts.app')
@section('title', 'Change Password')
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
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Change Password') }}</div>
                        {{-- <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span> --}}
                        <div class="card-body">
                            <form method="POST" action="{{ route('change_pass_post') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                <div class="row mb-3">
                                    <label for="currentpass"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Current Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="currentpass" type="password"
                                            class="form-control @error('currentpass') is-invalid @enderror @if (!empty($currentpass)) is-invalid @endif"
                                            name="currentpass" required autocomplete="current-password">

                                        @if (!empty($currentpass))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>
                                                    {{ $currentpass }}

                                                </strong>
                                            </span>
                                        @endif
                                        @error('currentpass')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-end">{{ __('New Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Confirm New Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-info">
                                            {{ __('Change') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
