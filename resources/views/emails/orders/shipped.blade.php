@component('mail::message')
# {{ __('Hooray! Your Package is on Its Way 🚚') }}

{{ __('Hello **:name**', ['name' => $order->first_name]) }},

{{ __('Good news! Your order **#:order_number** has been handed over to the courier and is on its way to your address.', ['order_number' => $order->order_number]) }}

**{{ __('Shipping Details') }}:**
@component('mail::panel')
**{{ __('Courier') }}:** {{ $order->courier->name ?? __('Courier') }}  
**{{ __('Tracking Number') }}:** {{ $order->tracking_number }}
@endcomponent

{{ __('Please click the button below to track your package in real-time:') }}

@php
    $trackingLink = $order->courier 
        ? $order->courier->getTrackingLink($order->tracking_number)
        : 'https://www.google.com/search?q=cek+resi+' . $order->tracking_number;
@endphp

@component('mail::button', ['url' => $trackingLink, 'color' => 'success'])
{{ __('Track My Package') }}
@endcomponent

{{ __('If the package cannot be tracked yet, please wait 1x24 hours for the tracking data to be updated in the courier\'s system.') }}

{{ __('Thank you for shopping at **Aiwa Indonesia**.') }}

{{ __('Warm regards') }},<br>
{{ config('app.name') }}
@endcomponent