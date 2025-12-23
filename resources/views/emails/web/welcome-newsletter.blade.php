@component('mail::message')
# {{ __('WELCOME TO THE CIRCLE.') }}

{{ __('Thank you for subscribing. You are now part of the exclusive Aiwa community. Get priority access to latest product launches, member-only promos, and the latest audio technology insights.') }}

@component('mail::button', ['url' => route('home'), 'color' => 'red'])
{{ __('Explore Products') }}
@endcomponent

---

### {{ __('Premium Audio') }}
{{ __('Feel the legendary bass with crystal clarity.') }}

@component('mail::button', ['url' => route('products.index'), 'color' => 'red'])
{{ __('Shop Audio') }}
@endcomponent

---

### {{ __('Visual Series') }}
{{ __('4K HDR TV with Japanese screen technology.') }}

@component('mail::button', ['url' => route('products.index'), 'color' => 'red'])
{{ __('Shop Visual') }}
@endcomponent

{{ __('Warm regards') }},<br>
**Aiwa Indonesia**

@slot('footer')
@component('mail::footer')
© {{ date('Y') }} Aiwa Indonesia. {{ __('Japanese Engineering Since 1951.') }}  
Jakarta, Indonesia.  
[Unsubscribe]({{ '#' }})
@endcomponent
@endslot
@endcomponent