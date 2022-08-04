@extends('layouts.app')
@section('title', 'Home')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in as ') }}
                        {{-- {{dd(Auth::user())}} --}}
                    {{Auth::user()->role}}

                    <div>
                       <img src="{{Auth::user()->avatar}}" alt="Avater">
                    </div>

                    <a class="btn btn-light btn-block" href="{{ route('change_pass') }}">Change Password</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
