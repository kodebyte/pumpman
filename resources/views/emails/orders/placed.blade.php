<x-mail::message>
# {{ __('Hi, :name!', ['name' => $order->first_name]) }}

{!!  __('Thank you for shopping. Your order **#:order_number** has been successfully created and is <span class="text-red">awaiting payment</span>.', ['order_number' => $order->order_number])  !!}

<x-mail::panel>
**{{ __('Order ID') }}:** {{ $order->order_number }}
<br>
**{{ __('Date') }}:** {{ $order->created_at->format('d M Y, H:i') }}
</x-mail::panel>

<x-mail::table>
| {{ __('Product') }} | {{ __('Qty') }} | {{ __('Total') }} |
| :------------- | :----------: | :----------- |
@foreach($order->items as $item)
| **{{ $item->product_name }}** <br> <span style="font-size: 12px; color: #888;">{{ $item->variant_name }}</span> | {{ $item->qty }} | Rp {{ number_format($item->subtotal, 0, ',', '.') }} |
@endforeach
</x-mail::table>

<div style="text-align: right; width: 100%;">
<p style="margin-bottom: 0px; padding-bottom: 0px">{{ __('Subtotal') }}: Rp {{ number_format($order->total_price - $order->shipping_price - $order->tax_price, 0, ',', '.') }}</p>
<p style="margin-bottom: 0px; padding-bottom: 0px">{{ __('Shipping') }}: Rp {{ number_format($order->shipping_price, 0, ',', '.') }}</p>
<p style="margin-bottom: 0px; padding-bottom: 0px">{{ __('Tax') }}: Rp {{ number_format($order->tax_price, 0, ',', '.') }}</p>
<p class="text-total">{{ __('TOTAL') }}: <span class="text-red">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></p>
</div>

<x-mail::button :url="URL::signedRoute('checkout.success', ['orderNumber' => $order->order_number])">
{{ __('Pay Now') }}
</x-mail::button>

<div style="border-top: 1px dashed #ddd; margin-top: 25px; padding-top: 20px; padding-bottom: 20px;">
<strong>{{ __('Shipped to') }}:</strong><br>
{{ $order->first_name }} {{ $order->last_name }}<br>
{{ $order->address }}<br>
{{ $order->city_name }}, {{ $order->province_name }} {{ $order->postal_code }}<br>
{{ __('Phone') }}: {{ $order->phone }}
</div>

{{ __('Thank you') }},<br>
{{ config('app.name') }}
</x-mail::message>