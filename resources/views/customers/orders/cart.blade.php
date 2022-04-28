@extends('layouts.layoutCustomer')

@section('title')
    {{ __('your cart') }}
@endsection

@section('content')
    <!--Timeline items start -->
<div class="timeline-items container shadow-lg p-3">
    <h2>{{ __('your cart') }}</h2>
    @if ($cart->total_quantity > 0)
        <table class="table-cart table table-borderless">
            <thead class="text-center">
                <tr>
                    <th style="width: 5%"></th>
                    <th style="width: 20%">{{ __('product name') }}</th>
                    <th style="width: 20%">{{ __('product info') }}</th>
                    <th style="width: 10%">{{ __('m_price') }}</th>
                    <th style="width: 12%">{{ __('quantity') }}</th>
                    <th style="width: 15%">{{ __('total price') }}</th>
                    <th style="width: 5%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart->items as $item)
                    <tr style="vertical-align: middle">
                        <td>
                            <img style="height: 50px" class="img-product" src="{{ asset('images/products/'. $item['image']) }}">
                        </td>
                        <td>
                            <div class="name-2">
                                <a class="text-dark" href="{{ route('product.detail', $item['id']) }}">{{ $item['name'] }}</a>
                            </div>
                        </td>
                        <td>
                            <div class="row small fst-italic">
                                <div class="col-12 text-nowrap" style="height: 18px; overflow: hidden; width: 250px; text-overflow: ellipsis">
                                    {{ __('brand') . ': ' . $item['brand'] }}
                                </div>
                                <div class="col-12 text-nowrap" style="height: 18px; overflow: hidden; width: 250px; text-overflow: ellipsis">
                                    {{ __('category') . ': ' . $item['category'] }}
                                </div>
                                <div class="col-12">
                                    {{ __('color') . ": " }}<span class="d-inline-block" style="width: 10px; height: 10px; background: {{ $item['color'] }}"></span> |
                                    {{ __('size') . ': ' . $item['size'] }}
                                </div>
                            </div>
                        </td>
                        <td class="text-center">{{ @money($item['price']) }}</td>
                        <td>
                            <form id="update-price" class="row justify-content-center" action="{{ route('cart.update', $item['id']) }}">
                                <div class="input-group w-75">
                                    <input type="number" name="quantity" class="border-start form-control input-qty" min="1" max="1000" value="{{ $item['quantity'] }}">
                                    <button style="padding: 0.25rem 0.75rem" class="btn btn-primary" type="submit">
                                        <i class="fa-solid fa-rotate small"></i>
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td class="text-center">{{ @money($item['price']*$item['quantity']) }}</td>
                        <td>
                            <a class="btn" href="{{ route('cart.remove', $item['id']) }}">
                                <i class="fa-solid fa-trash text-danger"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row justify-content-end text-end my-5">
            <div class="col-5">
                {{ __('total') }}: 
                <span class="fs-2 text-danger">{{ @money($cart->total_price) }}</span>
            </div>
            <div class="col-2">
                <a class="btn btn-warning" href="{{ route('cart.clear') }}">
                    {{ __('clear') }}
                    <i class="fa-solid fa-broom-ball"></i>
                </a>
            </div>
            <div class="col-1"></div>
        </div>
        <div class="text-end">
            <a class="btn btn-danger" href="{{ route('checkout') }}">
                <i class="fa-solid fa-circle-dollar-to-slot"></i>
                {{ __('checkout') }}
            </a>
        </div>
    @else
        <div class="d-flex justify-content-center align-items-center flex-column">
            <img src="{{ asset('images/logo/no-cart.png') }}" alt="">
            <p class="my-3">{{ __('empty cart') }}</p>
            <a href="{{ route('products') }}" class="btn btn-danger">{{ __('shop now') }}</a>
        </div>
    @endif
</div>
<!--Timeline items end -->
@endsection
