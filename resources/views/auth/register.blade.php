@extends('layouts.layoutCustomer')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white fs-5">{{ __('register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="d-flex mb-3">
                            <label for="fname" class="col-md-4 col-form-label text-md-end">{{ __('fname') }} <sup class="text-danger">*</sup></label>

                            <div class="col-md-6 ms-3">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" required autocomplete="fname" autofocus>

                                @error('fname')
                                    <span class="invalid-feedback" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <label for="lname" class="col-md-4 col-form-label text-md-end">{{ __('lname') }} <sup class="text-danger">*</sup></label>

                            <div class="col-md-6 ms-3">
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" required autocomplete="lname" autofocus>

                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('email') }} <sup class="text-danger">*</sup></label>

                            <div class="col-md-6 ms-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('password') }} <sup class="text-danger">*</sup></label>

                            <div class="col-md-6 ms-3">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

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
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('confirm password') }} <sup class="text-danger">*</sup></label>

                            <div class="col-md-6 ms-3">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div id="eye-pass-cf" class="col-md-1 ps-2 mt-2">
                                <i class="fa-regular fa-eye-slash d-none"></i>
                                <i class="fa-regular fa-eye"></i>
                            </div>
                        </div>

                        <div class="d-flex mb-3 justify-content-center align-content-center">
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('register') }}
                                </button>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="col">
                                <a href="{{ route('login') }}">{{ __('have account') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
