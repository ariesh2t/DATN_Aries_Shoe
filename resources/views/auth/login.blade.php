@extends('layouts.layoutCustomer')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white fs-5">{{ __('login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="d-flex mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('email') }}</label>

                            <div class="col-md-6 ms-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('password') }}</label>

                            <div class="col-md-6 ms-3">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                            <div id="eye-pass" class="col-md-1 ps-2 mt-2">
                                <i class="fa-regular fa-eye-slash d-none"></i>
                                <i class="fa-regular fa-eye"></i>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="col-md-4"></div>
                            <div class="col-md-6 ms-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('remember me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('login') }}
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('forgot pass') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="col">
                                <a href="{{ route('register') }}">{{ __("haven't account") }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
