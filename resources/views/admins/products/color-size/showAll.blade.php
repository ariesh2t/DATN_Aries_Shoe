@extends('layouts.layoutAdmin')

@section('title')
    {{ __('colors') . '/' . __('sizes') }}
@endsection

@section('breadcrumb')
    <div class="col-6">
        <h1 class="m-0">{{ __('colors') . "/" . __('sizes') }}</h1>
    </div>
    <nav aria-label="breadcrumb" class="col-6">
        <ol class="breadcrumb justify-content-end">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('products') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('colors') . "-" . __('sizes') }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="ajax-message btn btn-success">
    </div>
    <div class="d-flex">
        <div class="col-6">
            <div class="card border-primary mb-3">
                <div class="card-header">{{ __('colors') }}</div>
                <div class="card-body h-50-scroll text-primary">
                    <div class="d-flex flex-wrap align-items-center" id="list-color">
                        @foreach ($colors as $color)
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 px-2 mb-3">
                                <div style="width: 50px; height: 20px; background: {{ $color->color }}"></div>
                                <small class="small ml-1">{{ $color->color }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer text-right">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalColor">
                        {{ __('add color') }}
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="modalColor" tabindex="-1" aria-labelledby="modalColorLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content pb-3">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalColorLabel">{{ __('add color') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-left">
                                    <form action="{{ route('add-color') }}" method="POST" id="js-form-color">
                                        @csrf
                                        <div class="input-group">
                                            <input type="color" class="form-control" name="color" required>
                                            <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit">{{ __('save') }}</button>
                                            </div>
                                        </div>
                                        <small id="color_error" class="text-danger"></small>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-primary mb-3">
                <div class="card-header">{{ __('sizes') }}</div>
                <div class="card-body text-primary">
                    <div class="d-flex flex-wrap text-center" id="list-size">
                        @foreach ($sizes as $size)
                            <div class="col-lg-2 col-md-3 col-6">
                                {{ $size->size }}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer text-right">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSize">
                        {{ __('add size') }}
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="modalSize" tabindex="-1" aria-labelledby="modalSizeLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content pb-3">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalSizeLabel">{{ __('add size') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-left">
                                    <form action="{{ route('add-size') }}" method="POST" id="js-form-size">
                                        @csrf
                                        <div class="input-group">
                                            <input id="size" type="number" class="form-control" name="size" required>
                                            <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit">{{ __('save') }}</button>
                                            </div>
                                        </div>
                                        <small id="size_error" class="text-danger"></small>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //form add color submit
        $('#js-form-color').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: {
                    color: $("input[type='color']").val()
                },
                success: function(result){
                    if(result.errors) {
                        $('#color_error').html('');

                        $.each(result.errors, function(key, value){
                            $('#color_error').show();
                            $('#color_error').append(value);
                        });
                    }
                    else {
                        $('.close').click();
                        $('#list-color').append(
                            `<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 px-2 mb-3">
                                <div style="width: 50px; height: 20px; background: `+ result.color +`"></div>
                                <small class="small ml-1">`+ result.color +`</small>
                            </div>`
                        )
                        $('#color_error').html('')
                        $('.ajax-message').html('Thêm thành công')
                        $('.ajax-message').addClass('ajax-message-active');

                        //Set thời gian timeout để auto ẩn message trên sau 3 giây
                        setTimeout(function() {
                            $('.ajax-message').removeClass('ajax-message-active');
                        }, 6000);
                    }
                }
            });
        });

        //form add color submit
        $('#js-form-size').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: {
                    size: $("#size").val()
                },
                success: function(result){
                    if(result.errors) {
                        $('#size_error').html('');

                        $.each(result.errors, function(key, value){
                            $('#size_error').show();
                            $('#size_error').append(value);
                        });
                    }
                    else {
                        $('.close').click();
                        $('#list-size').append(
                            `<div class="col-lg-2 col-md-3 col-6">
                                `+ result.size +`
                            </div>`
                        )
                        $('#size_error').html('')
                        $('.ajax-message').html('Thêm thành công')
                        $('.ajax-message').addClass('ajax-message-active');

                        //Set thời gian timeout để auto ẩn message trên sau 3 giây
                        setTimeout(function() {
                            $('.ajax-message').removeClass('ajax-message-active');
                        }, 6000);
                    }
                }
            });
        });
    </script>
@endsection
