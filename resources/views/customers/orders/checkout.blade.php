@extends('layouts.layoutCustomer')

@section('title')
    {{ __('checkout') }}
@endsection

@section('content')
<div class="container px-4 px-lg-5 mt-5">
    <div class="d-flex justify-content-between align-items-center bg-dark py-4 fs-2 mb-5">
        <div class="ps-3">
            <a class="text-white" href="{{ url()->previous() }}" title="{{ __('back') }}"><i class="fa-solid fa-left-long"></i></a>
        </div>
        <div class="text-uppercase text-white">{{ __('order infor') }}</div>
        <div></div>
    </div>
    <div class="card my-3">
        <div class="card-body">
            <div class="px-3 pt-3">
                <p class="fs-5 title-check">{{ __('list') . __('products') }}</p>
                <table class="table-cart table table-borderless">
                    <thead class="text-center">
                        <tr>
                            <th style="width: 5%"></th>
                            <th style="width: 20%">{{ __('product name') }}</th>
                            <th style="width: 20%">{{ __('product info') }}</th>
                            <th style="width: 10%">{{ __('m_price') }}</th>
                            <th style="width: 12%">{{ __('quantity') }}</th>
                            <th style="width: 15%">{{ __('total price') }}</th>
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
                                <td class="text-center">
                                    {{ $item['quantity'] }}
                                </td>
                                <td class="text-center">{{ @money($item['price']*$item['quantity']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <form action="">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row p-3">
                    <div class="list-inline-item mb-3">
                        <span class="fs-4 title-check">
                            <i class="fa-solid text-danger fa-location-dot"></i> {{ __('consignee information') }}
                        </span>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">{{ __('fullname') }}</label>
                            <input name="fullname" required  autocomplete="fullname" autofocus type="text" class="form-control" id="fullname" value="{{ Auth::user()->fullname }}">

                            @error('fullname')
                                <span class="invalid-feedback" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('phone') }}</label>
                            <input name="phone" required  autocomplete="phone" autofocus type="text" class="form-control" id="phone" value="{{ Auth::user()->phone }}">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">{{ __('address') }}</label>
                            <input name="address" required  autocomplete="address" autofocus type="text" class="form-control" id="address" value="{{ Auth::user()->address }}">

                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="note" class="form-label">{{ __('note') }}</label>
                            <textarea class="form-control" name="note" id="note" rows="8"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row p-3">
                    <div class="list-inline-item">
                        <span class="fs-4 title-check"><i class="fa-solid text-primary fa-money-bills"></i> {{ __('payment') }}</span>
                        <span class="fs-5 float-end">{{ __('cash') }}</span>
                    </div>
                    <div>
                        <table cellpadding="8" class="float-end">
                            <tbody>
                                <tr>
                                    <td><strong>{{ __('total') }}<strong></td>
                                    <td>{{ @money($total_price) }}</td>
                                </tr>
                                <tr>
                                    <td ><strong>{{ __('shipping') }}</strong></td>
                                    <td class="float-end">{{ @money($shipping) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('total') }}<strong></td>
                                    <td class="total-check">{{ @money($total_price + $shipping) }}
                                        <input type="hidden" name="total_price" value="{{ $total_price + $shipping }}">
                                    </td>
                                </tr>
                            </tbody>
                            
                        </table>
                    </div>
                </div> 
                <div class="line-space">
                    <button type="submit" class="btn btn-danger float-end mt-3 fs-5 py-1">{{ __('place order') }}</button>
                </div>
            </div>
        </div>
    </form>
    
</div>
@endsection
