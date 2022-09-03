@extends('template.main')

@section('content')
    <div class="container mt-5">
        <div class="card login-card">
            <div class="row no-gutters">
                <div class="col-md-5">
                    <img src="{{ asset('images/login.jpg') }}" alt="login" class="login-card-img">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <div class="brand-wrapper">
                            <img src="{{ asset('images/logo.svg') }}" alt="logo" class="logo">
                        </div>
                        <p class="login-card-description">Please enter authentication code</p>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ url('/two-factor-challenge') }}">
                            @csrf
                            <div class="form-group">
                                <label for="code" class="sr-only">Code</label>
                                <input type="code" name="code" id="code" class="form-control @error('code') is-invalid @enderror" placeholder="Code">
                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                            <input name="submit" id="submit" class="btn btn-block login-btn mb-4" type="submit" value="Submit">
                        </form>
                        <p class="login-card-footer-text">Alredy have an account? <a href="{{ route('login') }}" class="text-reset">Login here</a></p>
                        <nav class="login-card-footer-nav">
                            <a href="#!">Terms of use.</a>
                            <a href="#!">Privacy policy</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
