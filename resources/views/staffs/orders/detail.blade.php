@extends('layouts.layoutStaff')

@section('title')
    {{ __('order detail', ['attr' => '']) }}
@endsection

@section('breadcrumb')
<div class="col-6">
    <h1 class="m-0">{{ __('order detail', ['attr' => '#'.$order->id]) }}</h1>
</div>
<nav aria-label="breadcrumb" class="col-6">
    <ol class="breadcrumb justify-content-end">
      <li class="breadcrumb-item"><a href="{{ route('staff') }}">{{ __('home') }}</a></li>
      <li class="breadcrumb-item"><a href="{{ route('staff-orders.index') }}">{{ __('orders') }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ __('order detail', ['attr' => '']) }}</li>
    </ol>
</nav>
@endsection

@section('content')
    <div class="d-flex align-items-center mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('fullname') }}</div>
        <div class="col-6">{{ $order->fullname }}</div>
    </div>

    <div class="d-flex align-items-center mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('phone') }}</div>
        <div class="col-6">{{ $order->phone }}</div>
    </div>

    <div class="d-flex align-items-center mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('address') }}</div>
        <div class="col-6">{{ $order->address }}</div>
    </div>

    <div class="d-flex mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('product info') }}</div>
        <div class="col-10">
            <table class="table table-stripe">
                <thead class="table-dark text-center">
                    <tr>
                        <th></th>
                        <th>{{ __('product name') }}</th>
                        <th style="width: 10%">{{ __('product info') }}</th>
                        <th>{{ __('price') }}</th>
                        <th>{{ __('quantity') }}</th>
                        <th>{{ __('total price') }}</th>
                    </tr>
                </thead>
                <tbody id="list-prinfor">
                    @foreach ($order->products as $product)
                    <tr>
                        <td>
                            <div class="text-center">
                                <img height="50" src="{{ asset('images/products/' . $product->images->first()->name) }}" alt="">
                            </div>
                        </td>
                        <td><div id="desc">{{ $product->name }}</div></td>
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
                        <td class="text-center">{{ @money($product->promotion) }}</td>
                        <td class="text-center">{{ $product->pivot->quantity }}</td>
                        <td class="text-center">{{ @money($product->promotion * $product->pivot->quantity) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-right font-weight-bold">{{ __('total') }}</td>
                    <td class="text-center">{{ @money($order->total_price) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex align-items-center mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('delivery charges') }}</div>
        <div class="col-6">{{ @money($order->shipping) }}</div>
    </div>

    <div class="d-flex align-items-center mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('total payment') }}</div>
        <div class="col-6 text-danger" style="font-size: 24px">{{ @money($order->order_price) }}</div>
    </div>

    <div class="d-flex align-items-center mb-3">
        <div class="col-2 me-5 text-danger text-end">{{ __('created at') }}</div>
        <div class="col-6">{{ $order->created_at }}</div>
    </div>

    @if ($order->order_status_id != config('orderstatus.cancelled') && $order->order_status_id != config('orderstatus.delivered'))
            <form class="d-flex mb-3 align-items-center" action="{{ route('staff-orders.update', $order->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="col-2 me-5 text-danger text-end">{{ __('status') }}</div>
                <div class="col-6">
                    <select class="form-control" name="status">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" {{ $status->id == $order->order_status_id ? "selected" : '' }}>{{ __($status->status) }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <small class="text-danger fst-italic">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">{{ __('save') }}</button>
            </form>
    @else
        <div class="d-flex align-items-center mb-3">
            <div class="col-2 me-5 text-danger text-end">{{ __('status') }}</div>
            <div class="col-6">
                @switch($order->orderStatus->id)
                    @case(config('orderstatus.delivered'))
                        <span class="badge bg-success">{{ Str::ucfirst(__($order->orderStatus->status)) }}</span>
                        @break
                    @case(config('orderstatus.cancelled'))
                        <span class="badge bg-secondary">{{ Str::ucfirst(__($order->orderStatus->status)) }}</span>
                        @break
                @endswitch
            </div>
        </div>
        @if ($order->order_status_id == config('orderstatus.cancelled'))
            <div class="d-flex align-items-center mb-3">
                <div class="col-2 me-5 text-danger text-end">{{ __('reason') }}</div>
                <div class="col-10">{{ __($order->reason) }}</div>
            </div>
        @endif
    @endif
    
@endsection
