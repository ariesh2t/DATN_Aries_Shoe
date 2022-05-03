@extends('layouts.layoutAdmin')

@section('title')
    {{ __('category detail', ['attr' => '']) }}
@endsection

@section('breadcrumb')
    <div class="col-6">
        <h1 class="m-0">{{ __('category detail', ['attr' => '#'. $category->id]) }}</h1>
    </div>
    <nav aria-label="breadcrumb" class="col-6">
        <ol class="breadcrumb justify-content-end">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">{{ __('categories') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('category detail', ['attr' => '']) }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="d-flex align-items-center mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('category name') }}</div>
        <div class="col-6">{{ $category->name }}</div>
    </div>
    <div class="d-flex align-items-center mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('image') }}</div>
        <div class="col-6"> 
            <img height="150" src="{{ asset('images/categories/' . $category->image->name) }}" alt="">
        </div>
    </div>
    <div class="d-flex mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('desc') }}</div>
        <div class="col-6">
            {!! $category->desc !!}
        </div>
    </div>
    <div class="d-flex mt-5">
        <div class="col-6 text-start">
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">
                <i class="fa-solid fa-pen-to-square"></i> {{ __('edit') }}
            </a>
        </div>
        <div class="col-6 text-right">
            <a href="{{ route('categories.index') }}" class="btn btn-danger">
                <i class="fa-solid fa-rotate-left"></i> {{ __('back') }}
            </a>
        </div>
    </div>
@endsection
