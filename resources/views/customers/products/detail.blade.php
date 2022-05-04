@extends('layouts.layoutCustomer')

@section('title')
    {{ $product->name }}
@endsection


@section('content')
    <div class="d-flex justify-content-between align-items-center bg-dark py-4 fs-5">
        <div class="ps-3">
            <a class="text-white" href="{{ url()->previous() }}" title="{{ __('back') }}">
                <i class="fa-solid fa-chevron-left"></i> {{ __('back') }}
            </a>
        </div>
        <div class="text-uppercase fs-2 text-white">{{ $product->name }}</div>
        <div class="text-white col-1 d-flex">
            <div class="previous col-6 position-relative">
                <a class="js-hover" href="{{ route('product.detail', $productPrevious->id) }}">
                    <i style="transition: .5s" class="fa-solid text-white fa-arrow-left-long"></i>
                </a>
                <div class="position-absolute" style="right: 0; display: none">
                    <div class="p-2 bg-white shadow-sm" style="width: 230px">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-4 text-center">
                                <img height="40" src="{{ asset('images/products/' . $productPrevious->images->first()->name) }}" alt="">
                            </div>
                            <div class="col-8 text-dark overflow-hidden">
                                <p class="mb-0 fw-bold" style="font-size: 14px">{{ $productPrevious->name }}</p>
                                <p class="mb-0">
                                    <span style="font-size: 10px" class="text-decoration-line-through text-secondary">{{ @money($productPrevious->promotion) }}</span>
                                    <span style="font-size: 14px" class="fst-italic text-danger">{{ @money($productPrevious->promotion) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="next col-6 position-relative">
                <a class="js-hover" href="{{ route('product.detail', $productNext->id) }}">
                    <i style="transition: .5s" class="fa-solid text-white fa-arrow-right-long"></i>
                </a>
                <div class="position-absolute" style="right: 0; display: none">
                    <div class="p-2 bg-white shadow-sm" style="width: 230px">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-4 text-center">
                                <img height="40" src="{{ asset('images/products/' . $productNext->images->first()->name) }}" alt="">
                            </div>
                            <div class="col-8 text-dark overflow-hidden">
                                <p class="mb-0 fw-bold" style="font-size: 14px">{{ $productNext->name }}</p>
                                <p class="mb-0">
                                    <span style="font-size: 10px" class="text-decoration-line-through text-secondary">{{ @money($productNext->promotion) }}</span>
                                    <span style="font-size: 14px" class="fst-italic text-danger">{{ @money($productNext->promotion) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    {{ round($product->comments->avg('rating'), 2) }}
                    <i style="font-size: 12px" class="fa-solid text-warning fa-star"></i>
                    <span class="ms-3">({{ $product->comments->count() . " " .__('review') }})</span>
                </div>
                <div class="col-3">
                    {{ $quantitySold . " " . __('sold') }}
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
                    <li class="list-inline-item px-3 py-2"><a class="text-uppercase text-dark fw-bold fs-4" href="#tab-content-1">{{ __('additional infor') }}</a></li>
                    <li class="list-inline-item px-3 py-2 nav-tab-active"><a class="text-uppercase text-dark fw-bold fs-4" href="#tab-content-2">{{ __('comment') }}</a></li>
                    <li class="list-inline-item px-3 py-2"><a class="text-uppercase text-dark fw-bold fs-4" href="#tab-content-3">{{ __('related products') }}</a></li>
                </ul>
            </div>
            <div class="tab-content p-2">
                <div id="tab-content-1" class="tab-content-item">
                    <div>
                        <div class="row justify-content-center">
                            <div class="col-2 fs-5">
                                {{ __('brands') }}
                            </div>
                            <div class="col-5 text-end">
                                {{ $product->brand->name }}
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-2 fs-5">
                                {{ __('categories') }}
                            </div>
                            <div class="col-5 text-end">
                                {{ $product->category->name }}
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-2 fs-5">
                                {{ __('sizes') }}
                            </div>
                            <div class="col-5 text-end">
                                @foreach ($sizes as $size)
                                    <span class="size-item">{{ $size->size->size }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-7">
                                <hr style="height: 3px">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="fw-bold fs-4">
                            {{ __('desc') }}
                        </div>
                        {!! $product->desc !!}
                    </div>
                </div>
                <div id="tab-content-2" class="tab-content-item">
                    <div class="well well-sm mb-4 d-flex justify-content-center">
                        <div class="col-9">
                            <div class="row justify-content-center align-items-center mx-5 p-3 border rounded">
                                <div class="col-3 text-center position-relative vertical-right">
                                    <h1 class="rating-num text-warning fw-bold">{{ round($product->comments->avg('rating'), 2) }} <i class="fa-solid fa-star"></i></h1>
                                    <div>
                                        <span class="glyphicon glyphicon-user"></span>{{ $product->comments->count() . " " .__('review') }} 
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="row rating-desc">
                                        @php
                                            $totalStar = 0;
                                            foreach($list_star as $count) {
                                                $totalStar += $count;
                                            }
                                            $totalStar = $totalStar == 0 ? 1 : $totalStar;
                                        @endphp
                                        @foreach ($list_star as $star => $count)
                                            <div class="col-2 text-end">
                                                <i class="fa-solid text-warning fa-star"></i>{{ $star }}
                                            </div>
                                            <div class="col-9">
                                                <div class="progress progress-striped">
                                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20"
                                                        aria-valuemin="0" aria-valuemax="100" style="width: {{ $count/$totalStar *100 }}%">
                                                        <span class="ms-2 {{ $count/$totalStar *100 > 0 ? "text-white" : "text-dark" }} position-absolute">{{ round($count/$totalStar *100, 2) }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- end row -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="comment">
                        <div class="all-comment">
                            @foreach ($product->comments as $comment)
                                <div class="row mb-4">
                                    <div class="col-1">
                                        <div class="avt-cmt text-end" style="box-shadow: 0 0 2px #000">
                                            <img height="50" src="{{ asset('images/users/' . $comment->user->image->name) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-11">
                                        <p class="mb-0 fw-bold">{{ $comment->user->fullname }}</p>
                                        <div class="star_rating d-flex">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $comment->rating)
                                                    <div class="text-warning"><i class="fa-solid fa-star"></i></div>
                                                @else
                                                    <div class="text-warning"><i class="fa-regular fa-star"></i></div>
                                                @endif
                                            @endfor
                                        </div>
                                        <div class="mt-1">
                                            {{ $comment->content }}
                                        </div>
                                        @if ($comment->user_id == Auth::user()->id)
                                            <form class="ms-2" action="{{ route('comment.destroy', $comment->id) }}" method="POST">
                                                <sup class="text-info" id="btn-edit-cmt">{{ __('edit') }}</sup>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" id="btn-del" class="btn btn-delete text-info" data-confirm="{{ __('delete confirm') }}">
                                                    <sup>{{ __('delete') }}</sup>
                                                </button>
                                            </form>
                                            <form method="POST" id="form-edit-cmt" class="visually-hidden" action="{{ route('comment.update', $comment->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <textarea class="form-control" name="content" id="comment-content" 
                                                    placeholder="{{ __('enter comment') }}" rows="3">{{ $comment->content }}</textarea>
                                                
                                                <button type="submit" class="btn btn-primary mt-1">{{ __('update') }}</button>
                                            </form>
                                            @error('content')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if ($allowComment)
                            <div class="my-comment">
                                <div class="row">
                                    <div class="col-1">
                                        <div class="avt-cmt text-end" style="box-shadow: 0 0 2px #000">
                                            <img height="50" src="{{ asset('images/users/' . Auth::user()->image->name) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-11">
                                        <p class="mb-0 fw-bold">{{ Auth::user()->fullname }}</p>
                                        <form action="{{ route('comment', $product->id) }}" id="form-comment" method="POST" role="form">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="rating" id="rating" value="5" />
                                            <div class="star_rating d-flex">
                                                <div class="star text-warning"><i class="fa-solid fa-star"></i></div>
                                                <div class="star text-warning"><i class="fa-solid fa-star"></i></div>
                                                <div class="star text-warning"><i class="fa-solid fa-star"></i></div>
                                                <div class="star text-warning"><i class="fa-solid fa-star"></i></div>
                                                <div class="star text-warning"><i class="fa-solid fa-star"></i></div>
                                            </div>
                                            <div class="mb-3 mt-1">
                                                <textarea class="form-control" name="content" id="content" placeholder="{{ __('enter comment') }}" rows="3"></textarea>
                                                @error('content')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <input type="submit" id="btn-comment" class="btn btn-primary" value="{{ __('post comment') }}">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                    <p class="text-2 mb-0 col-12">{{ $product->name }}</p>
                                    <div class="col-12">
                                        <div class="d-flex align-items-end">
                                            @php
                                                $rating = $product->comments->avg('rating');
                                                $ratingInt = (int) $rating;
                                            @endphp
                                            @for ($i = 1; $i <= 5 ; $i++)
                                                @if ($i <= $ratingInt)
                                                    <div class="text-warning small"><i class="fa-solid fa-star"></i></div>
                                                @elseif($ratingInt < $rating)
                                                    <div class="text-warning small"><i class="fa-solid fa-star-half-stroke"></i></div>
                                                @else
                                                    <div class="text-warning small"><i class="fa-regular fa-star"></i></div>
                                                @endif
                                            @endfor
                                            <div class="ms-1" style="font-size: 12px">{{ $rating ?? 0 }} ({{ $product->comments->count() . " " .__('review') }})</div>
                                        </div>
                                    </div>
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
        $('.tab-content-item:nth-child(2)').fadeIn()
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

        $('.star').each(function(i, star) {
            $(star).click(function() {
                let current_star = i + 1
                $('#rating').val(current_star)

                $('.star').each(function(j, star) {
                    if (current_star >= j+1) {
                        $(star).html(`<i class="fa-solid fa-star"></i>`)
                    } else {
                        $(star).html(`<i class="fa-regular fa-star"></i>`)
                    }
                })
            })
        })

        $('.js-hover').hover(
            function() {
                $(this).next().stop(true, false, true).fadeIn();
                $(this).find('i').css("transform", "scaleX(1.5)");
            },
            function() {
                $(this).next().stop(true, false, true).fadeOut();
                $(this).find('i').css("transform", "scaleX(1)");
            }
        )

        $('#btn-edit-cmt').click(function () {
            $('#form-edit-cmt').toggleClass('visually-hidden');
        })
    </script>
@endsection
