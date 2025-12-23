@component('mail::message')
# {{ __('Thank You') }}, {{ $order->first_name }}!

{{ __('Your order **#:order_number** has been successfully received. Here are your order details:', ['order_number' => $order->order_number]) }}

**{{ __('Shipping Information') }}:**<br>
{{ $order->first_name }} {{ $order->last_name }}<br>
{{ $order->address }}<br>
{{ $order->city_name }}, {{ $order->province_name }} {{ $order->postal_code }}<br>
{{ __('Phone') }}: {{ $order->phone }}

@component('mail::table')
| {{ __('Product') }} | {{ __('Qty') }} | {{ __('Price') }} |
| :--- | :---: | ---: |
@foreach($order->items as $item)
| {{ $item->product_name }} <br><small>{{ $item->variant_name ?? '' }}</small> | {{ $item->quantity }} | Rp {{ number_format($item->price, 0, ',', '.') }} |
@endforeach
| **{{ __('Total') }}** | | **Rp {{ number_format($order->total_price, 0, ',', '.') }}** |
@endcomponent

@component('mail::button', ['url' => route('orders.show', $order->id), 'color' => 'red'])
{{ __('View Order Status') }}
@endcomponent

{{ __('If you have any questions regarding warranty claims, please contact our support team via the FAQ page.') }}

{{ __('Warm regards') }},<br>
**Aiwa Indonesia**
@endcomponent