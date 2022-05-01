@extends('layouts.layoutCustomer')

@section('title')
    {{ __('detail') }}
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center bg-dark py-4 fs-5 mb-3">
        <div class="ps-3">
            <a class="text-white" href="{{ url()->previous() }}" title="{{ __('back') }}">
                <i class="fa-solid fa-chevron-left"></i> {{ __('back') }}
            </a>
        </div>
        <div class="text-uppercase fs-2 text-white">{{ __('order detail', ['attr' => $order->id]) }}</div>
        <div></div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class=""></div>
            <div class="px-3 pt-3">
                <div class="px-5">
                    <div class="stepwizard">
                        <div class="stepwizard-row setup-panel d-flex justify-content-center align-items-center position-relative">
                            <div class="stepwizard-step row justify-content-center col-2"> 
                                <div class="btn btn-circle bg-primary @if($order->order_status_id != 1) bg-white text-dark @endif col-12">1</div>
                                <p class="col-12 text-center"><small>{{ __('waiting') }}</small></p>
                            </div>
                            <div class="stepwizard-step row justify-content-center col-2"> 
                                <div class="btn btn-circle bg-warning @if($order->order_status_id != 2) bg-white text-dark @endif col-12">2</div>
                                <p class="col-12 text-center"><small>{{ __('preparing') }}</small></p>
                            </div>
                            <div class="stepwizard-step row justify-content-center col-2"> 
                                <div class="btn btn-circle bg-warning @if($order->order_status_id != 3) bg-white text-dark @endif col-12">3</div>
                                <p class="col-12 text-center"><small>{{ __('shipping') }}</small></p>
                            </div>
                            <div class="stepwizard-step row justify-content-center col-2"> 
                                <div class="btn btn-circle bg-success @if($order->order_status_id != 4) bg-white text-dark @endif col-12">4</div>
                                <p class="col-12 text-center"><small>{{ __('delivered') }}</small></p>
                            </div>
                            <div class="stepwizard-step row justify-content-center col-2"> 
                                <div class="btn btn-circle bg-secondary @if($order->order_status_id != 5) bg-white text-dark @endif col-12">5</div>
                                <p class="col-12 text-center"><small>{{ __('cancelled') }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <span class="fs-4 title-check">
                        <i class="fa-solid text-danger fa-location-dot"></i> {{ __('consignee information')}}
                    </span>
                </div>
                <div class="d-flex fs-5">
                    <div class="col-lg-3">
                        <p class="fw-bolder">{{ $order->fullname }}</p>
                        <p class="fw-bolder">{{ $order->phone }}</p>
                    </div>
                    <div class="col-lg-5">{{ $order->address }}</div>
                </div>
            </div>     
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="px-3 pt-3">
                <p class="fs-4 title-check">{{ __('list') . __('products') }}</p>
                <table class="table-cart table table-borderless">
                    <thead>
                        <tr>
                            <th style="width: 5%"></th>
                            <th style="width: 20%">{{ __('product name') }}</th>
                            <th style="width: 20%">{{ __('product info') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('m_price') }}</th>
                            <th class="text-center" style="width: 12%">{{ __('quantity') }}</th>
                            <th class="text-center" style="width: 15%">{{ __('total price') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $product)
                            <tr>
                                <td>
                                    <img style="height: 50px" class="img-product" src="{{ asset('images/products/'. $product->images->first()->name) }}">
                                </td>
                                <td>
                                    <a class="text-dark" href="{{ route('product.detail', $product->id) }}">{{ $product->name }}</a>
                                </td>
                                <td>
                                    <div class="row small fst-italic">
                                        <div class="col-12 text-nowrap" style="height: 18px; overflow: hidden; width: 250px; text-overflow: ellipsis">
                                            {{ __('brand') . ': ' . $product->brand->name }}
                                        </div>
                                        <div class="col-12 text-nowrap" style="height: 18px; overflow: hidden; width: 250px; text-overflow: ellipsis">
                                            {{ __('category') . ': ' . $product->category->name }}
                                        </div>
                                        <div class="col-12">
                                            {{ __('color') . ": " }}<span class="d-inline-block" style="width: 10px; height: 10px; background: {{ $product->pivot->color }}"></span> |
                                            {{ __('size') . ': ' . $product->pivot->size }}
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ @money($product->pivot->price) }}</td>
                                <td class="text-center">
                                    {{ $product->pivot->quantity }}
                                </td>
                                <td class="text-center">{{ @money($product->pivot->price * $product->pivot->quantity) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row p-3">
                <div class="list-inline-item">
                    <span class="fs-4 title-check">{{ __('payment method') }}</span>
                    <span class="fs-5 float-end">{{ __('cash') }}</span>
                </div>
                <div>
                    <table cellpadding="8" class="float-end">
                        <tbody>
                            <tr>
                                <td><strong>{{ __('total') }}<strong></td>
                                <td class="float-end">{{ @money($order->total_price) }}</td>
                            </tr>
                            <tr>
                                <td ><strong>{{ __('delivery charges') }}</strong></td>
                                <td class="float-end">{{ @money($order->shipping) }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ __('total payment') }}<strong></td>
                                <td class="fs-3 text-danger total-check">{{ @money($order->order_price) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($order->order_status_id == config('orderstatus.waiting') || $order->order_status_id == config('orderstatus.preparing'))
                <div class="text-end">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        {{ __('cancel order') }}
                    </button>
                    
                    <!-- Modal -->
                    <div class="text-start modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <form id="js-form-cancel" action="{{ route('order.cancel', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label">{{ __('reason' )}}</label>
                                            <textarea class="form-control" id="reason" name="reason" required rows="3" placeholder="{{ __('enter reason') }}"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-danger">{{ __('cancel order') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($order->order_status_id == config('orderstatus.delivered') || $order->order_status_id == config('orderstatus.cancelled'))
                <form action="{{ route('order.reOrder', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">{{ __('re-order') }}</button>
                </form>
            @endif
        </div>
    </div>
@endsection
