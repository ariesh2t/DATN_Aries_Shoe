@extends('layouts.layoutCustomer')

@section('title')
    {{ __('edit profile') }}
@endsection

@section('content')
<div class="container-xl px-4 mt-4">
    <hr class="mt-0 mb-4">
    <form action="{{ route('profile.update', $user->id) }}" method="POST" id="form-profile" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{ $user->id }}">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header bg-danger text-white h5">{{ __('avatar')}}</div>
                <div class="card-body text-center">
                    <div class="mb-3 form-group form-upload">
                        <div class="form-upload__preview">
                            <div class="form-upload__item">
                                <div class="form-upload__item-thumbnail" style="background-image: url('{{ asset('images/users/' . $user->image->name) }}')"></div>
                            </div>
                        </div>
                        <div class="d-flex mt-3">
                            <label class="form-upload__title btn btn-outline-success" for="upload"> {{ __('upload') }}
                                <input class="form-upload__control js-form-upload-control" id="upload" type="file" name="image"/>
                            </label>
                        </div>
                        @error('image')
                            <small class="text-danger fst-italic">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header bg-danger text-white h5">{{ __('profile') }}</div>
                    <div class="card-body">
                        <!-- Form Group (username)-->
                        <div class="row gx-3 mb-2">
                            <!-- Form Group (Address)-->
                            <div class="col-md-6">
                                <label class="form-label mb-1" for="fname">{{ __('fname') }}</label>
                                <input class="form-control" id="address" name="fname" type="text" value="{{ $user->first_name }}">
                                @error('fname') 
                                    <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Form Group (Phone)-->
                            <div class="col-md-6">
                                <label class="form-label mb-1" for="lname">{{ __('lname') }}</label>
                                <input class="form-control" id="lname" name="lname" type="text" value="{{ $user->last_name }}">
                                @error('lname') 
                                    <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-2">
                            <!-- Form Group (Address)-->
                            <div class="col-md-6">
                                <label class="form-label mb-1" for="email">{{ __('email') }}</label>
                                <input class="form-control" id="email" name="email" type="email" value="{{ $user->email }}">
                                @error('email') 
                                    <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Form Group (Phone)-->
                            <div class="col-md-6">
                                <label class="form-label mb-1" for="phone">{{ __('phone') }}</label>
                                <input class="form-control" id="phone" name="phone" type="text" value="{{ $user->phone ?? '' }}">
                                @error('phone') 
                                    <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-2">
                            <label class="form-label mb-1" for="address">{{ __('address') }}</label>
                            <input class="form-control" id="address" name="address" type="text" value="{{ $user->address ?? '' }}">
                            @error('address') 
                                <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary mt-4 mb-1" type="submit">{{ __('save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
