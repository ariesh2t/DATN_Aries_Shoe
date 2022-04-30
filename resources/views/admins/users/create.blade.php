@extends('layouts.layoutAdmin')

@section('title')
    {{ __('create new') }}
@endsection

@section('content')
<form method="POST" action="{{ route('users.store') }}">
    @csrf

    <div class="d-flex mb-3">
        <div class="col-2"></div>
        <label for="fname" class="col-md-2 col-form-label text-md-end">{{ __('fname') }} <sup class="text-danger">*</sup></label>

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
        <div class="col-2"></div>
        <label for="lname" class="col-md-2 col-form-label text-md-end">{{ __('lname') }} <sup class="text-danger">*</sup></label>

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
        <div class="col-2"></div>
        <label for="lname" class="col-md-2 col-form-label text-md-end">{{ __('phone') }} <sup class="text-danger">*</sup></label>

        <div class="col-md-6 ms-3">
            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <small>{{ $message }}</small>
                </span>
            @enderror
        </div>
    </div>

    <div class="d-flex mb-3">
        <div class="col-2"></div>
        <label for="email" class="col-md-2 col-form-label text-md-end">{{ __('email') }} <sup class="text-danger">*</sup></label>

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
        <div class="col-2"></div>
        <label for="password" class="col-md-2 col-form-label text-md-end">{{ __('password') }} <sup class="text-danger">*</sup></label>

        <div class="col-md-6 ms-3">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password">

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
        <div class="col-2"></div>
        <label for="password-confirm" class="col-md-2 col-form-label text-md-end">{{ __('confirm password') }} <sup class="text-danger">*</sup></label>

        <div class="col-md-6 ms-3">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="password-confirm">
        </div>
        <div id="eye-pass-cf" class="col-md-1 ps-2 mt-2">
            <i class="fa-regular fa-eye-slash d-none"></i>
            <i class="fa-regular fa-eye"></i>
        </div>
    </div>

    <div class="tile-footer mb-3">
        <div class="row d-print-none mt-2">
            <div class="col-6">
                <button class="btn btn-success" type="submit"><i class="fa-solid fa-circle-check"></i> {{ __('save') }}</button>
            </div>
            <div class="col-6 text-right">
                <a class="btn btn-danger" href="{{ route('brands.index') }}">
                    <i class="fa fa-fw fa-lg fa-arrow-left"></i> {{ __('back') }}
                </a>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
    <script>
        $('#eye-pass').click(function() {
            $('#eye-pass .fa-regular').toggleClass('d-none')
            if ($('#eye-pass .fa-eye').hasClass('d-none')) {
                $('#password').attr('type', 'text')
            } else {
                $('#password').attr('type', 'password')
            }
        })

        $('#eye-pass-cf').click(function() {
            $('#eye-pass-cf .fa-regular').toggleClass('d-none')
            if ($('#eye-pass-cf .fa-eye').hasClass('d-none')) {
                $('#password-confirm').attr('type', 'text')
            } else {
                $('#password-confirm').attr('type', 'password')
            }
        })
    </script>
@endsection