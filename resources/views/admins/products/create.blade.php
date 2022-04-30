@extends('layouts.layoutAdmin')

@section('title')
    {{ __('create new') }}
@endsection

@section('content')
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 form-group form-upload">
            <label class="form-label">{{ __('image') }}</label>
            <div class="form-upload__preview flex-wrap"></div>
            <div class="d-flex mt-3 justify-content-center">
                <label class="form-upload__title btn btn-outline-success m-0" for="upload"> {{ __('upload') }}
                    <input class="form-upload__control js-form-upload-control" id="upload" type="file" name="images[]" multiple/>
                </label>
                <div class="btn btn-secondary btn-clear d-none ml-3">{{ __('clear') }}</div>
            </div>
            @error('images')
                <small class="text-danger fst-italic">{{ $message }}</small>
            @enderror
        </div>
        <div class="d-flex flex-wrap justify-content-md-between">
            <div class="col-md-5 col-sm-12 flex-fill p-0">
                <div class="form-group mb-3">
                    <label class="form-label">{{ __('brand') }}</label>
                    <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror" required>
                        <option selected disabled>{{ __('select') }}</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}"
                                @php
                                    echo $brand->id == old('brand_id') ? "selected" : ""
                                @endphp
                            >{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <small class="text-danger fst-italic">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="flex-fill"></div>
            <div class="col-md-5 col-sm-12 flex-fill p-0">
                <div class="form-group mb-3">
                    <label class="form-label">{{ __('category') }}</label>
                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                        <option selected disabled>{{ __('select') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @php
                                    echo $category->id == old('category_id') ? "selected" : ""
                                @endphp
                            >{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <small class="text-danger fst-italic">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class="mb-3 form-group">
            <label for="name" class="form-label">{{ __('product name') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')
                <small class="text-danger fst-italic">{{ $message }}</small>
            @enderror
        </div>
        <div class="d-flex flex-wrap">
            <div class="col-md-4 col-sm-12 pl-md-0 pr-md-3 p-0 mb-3">
                <label for="cost" class="form-label">{{ __('cost') }}</label>
                <div class="input-group">
                    <input type="number" id="cost" name="cost" value="{{ old('cost') }}" class="form-control @error('cost') is-invalid @enderror" required>
                    <div class="input-group-append">
                      <span class="input-group-text">VND</span>
                    </div>
                </div>
                @error('cost')
                    <small class="text-danger fst-italic">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-4 col-sm-12 px-md-2 p-0 mb-3">
                <label for="price" class="form-label">{{ __('price') }}</label>
                <div class="input-group">
                    <input type="number" id="price" name="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" required>
                    <div class="input-group-append">
                      <span class="input-group-text">VND</span>
                    </div>
                </div>
                @error('price')
                    <small class="text-danger fst-italic">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-4 col-sm-12 pr-md-0 pl-md-3 p-0 mb-3">
                <label for="promotion" class="form-label">{{ __('promotion') }}</label>
                <div class="input-group">
                    <input type="number" id="promotion" name="promotion" value="{{ old('promotion') }}" 
                        class="form-control @error('promotion') is-invalid @enderror" required>
                    <div class="input-group-append">
                      <span class="input-group-text">VND</span>
                    </div>
                </div>
                @error('promotion')
                    <small class="text-danger fst-italic">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="mb-3 form-group">
            <label for="desc" class="form-label">{{ __('desc') }}</label>
            <textarea name="desc" id="desc" cols="30" rows="10" class="form-control" required>{{ old('desc') }}</textarea>
        </div>
        <div class="tile-footer mb-3">
            <div class="row d-print-none mt-2">
                <div class="col-6">
                    <button class="btn btn-success" type="submit"><i class="fa-solid fa-circle-check"></i> {{ __('save') }}</button>
                </div>
                <div class="col-6 text-right">
                    <a class="btn btn-danger" href="{{ route('products.index') }}">
                        <i class="fa fa-fw fa-lg fa-arrow-left"></i> {{ __('back') }}
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'desc', {
            filebrowserBrowseUrl     : "{{ route('ckfinder_browser') }}",
            filebrowserImageBrowseUrl: "{{ route('ckfinder_browser') }}?type=Images&token=123",
            filebrowserFlashBrowseUrl: "{{ route('ckfinder_browser') }}?type=Flash&token=123", 
            filebrowserUploadUrl     : "{{ route('ckfinder_connector') }}?command=QuickUpload&type=Files", 
            filebrowserImageUploadUrl: "{{ route('ckfinder_connector') }}?command=QuickUpload&type=Images",
            filebrowserFlashUploadUrl: "{{ route('ckfinder_connector') }}?command=QuickUpload&type=Flash",
        });
    </script>
    @include('ckfinder::setup')
@endsection
