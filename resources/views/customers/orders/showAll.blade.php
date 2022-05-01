@extends('layouts.layoutCustomer')

@section('title')
    {{ __('list') . __('orders') }}
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center bg-dark py-4 fs-5 mb-3">
        <div class="ps-3">
            <a class="text-white" href="{{ url()->previous() }}" title="{{ __('back') }}">
                <i class="fa-solid fa-chevron-left"></i> {{ __('back') }}
            </a>
        </div>
        <div class="text-uppercase fs-2 text-white">{{ __('my purchase') }}</div>
        <div></div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('code') }}</th>
                        <th>{{ __('address') }}</th>
                        <th class="text-center">{{ __('phone') }}</th>
                        <th class="text-center">{{ __('number product') }}</th>
                        <th class="text-center">{{ __('total price') }}</th>
                        <th class="text-center">{{ __('status') }}</th>
                        <th class="text-center">{{ __('last update') }}</th>
                        <th class="w-10 text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="text-center">#{{ $order->id }}</td>
                            <td>{{ $order->address }}</td>
                            <td class="text-center">{{ $order->phone }}</td>
                            <td class="text-center">{{ $order->products->count() }}</td>
                            <td class="text-center">{{ @money($order->order_price) }}</td>
                            <td class="text-center">
                                @switch($order->orderStatus->id)
                                    @case(config('orderstatus.waiting'))
                                        <span class="badge bg-primary">{{ Str::ucfirst(__($order->orderStatus->status)) }}</span>
                                        @break
                                    @case(config('orderstatus.delivered'))
                                        <span class="badge bg-success">{{ Str::ucfirst(__($order->orderStatus->status)) }}</span>
                                        @break
                                    @case(config('orderstatus.cancelled'))
                                        <span class="badge bg-secondary">{{ Str::ucfirst(__($order->orderStatus->status)) }}</span>
                                        @break
                                    @default
                                        <span class="badge bg-warning">{{ Str::ucfirst(__($order->orderStatus->status)) }}</span>
                                @endswitch
                            </td>
                            <td class="text-center">
                                {{ $order->updated_at }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('order.detail', $order->id) }}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center mt-5">
        {!! $orders->appends(request()->all())->links('partials.paginate') !!}
    </div>
@endsection()
