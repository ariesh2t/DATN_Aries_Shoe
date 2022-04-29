@extends('layouts.layoutAdmin')

@section('title')
    {{ __('edit profile') }}
@endsection

@section('content')
<div class="container-xl px-4 mt-4">
    <hr class="mt-0 mb-4">
    <form action="{{ route('admin.profile.update', $user->id) }}" method="POST" id="form-profile" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{ $user->id }}">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header bg-danger text-white h5">{{ __('avatar')}}</div>
                <div class="card-body text-center">
                    <div class="mb-3 form-group aform-upload">
                        <div class="aform-upload__preview justify-content-center">
                            <div class="aform-upload__item">
                                <div class="aform-upload__item-thumbnail" style="background-image: url('{{ asset('images/users/' . $user->image->name) }}')"></div>
                            </div>
                        </div>
                        <div class="d-flex mt-3 justify-content-center">
                            <label class="aform-upload__title btn btn-outline-success" for="upload"> {{ __('upload') }}
                                <input class="aform-upload__control js-aform-upload-control" id="upload" type="file" name="image"/>
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
                                <input class="form-control" id="address" name="fname" type="text" value="{{ old('fname') ?? $user->first_name }}">
                                @error('fname') 
                                    <span class="small text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Form Group (Phone)-->
                            <div class="col-md-6">
                                <label class="form-label mb-1" for="lname">{{ __('lname') }}</label>
                                <input class="form-control" id="lname" name="lname" type="text" value="{{ old('lname') ?? $user->last_name }}">
                                @error('lname') 
                                    <span class="small text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-2">
                            <!-- Form Group (Address)-->
                            <div class="col-md-6">
                                <label class="form-label mb-1" for="email">{{ __('email') }}</label>
                                <input class="form-control" id="email" name="email" type="email" value="{{ old('email') ?? $user->email }}">
                                @error('email') 
                                    <span class="small text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Form Group (Phone)-->
                            <div class="col-md-6">
                                <label class="form-label mb-1" for="phone">{{ __('phone') }}</label>
                                <input class="form-control" id="phone" name="phone" type="text" value="{{ old('phone') ?? $user->phone }}">
                                @error('phone') 
                                    <span class="small text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-2">
                            <label class="form-label mb-1" for="address">{{ __('address') }}</label>
                            <input class="form-control" id="address" name="address" type="text" value="{{ old('address') ?? $user->address }}">
                            @error('address') 
                                <span class="small text-danger"> {{ $message }}</span>
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

@section('script')
    <script>
        (function( $ ) {
            $.fn.attachmentUploader = function() {
                const uploadControl = $(this).find('.js-aform-upload-control');
                const btnClear = $(this).find('.btn-clear');
                $(uploadControl).on('change', function(e) {
                    const preview = $(this).closest('.aform-upload').children('.aform-upload__preview');
                    const files   = e.target.files;
        
                    function previewUpload(file) {
                        if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
                            var reader = new FileReader();
                            reader.addEventListener('load', function () {
                                const html =
                                    '<div class=\"aform-upload__item\">' +
                                        '<div class="aform-upload__item-thumbnail" style="background-image: url(' + this.result + ')"></div>' +
                                    '</div>';
                                preview.html( html );
                            }, false);
                            reader.readAsDataURL(file);
                        } else {
                            alert('Please upload image only');
                            uploadControl.val('');
                        }
                    }
        
                [].forEach.call(files, previewUpload);
            })
            }
        })( jQuery )
        
        $('.aform-upload').attachmentUploader();
    </script>
@endsection
