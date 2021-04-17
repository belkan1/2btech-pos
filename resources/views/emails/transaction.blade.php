@component('mail::message')
# Transaction Report

Order #: {{$transaction->id}}<br>
Payment Method: {{$transaction->payment_method->name}}


# Order Summary


@foreach($transaction->details as $trans  )
<strong>{{$trans->product->name}}      x{{$trans->quantity}} {{$trans->price}} {{$trans->subtotal}}</strong><br>
@endforeach

Total: {{$transaction->total}}<br>
Total VAT: {{$transaction->total}}<br>
Amount Paid: {{$transaction->bayar}}<br>
Change: {{$transaction->kembalian}}<br>

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
