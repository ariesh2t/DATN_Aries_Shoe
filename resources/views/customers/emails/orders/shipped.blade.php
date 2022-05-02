@component('mail::message')
<h3>Notification</h3>

<h2 style="text-align: center">{{ __('thanks order') }}</h2>
<div>
    <p style="font-size: 16px">Hello, {{ $user->fullname }}</p>
    <p>{{ __('receive require') }}</p>
</div>

@component('mail::table')
|               | {{ __('product name') }} | {{ __('m_price') }}    | {{ __('product info') }} | {{ __('quantity') }}  |  {{ __('total price') }}     |
| :------------ |:--------------| :--------| :--------| :---------| :-----------|
@foreach ($cart->items as $item)
|<img width="50" src="{{ asset('images/products/'. $item['image']) }}">| {{ $item['name'] }}| {{ @money($item['price']) }}| {{ __('color') . ": " . $item['color'] . ", " . __('size') . ": " . $item['size'] }} | {{ $item['quantity'] }} |{{ @money($item['price']*$item['quantity']) }}
@endforeach
@endcomponent

@component('mail::panel')
<div>
    {{ __('total') }}: {{ $order->total_price }}
</div>
<div>
    {{ __('delivery charges') }}: {{ $order->shipping }}
</div>
<div>
    {{ __('total payment') }}: {{ $order->order_price }}
</div>
@endcomponent

<div>
    <p>{{ __('note email') }}</p>
</div>

@component('mail::button', ['url' => route('order.detail', $order->id), 'color' => 'success'])
{{ __('show order status') }}
@endcomponent

Thanks,<br>
Aries Shoe
@endcomponent
