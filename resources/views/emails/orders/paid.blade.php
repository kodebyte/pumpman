<x-mail::message>
# {{ __('Payment Successful!') }}

{{ __('Hi, :name!', ['name' => $order->first_name]) }}

{!! __('Thank you! Your payment for order **#:order_number** has been received. Your order status is now <span style="color: red; font-weight: bold;">"Processing"</span> and we will process it for shipping shortly.', ['order_number' => $order->order_number]) !!}

<x-mail::panel>
**{{ __('Order ID') }}:** {{ $order->order_number }}
<br>
**{{ __('Payment Date') }}:** {{ now()->format('d M Y, H:i') }}
</x-mail::panel>

<x-mail::table>
| {{ __('Product') }} | {{ __('Qty') }} | {{ __('Total') }} |
| :------------- | :----------: | :----------- |
@foreach($order->items as $item)
| **{{ $item->product_name }}** <br> <span style="font-size: 12px; color: #888;">{{ $item->variant_name }}</span> | {{ $item->qty }} | Rp {{ number_format($item->subtotal, 0, ',', '.') }} |
@endforeach
</x-mail::table>

<div style="width: 100%;">
<p style="margin-bottom: 0px; padding-bottom:0px">{{ __('Subtotal') }}: Rp {{ number_format($order->total_price - $order->shipping_price - $order->tax_price, 0, ',', '.') }}</p>
<p style="margin-bottom: 0px; padding-bottom:0px">{{ __('Shipping') }}: Rp {{ number_format($order->shipping_price, 0, ',', '.') }}</p>
<p style="margin-bottom: 0px; padding-bottom:0px">{{ __('Tax') }}: Rp {{ number_format($order->tax_price, 0, ',', '.') }}</p>
<p class="text-total">{{ __('TOTAL PAID') }}: <span class="text-red">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></p>
</div>

<div style="border-top: 1px dashed #ddd; margin-top: 25px; padding-top: 20px;">
**{{ __('Will be shipped to') }}:**<br>
{{ $order->first_name }} {{ $order->last_name }}<br>
{{ $order->address }}<br>
{{ $order->city_name }}, {{ $order->province_name }} {{ $order->postal_code }}<br>
{{ __('Phone') }}: {{ $order->phone }}
</div>

<x-mail::button :url="route('home')">
{{ __('Shop Again') }}
</x-mail::button>

{{ __('Thank you for shopping at :app_name.', ['app_name' => config('app.name')]) }}<br>
{{ config('app.name') }}
</x-mail::message>