@extends('layouts.layoutAdmin')

@section('title')
    {{ __('detail') }}
@endsection

@section('breadcrumb')
<div class="col-6">
    <h1 class="m-0">{{ __('product detail', ['attr' => '#'.$product->id]) }}</h1>
</div>
<nav aria-label="breadcrumb" class="col-6">
    <ol class="breadcrumb justify-content-end">
      <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('home') }}</a></li>
      <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('products') }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ __('product detail', ['attr' => '']) }}</li>
    </ol>
</nav>
@endsection

@section('content')
    <div class="d-flex align-items-center mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('product name') }}</div>
        <div class="col-6">{{ $product->name }}</div>
    </div>
    <div class="d-flex align-items-center mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('brand name') }}</div>
        <div class="col-6">{{ $product->brand->name }}</div>
    </div>
    <div class="d-flex align-items-center mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('category name') }}</div>
        <div class="col-6">{{ $product->category->name }}</div>
    </div>
    <div class="d-flex align-items-center mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('image') }}</div>
        <div class="col d-flex flex-wrap">
            @foreach ($product->images as $image)
                <div class="col-3 p-2">
                    <div class="img-product shadow-sm">
                        <img src="{{ asset('images/products/' . $image->name) }}" alt="">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="d-flex mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('cost') }}</div>
        <div class="col-6">
            {{ @money($product->cost) }}
        </div>
    </div><div class="d-flex mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('price') }}</div>
        <div class="col-6">
            {{ @money($product->price) }}
        </div>
    </div><div class="d-flex mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('promotion') }}</div>
        <div class="col-6">
            {{ @money($product->promotion) }}
        </div>
    </div>
    <div class="d-flex mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('desc') }}</div>
        <div class="col-6">
            {!! $product->desc !!}
        </div>
    </div>
    <div class="d-flex mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('product info') }}</div>
        <div class="col-6">
            <table class="table table-stripe text-center">
                <thead class="table-dark">
                    <tr>
                        <th>{{ __('colors') }}</th>
                        <th>{{ __('sizes') }}</th>
                        <th>{{ __('quantity') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="list-prinfor">
                    @php
                        $dem = 0;
                        foreach($product->productInfors as $productInfor) {
                            $dem++;
                        }
                        if ($dem==0) {
                            echo "<tr> <td colspan='3'>" . __('no data', ['attr' => __('product')]) . "</td> </tr>";
                        }
                    @endphp
                    @foreach ($product->productInfors as $productInfor)
                        <tr>
                            <td>
                                <div style="height: 20px; background: {{ $productInfor->color->color }}"></div>
                            </td>
                            <td>
                                {{ $productInfor->size->size }}
                            </td>
                            <td>
                                {{ $productInfor->quantity }}
                            </td>
                            <td>
                                <form action="{{ route('product-infors.destroy', $productInfor->id) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="col-5 btn-del btn m-0 p-0" title="{{ __('delete') }}" 
                                        data-confirm="{{ __('delete', ['attr' => __('product info')]) }}">
                                        <a href=""><i class="fa-solid fa-trash"></i></a>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-4">
            <a class="col-5 btn btn-primary" data-toggle="modal" data-target="#product_{{ $product->id }}"  title="{{ __('add info') }}">
                <i class="fa-regular fa-square-plus"></i>
                {{ __('add info') }}
            </a>
        </div>
    </div>
    <div class="modal fade" id="product_{{ $product->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">{{ __('form add info') . " $product->name" }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="{{ route('product-infors.store') }}" data-id="{{ $product->id }}" class="js-form-add" method="POST">
                    <div class="small px-3 py-2 text-danger text-left" id="list_error_{{ $product->id }}"></div>
                    @csrf
                    <div class="modal-body row">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="col-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">{{ __('colors') }}</button>
                                    <div class="dropdown-menu" style="height: 200px; overflow: auto">
                                        @foreach ($colors as $color)
                                            <div class="dropdown-item" data-value="{{ $color->color }}" data-product-id={{ $product->id }} data-color-id={{ $color->id }}
                                                style="margin: 5px auto !important; height: 20px; width: 75%; background: {{ $color->color }}"></div>
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" id="color_{{ $product->id }}" name="color_id" value="{{ $color->first()->id }}">
                                <input type="color" class="form-control" value="{{ $color->first()->color }}" readonly disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select id="size_{{ $product->id }}" class="form-control">
                                    <option disabled selected>{{ __('sizes') }}</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->size }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input id="quantity_{{ $product->id }}" class="form-control" placeholder="{{ __('quantity') }}" type="number" name="quantity">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="d-flex mt-5">
        <div class="col-6 text-start">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                <i class="fa-solid fa-pen-to-square"></i> {{ __('edit') }}
            </a>
        </div>
        <div class="col-6 text-right">
            <a href="{{ route('products.index') }}" class="btn btn-danger">
                <i class="fa-solid fa-rotate-left"></i> {{ __('back') }}
            </a>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.btn-del').click(function(){
            return confirm($(this).attr("data-confirm"));    
        }); 
        $('.dropdown-item').click(function() {
            let id = $(this).attr('data-product-id')
            $('#color_'+id).val($(this).attr('data-color-id'))
            $("input[type='color']").val($(this).attr('data-value'))
        })

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.js-form-add').submit(function(e) {
            e.preventDefault()
            let id = $(this).attr('data-id')
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: {
                    product_id: id,
                    color_id: $("#color_"+ id).val(),
                    size_id: $("#size_"+ id +" :selected").val(),
                    quantity: $("#quantity_"+ id).val()
                },
                success: function(result){
                    if(result.errors) {
                        $('#list_error_'+id).html('');

                        $.each(result.errors, function(key, value){
                            $('#list_error_'+id).show();
                            $('#list_error_'+id).append(value + "<br>");
                        });
                    }
                    else {
                        location.reload();
                    }
                }
            })
        })
    </script>
@endsection
