@extends('layouts.layoutStaff')

@section('title')
    {{ __('profile') }}
@endsection

@section('breadcrumb')
    <div class="col-6">
        <h1 class="m-0">{{ __('profile') }}</h1>
    </div>
    <nav aria-label="breadcrumb" class="col-6">
        <ol class="breadcrumb justify-content-end">
            <li class="breadcrumb-item"><a href="{{ route('staff') }}">{{ __('home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('profile') }}</li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="container-xl px-4 mt-4">
    <div class="row">
        <div class="col-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header bg-danger text-white h5">{{ __('avatar') }}</div>
                <div class="card-body text-center">
                    <div class="d-flex flex-column align-items-center text-center py-2">
                        <img class="img-show w-100" src="{{ asset('images/users/' . $user->image->name) }}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card mb-4">
                <div class="card-header bg-danger text-white h5">{{ __('profile') }}</div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="me-4">{{ __('fullname') }}:</strong>
                        {{ $user->fullname }}
                    </div>
                    <div class="row gx-3 mb-3">
                        <div class="col-md-8">
                            <strong class="me-4">{{ __('email') }}:</strong>
                            {{ $user->email }}
                        </div>
                        <div class="col-md-4">
                            <strong class="me-4">{{ __('phone') }}:</strong>
                            {{ $user->phone }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong class="me-4">{{ __('address') }}:</strong>
                        {{ $user->address ?? __('no info') }}
                    </div>

                    <a href="{{ route('staff.profile.edit') }}" class="btn btn-outline-primary mt-2">{{ __('edit profile') }}</a>
                </div>
            </div>
            <div class="card mb-4" id="card-form-change-pass">
                <div class="card-header bg-warning text-white h5">{{ __('change pass') }}</div>
                <div class="card-body">
                    <form id="form-change-pass" action="{{ route('staff.profile.change-pass') }}" method="post">
                        @csrf
                        <div class="d-flex mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('password') }} <sup class="text-danger">*</sup></label>

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
                            <label for="new_password" class="col-md-4 col-form-label text-md-end">{{ __('new password') }} <sup class="text-danger">*</sup></label>

                            <div class="col-md-6 ms-3">
                                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required autocomplete="new_password">

                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                            <div id="eye-pass-new" class="col-md-1 ps-2 mt-2">
                                <i class="fa-regular fa-eye-slash d-none"></i>
                                <i class="fa-regular fa-eye"></i>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('confirm password') }} <sup class="text-danger">*</sup></label>

                            <div class="col-md-6 ms-3">
                                <input id="password-confirm" type="password" class="form-control" name="new_password_confirmation" required autocomplete="password-confirm">
                            </div>
                            <div id="eye-pass-cf" class="col-md-1 ps-2 mt-2">
                                <i class="fa-regular fa-eye-slash d-none"></i>
                                <i class="fa-regular fa-eye"></i>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-success">{{ __('save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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

        $('#eye-pass-new').click(function() {
            $('#eye-pass-new .fa-regular').toggleClass('d-none')
            if ($('#eye-pass-new .fa-eye').hasClass('d-none')) {
                $('#new_password').attr('type', 'text')
            } else {
                $('#new_password').attr('type', 'password')
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
