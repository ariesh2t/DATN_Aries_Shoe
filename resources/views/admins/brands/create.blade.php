@extends('layouts.layoutAdmin')

@section('title')
    {{ __('create new') }}
@endsection

@section('content')
    <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 form-group form-upload">
            <label class="form-label">{{ __('image') }}</label>
            <div class="form-upload__preview"></div>
            <div class="d-flex mt-3">
                <label class="form-upload__title btn btn-outline-success mb-0" for="upload"> {{ __('upload') }}
                    <input class="form-upload__control js-form-upload-control" id="upload" type="file" name="image"/>
                </label>
                <div class="btn btn-secondary btn-clear d-none ml-3">{{ __('clear') }}</div>
            </div>
            @error('image')
                <small class="text-danger fst-italic">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3 form-group">
            <label for="name" class="form-label">{{ __('brand name') }}</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')
                <small class="text-danger fst-italic">{{ $message }}</small>
            @enderror
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
                    <a class="btn btn-danger" href="{{ route('brands.index') }}">
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
        } );
        </script>
        @include('ckfinder::setup')
@endsection
