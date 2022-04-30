@extends('layouts.layoutAdmin')

@section('title')
    {{ __('order detail') }}
@endsection

@section('content')
    <div class="mb-3 col-6">
        <strong>{{ __('fullname') }}</strong>
        <p>{{ $order->fullname }}</p>
    </div>

    <div class="mb-3 col-6">
        <strong>{{ __('phone') }}</strong>
        <p>{{ $order->phone }}</p>
    </div>

    <div class="mb-3 col-6">
        <strong>{{ __('address') }}</strong>
        <p>{{ $order->address }}</p>
    </div>

    <div class="mb-3 col-12">
        <strong>{{ __('list') . __('product') }}</strong>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>{{ __('product name') }}</th>
                    <th>{{ __('product info') }}</th>
                    <th class="text-center">{{ __('price') }}</th>
                    <th class="text-center">{{ __('quantity') }}</th>
                    <th class="text-center">{{ __('total price') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $product)
                    <tr>
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
                        <td class="text-center">{{ @money($product->price) }}</td>
                        <td class="text-center">{{ $product->pivot->quantity }}</td>
                        <td class="text-center">{{ @money($product->price * $product->pivot->quantity) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="mb-3 col-6">
        <strong>{{ __('total') }}</strong>
        <p>{{ @money($order->total_price) }}</p>
    </div>

    @if ($order->order_status_id != config('orderstatus.cancelled') && $order->order_status_id != config('orderstatus.delivered'))
        <div class="mb-3 col-6">
            <form action="{{ route('orders.update', $order->id) }}" method="post">
                @csrf
                @method('PATCH')
                <strong>{{ __('status') }}</strong>
                <div>
                    <select class="form-control" name="status">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" {{ $status->id == $order->order_status_id ? "selected" : '' }}>{{ __($status->status) }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <small class="text-danger fst-italic">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="mt-3 btn btn-success">{{ __('save') }}</button>
            </form>
        </div>
    @else
        <div class="mb-3 col-6">
            <strong>{{ __('status') }}</strong>
            <p>
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
            </p>
        </div>
    @endif
    
@endsection
