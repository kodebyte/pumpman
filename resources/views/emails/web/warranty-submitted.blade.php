@component('mail::message')
# {{ __('AIWA SUPPORT') }}

{{ __('Hello') }} **{{ $claim->customer_name }}**,

{{ __('Thank you for contacting Aiwa Indonesia After-Sales Service. Your warranty claim request has been received and is in the verification queue.') }}

@component('mail::panel')
**{{ __('Your Ticket Code') }}:** # {{ $claim->claim_code }}
@endcomponent

{{ __('Save the ticket code above to check the repair status periodically.') }}

@component('mail::table')
| {{ __('Information') }} | {{ __('Details') }} |
| :--- | :--- |
| **{{ __('Product') }}** | {{ $claim->product->name ?? 'Unknown' }} |
| **{{ __('Serial Number (SN)') }}** | {{ $claim->serial_number }} |
| **{{ __('Purchase Date') }}** | {{ $claim->purchase_date->format('d M Y') }} |
| **{{ __('Issue') }}** | {{ $claim->description }} |
@endcomponent

{{ __('Please wait 1x24 working hours. Our team will contact you via WhatsApp/Email regarding unit shipping instructions if the claim is approved.') }}

@component('mail::button', ['url' => route('home')])
{{ __('Visit Website') }}
@endcomponent

{{ __('Warm regards') }},<br>
**Aiwa Indonesia**
@endcomponent