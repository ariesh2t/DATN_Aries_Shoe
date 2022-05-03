@extends('layouts.layoutAdmin')

@section('title')
    {{ __('user detail') }}
@endsection

@section('breadcrumb')
<div class="col-6">
    <h1 class="m-0">{{ __('user detail') }}</h1>
</div>
<nav aria-label="breadcrumb" class="col-6">
    <ol class="breadcrumb justify-content-end">
      <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('home') }}</a></li>
      <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('users') }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ __('user detail') }}</li>
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
                <div class="card-header bg-danger text-white h5">{{ __('user detail') }}</div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="me-4">{{ __('fullname') }}:</strong>
                        {{ $user->fullname }}
                    </div>
                    <div class="mb-3">
                        <strong class="me-4">{{ __('email') }}:</strong>
                        {{ $user->email }}
                    </div>
                    <div class="mb-3"">
                        <strong class="me-4">{{ __('phone') }}:</strong>
                        {{ $user->phone }}
                    </div>
                    <div class="mb-3">
                        <strong class="me-4">{{ __('address') }}:</strong>
                        {{ $user->address ?? __('no info') }}
                    </div>
                    <div class="mb-3">
                        <strong class="me-4">{{ __('role') }}:</strong>
                        {{ ucfirst($user->role->role) }}
                    </div>
                    <div class="mb-3">
                        <strong class="me-4">{{ __('status') }}:</strong>
                        {{ $user->status == 0 ? __("block") : __('active') }}
                    </div>
                    <div class="mb-3">
                        <strong class="me-4">{{ __('created at') }}:</strong>
                        {{ $user->created_at }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
