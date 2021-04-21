@component('mail::message')

# Warning ! Low Stock

<p>This message is sent to you to inform that stock for product </p>
<strong>
{{$product}}
</strong> is low. Please refill the stock.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
