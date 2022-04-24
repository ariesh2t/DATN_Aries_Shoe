@extends('layouts/layoutCustomer')
@section('title')
    {{ __('home') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-8 p-3">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                </div>
                <div class="carousel-inner bg-warning">
                    <div class="carousel-item active">
                        <div class="d-flex justify-content-center align-items-center">
                            <img style="height: 300px" src="{{ asset('images/logo/slide1.png') }}" class="d-block" alt="...">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex justify-content-center align-items-center">
                            <img style="height: 300px" src="{{ asset('images/logo/slide2.jpg') }}" class="d-block" alt="...">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex justify-content-center align-items-center">
                            <img style="height: 300px" src="{{ asset('images/logo/slide3.webp') }}" class="d-block" alt="...">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex justify-content-center align-items-center">
                            <img style="height: 300px" src="{{ asset('images/logo/slide4.jpeg') }}" class="d-block" alt="...">
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span aria-hidden="true"><i class="fs-3 fa-solid fa-chevron-left"></i></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span aria-hidden="true"><i class="fs-3 fa-solid fa-chevron-right"></i></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        @foreach ($get4Brands as $brand)
            <div class="col-4 p-3" style="height: 332px">
                <div class="overflow-hidden hover-parent" style="height: 300px">
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                        <img style="min-width: 100%; min-height: 100%" src="{{ asset('images/brands/' . $brand->image->name ) }}" alt="{{ $brand->name }}">
                    </div>
                    <div class="hover-child text-center">
                        <div><p style="max-width: 200px; overflow: hidden; text-overflow: ellipsis" 
                            class="fw-bold m-0 text-uppercase text-white fs-2">{{ $brand->name }}</p></div>
                        <a href="{{ route('brand', $brand->id) }}" class="btn btn-warning text-uppercase">
                            {{ __('show now') }}
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-5 shadow-lg p-3">
        <div class="d-flex justify-content-center list-cat mb-3">
            @foreach ($categories as $category)
                <div class="">
                    <i class="fa-regular fa-circle-down"></i> 
                    <a href="{{ route('home-cat', $category->id) }}" data-id="{{ $category->id }}" class="text-black text-uppercase fw-bold js-select-cat">
                        {{ $category->name }}
                    </a>
                </div>
            @endforeach
        </div>
        <div class="row js-show-product" data-id="{{ $categories->first()->id }}"></div>
    </div>
@endsection

@section('script')
    <script>
        function number_format(number, decimals, dec_point, thousands_sep) {
            number = number.toFixed(decimals);

            var nstr = number.toString();
            nstr += '';
            x = nstr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? dec_point + x[1] : '';
            var rgx = /(\d+)(\d{3})/;

            while (rgx.test(x1))
                x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

            return x1 + x2;
        }

        let id = $('.js-show-product').attr('data-id')
        $.get(window.location.protocol + '//' + window.location.host + "/home-cat/" + id, function(response) {
            $('.list-cat div:first .js-select-cat').css('border-bottom', '3px solid orange')
            if (response.length === 0) {
                $('.js-show-product').html("{{ __('no product in cat') }}");
            } else {
                response.forEach(element => {
                    let price = Number(element.price)
                    let promotion = Number(element.promotion)
                    let percent = -number_format((price - promotion) /price * 100, 1, '.', ',');
                    let sale_dom = ''; let price_dom = '';
                    if (percent != 0) {
                        sale_dom = `
                            <div class="percent">
                                `+percent+`%
                            </div>`;
                        price_dom = `
                        <span class="price">`+number_format(price, 0, '.', ',')+`</span>
                        `;
                    }
                    let dom = `
                    <div class="position-relative css-hover-product col-3 p-3 d-flex flex-wrap justify-content-start align-items-center">
                        <div class="overflow-hidden w-100 text-center" style="height: 180px; line-height: 180px">
                            <img style="max-height: 100%; max-width: 100%" src="{{ asset('images/products/`+ element.images[0].name +`') }}" alt="">
                        </div>`+sale_dom+`
                        <p class="text-2 col-12">`+element.name+`</p>
                        <div class="wrap-price">
                            <div class="wrapp-swap">
                                <div class="swap-elements">
                                    <div class="css-price">
                                        `+price_dom+`
                                        <span class="promotion fs-5">`+number_format(promotion, 0, '.', ',')+`</span>
                                    </div>
                                    <div class="btn-add">
                                        <a class="w-100" href="">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            Chon mua
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                    $('.js-show-product').append(dom)
                });
            }
        });

        $('.js-select-cat').click(function(e) {
            e.preventDefault();
            $('.list-cat div .js-select-cat').css('border-bottom', 'none')
            $(this).css('border-bottom', '3px solid orange')

            $('.js-show-product').attr('data-id', $(this).attr('data-id'))
            $.get($(this).attr('href'), function(response) {
                $('.js-show-product').html('')
                if (response.length === 0) {
                    $('.js-show-product').html("{{ __('no product in cat') }}");
                } else {
                    response.forEach(element => {
                        let price = Number(element.price)
                        let promotion = Number(element.promotion)
                        let percent = -number_format((price - promotion) /price * 100, 1, '.', ',');
                        let sale_dom = ''; let price_dom = '';
                        if (percent != 0) {
                            sale_dom = `
                                <div class="percent">
                                    `+percent+`%
                                </div>`;
                            price_dom = `
                            <span class="price">`+number_format(price, 0, '.', ',')+`</span>
                            `;
                        }
                        let dom = `
                        <div class="position-relative css-hover-product col-3 p-3 d-flex flex-wrap justify-content-start align-items-center">
                            <div class="overflow-hidden w-100 text-center" style="height: 180px; line-height: 180px">
                                <img style="max-height: 100%; max-width: 100%" src="{{ asset('images/products/`+ element.images[0].name +`') }}" alt="">
                            </div>`+sale_dom+`
                            <p class="text-2 col-12">`+element.name+`</p>
                            <div class="wrap-price">
                                <div class="wrapp-swap">
                                    <div class="swap-elements">
                                        <div class="css-price">
                                            `+price_dom+`
                                            <span class="promotion fs-5">`+number_format(promotion, 0, '.', ',')+`</span>
                                        </div>
                                        <div class="btn-add">
                                            <a class="w-100" href="">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                                Chon mua
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                        $('.js-show-product').append(dom)
                    });
                }
			});
        })
    </script>
@endsection
