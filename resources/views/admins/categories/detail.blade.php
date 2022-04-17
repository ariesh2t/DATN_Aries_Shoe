@extends('layouts.layoutAdmin')

@section('title')
    {{ __('detail') }}
@endsection

@section('content')
    <h4 class="mb-3">{{ __('category detail', ['attr' => $category->id]) }}</h4>
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