@extends('layouts.layoutCustomer')

@section('title')
    {{ $product->name }}
@endsection

@section('content')
    <div class="row">
        <div class="col-6 p-3">
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner bg-warning">
                    @foreach ($product->images as $image)
                        <div class="carousel-item">
                            <div class="d-flex justify-content-center align-items-center">
                                <img style="height: 400px" src="{{ asset('images/products/' . $image->name) }}"
                                    class="d-block" alt="...">
                            </div>
                        </div>
                    @endforeach
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                @foreach ($product->images as $image)
                    <div class="col-2 p-2 m-2 d-flex justify-content-center align-items-center border rounded">
                        <div class="">
                            <img class="w-100" src="{{ asset('images/products/' . $image->name) }}" alt="">
                        </div>
                    </div>
                @endforeach
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
            <div class="p-3">
                <div class="d-inline price fs-6">{{ @money($product->price) }}</div>
                <div class="d-inline promotion fs-2">{{ @money($product->promotion) }}</div>
                @php
                    $sale = -round((($product->price - $product->promotion) / $product->price) * 100, 1);
                @endphp
                <div class="mb-1 ms-3 badge bg-danger">{{ $sale }}%</div>
            </div>
            <form action="">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                @if ($sizes->count() > 0)
                    <div class="row my-2">
                        <div class="col-2">{{ __('sizes') }}</div>
                        <div class="col-9 row">
                            @foreach ($sizes as $size)
                                <div class="col-2 pb-2">
                                    <input class="checkbox-tools" type="radio" name="size_id"
                                        id="size_{{ $size->size->id }}">
                                    <label class="for-checkbox-tools px-3 py-2" for="size_{{ $size->size->id }}">
                                        {{ $size->size->size }}
                                    </label>
                                </div>
                            @endforeach
                            <input type="hidden" name="size_id" value="">
                            <div class="col-12">
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
                                <div class="col-3 pb-2">
                                    <input type="radio" id="color_{{ $color->color->id }}" name="color_id"
                                        value="{{ $color->color->id }}">
                                    <label class="w-100" for="color_{{ $color->color->id }}">
                                        <span class="w-100 rounded" style="background: {{ $color->color->color }}">
                                            <i class="fs-5 fa-solid fa-circle-check"></i>
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-2">{{ __('quantity') }}</div>
                        <div class="col-9">
                            <div class="buttons_added">
                                <input class="minus is-form" type="button" value="-">
                                <input aria-label="quantity" class="input-qty" max="100" min="1" name="" type="number"
                                    value="1">
                                <input class="plus is-form" type="button" value="+">
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
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
                    {!! $product->desc !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.carousel-inner .carousel-item:first').addClass('active')
        $('input.input-qty').each(function() {
            var $this = $(this),
                qty = $this.parent().find('.is-form'),
                min = Number($this.attr('min')),
                max = Number($this.attr('max'))
            if (min == 0) {
                var d = 0
            } else d = min
            $(qty).on('click', function() {
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
    </script>
@endsection
