@extends('layouts.layoutCustomer')

@section('title')
    {{ $product->name }}
@endsection

@section('content')
    <div class="row mb-5">
        <div class="col-6 p-3">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators custom-carousel">
                    @foreach ($product->images as $key=>$image)
                        <button class="border rounded" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $key }}">
                            <img class="w-100" src="{{ asset('images/products/' . $image->name) }}" alt="">
                        </button>
                    @endforeach
                </div>
                <div class="carousel-inner bg-warning">
                    @foreach ($product->images as $image)
                        <div class="carousel-item">
                            <div class="d-flex justify-content-center align-items-center">
                                <img style="height: 400px" src="{{ asset('images/products/' . $image->name) }}"
                                    class="d-block" alt="...">
                            </div>
                        </div>
                    @endforeach
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div style="height: 120px">

            </div>
        </div>
        <div class="col-6 p-3">
            <div class="name-product py-3">
                <h1>{{ $product->name }}</h1>
            </div>
            <div class="rate row">
                <div class="col-4">
                    5.00 ***** (2 rating)
                </div>
                <div class="col-3">
                    100 sold
                </div>
            </div>
            <div class="my-2 p-2 rounded" style="background: #f1efef">
                @if ($product->price == $product->promotion)
                    <div class="d-inline promotion fs-2">{{ @money($product->promotion) }}</div>
                @else
                    <div class="d-inline price fs-6">{{ @money($product->price) }}</div>
                    <div class="d-inline promotion fs-2">{{ @money($product->promotion) }}</div>
                    @php
                        $sale = -round((($product->price - $product->promotion) / $product->price) * 100, 1);
                    @endphp
                    <div class="mb-1 ms-3 badge bg-danger">{{ $sale }}%</div>
                @endif
            </div>
            <form action="{{ route('cart.add', $product->id) }}" method="GET">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                @if ($sizes->count() > 0)
                    <div class="row my-2">
                        <div class="col-2">{{ __('sizes') }}</div>
                        <div class="col-9 row">
                            @foreach ($sizes as $size)
                                <div class="col-2">
                                    <input class="checkbox-tools" type="radio" name="size_id" {{(old('size_id') == $size->size->id) ? 'checked' : ''}}
                                        id="size_{{ $size->size->id }}" value="{{ $size->size->id }}">
                                    <label class="for-checkbox-tools px-3 py-2" for="size_{{ $size->size->id }}">
                                        {{ $size->size->size }}
                                    </label>
                                </div>
                            @endforeach
                            @error('size_id')
                                <span class="invalid-feedback" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                            <div class="col-12 my-3">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    {{ __('guide choose size') }}
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img class="w-100" src="{{ asset('images/logo/Bang-do-size-chan.jpg') }}" alt="">
                                            <img class="w-100" src="{{ asset('images/logo/size-giay-tre.jpg') }}" alt="">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-2">{{ __('colors') }}</div>
                        <div class="col-9 row custom-radios">
                            @foreach ($colors as $color)
                                <div class="col-3 mb-2">
                                    <input type="radio" id="color_{{ $color->color->id }}" name="color_id"
                                        value="{{ $color->color->id }}" {{(old('color_id') == $color->color->id) ? 'checked' : ''}}>
                                    <label class="w-100" for="color_{{ $color->color->id }}">
                                        <span class="w-100 rounded" style="background: {{ $color->color->color }}">
                                            <i class="fs-5 fa-solid fa-circle-check"></i>
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                            @error('color_id')
                                <span class="invalid-feedback" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-2">{{ __('quantity') }}</div>
                        <div class="col-9">
                            <div class="buttons_added mb-2">
                                <input class="minus is-form" type="button" value="-">
                                <input aria-label="quantity" id="input-qty" class="input-qty" max="{{ $totalQuantity }}" min="1" name="quantity" type="number"
                                    value="{{ old('quantity') ?? 1 }}">
                                <input class="plus is-form" type="button" value="+">
                                <div id="totalQuantity" class="d-flex ms-3 align-items-center"><span class="mx-1">{{ $totalQuantity }}</span>{{ __('products') }}</div>
                            </div>

                            @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="text-end js-button">
                        <button class="btn btn-danger" type="submit">
                            <i class="fa-solid fa-cart-plus"></i>
                            {{ __('add to cart') }}
                        </button>
                    </div>
                @else
                    <div class="row">
                        <div class="col">
                            {{ __('out of stock') }}
                        </div>
                    </div>
                @endif
            </form>
            <div class="card mt-3 border-info">
                <div class="card-body">
                    <h5 class="card-title text-uppercase fw-bold">{{ __('offer for customers') }}</h5>
                    <ul>
                        <li>{{ __('can check') }}</li>
                        <li>{{ __('return goods') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="product-info shadow-lg pt-3 mt-3 p-3">
        <div class="tabs">
            <div class="d-flex justify-content-center border-bottom border-3">
                <ul class="nav-tab mb-0 list-inline">
                    <li class="list-inline-item px-3 py-2 nav-tab-active"><a class="text-uppercase text-dark fw-bold fs-4" href="#tab-content-1">{{ __('desc') }}</a></li>
                    <li class="list-inline-item px-3 py-2"><a class="text-uppercase text-dark fw-bold fs-4" href="#tab-content-2">{{ __('additional infor') }}</a></li>
                    <li class="list-inline-item px-3 py-2"><a class="text-uppercase text-dark fw-bold fs-4" href="#tab-content-3">{{ __('related products') }}</a></li>
                </ul>
            </div>
            <div class="tab-content p-2">
                <div id="tab-content-1" class="tab-content-item">
                    {!! $product->desc !!}
                </div>
                <div id="tab-content-2" class="tab-content-item">
                    <div class="row justify-content-center">
                        <div class="col-3">
                            {{ __('brands') }}
                        </div>
                        <div class="col-7">
                            {{ $product->brand->name }}
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3">
                            {{ __('categories') }}
                        </div>
                        <div class="col-7">
                            {{ $product->category->name }}
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3">
                            {{ __('sizes') }}
                        </div>
                        <div class="col-7">
                            @foreach ($sizes as $size)
                                <span>{{ $size->size->size }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="tab-content-3" class="tab-content-item">
                    <div class="d-flex flex-wrap">
                        @foreach ($relatedProducts as $product)
                            <div class="col-md-4 col-lg-3 col-6 p-2">
                                <div class="position-relative p-2 border rounded d-flex flex-wrap justify-content-start align-items-center">
                                    <div class="overflow-hidden hover-img-product w-100 text-center" style="height: 180px; line-height: 180px">
                                        <img style="max-height: 100%; max-width: 100%" src="{{ asset('images/products/' . $product->images->first()->name) }}" alt="">
                                    </div>
                                    @php
                                        if ($product->price != $product->promotion) {
                                            $sale = -round(($product->price - $product->promotion) / $product->price * 100, 1);
                                            echo "<div class='percent'>";
                                            echo $sale . "%";
                                            echo "</div>";
                                        }
                                    @endphp
                                    <p class="text-2 col-12">{{ $product->name }}</p>
                                    <div class="wrap-price css-hover-product">
                                        <div class="wrapp-swap">
                                            <div class="swap-elements">
                                                <div class="css-price">
                                                    @if ($product->price != $product->promotion)
                                                        <span class="price">{{ @money($product->price) }}</span> 
                                                    @endif
                                                    <span class="promotion fs-5">{{ @money($product->promotion) }}</span>
                                                </div>
                                                <div class="btn-add">
                                                    <a class="w-100" href="{{ route('product.detail', $product->id) }}">
                                                        <i class="fa-solid fa-cart-shopping"></i>
                                                        {{ __('detail') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.carousel-inner .carousel-item:first').addClass('active')
        $('.carousel-indicators :first').addClass('active')
        $('input.input-qty').each(function() {
            var $this = $(this),
                qty = $this.parent().find('.is-form'),
                min = Number($this.attr('min'))
            if (min == 1) {
                var d = 1
            } else d = min
            $(qty).on('click', function() {
                max = Number($('.buttons_added').find('#input-qty').attr('max'))
                if ($(this).hasClass('minus')) {
                    if (d > min) d += -1
                } else if ($(this).hasClass('plus')) {
                    var x = Number($this.val()) + 1
                    if (x <= max) d += 1
                }
                $this.attr('value', d).val(d)
            })
        })

        $('.tab-content-item').hide()
        $('.tab-content-item:first').fadeIn()
        $('.nav-tab li').click(function(e) {
            e.preventDefault()
            $('.nav-tab li').removeClass('nav-tab-active')
            $(this).addClass('nav-tab-active')

            let id = $(this).find('a').attr('href')
            $('.tab-content-item').hide()
            $(id).fadeIn()
        })

        var color_id = ''
        var size_id = ''
        var id =  $("input[name='id']").val()
        var url = window.location.protocol + '//' + window.location.host + "/product/"+ id +"/quantity"
        $("input[name='color_id']").click(function() {
            color_id = $(this).val();
            $.get(url, { id: id, color_id: color_id, size_id: size_id } )
            .done(function( data ) {
                $('#totalQuantity span').html(data)
                $("input[name='quantity']").attr('max', data)
                if (data == 0) {
                    $(".js-button").find('button').attr('disabled', 'disabled')
                } else {
                    $(".js-button").find('button').removeAttr('disabled')
                }
            })
        })

        $("input[name='size_id']").click(function() {
            size_id = $(this).val();
            $.get(url, { id: id, color_id: color_id, size_id: size_id } )
            .done(function( data ) {
                $('#totalQuantity span').html(data)
                $("input[name='quantity']").attr('max', data)
                if (data == 0) {
                    $(".js-button").find('button').attr('disabled', 'disabled')
                } else {
                    $(".js-button").find('button').removeAttr('disabled')
                }
            })
        })


    </script>
@endsection
