@component('mail::message')

# Warning ! Low Stock

<p>This message is sent to you to inform that stock for product </p>
<strong>
{{$product}}
</strong> is low. Please refill the stock.

{{-- @component('mail::button', ['url' => url()])
Go to App
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
