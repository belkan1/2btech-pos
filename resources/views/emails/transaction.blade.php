@component('mail::message')
# Transaction Report

Order #: {{$transaction->id}}<br>
Payment Method: {{$transaction->payment_method->name}}


# Order Summary

<table>
@foreach($transaction->details as $trans  )
<td>
    <td>{{$trans->product->name}}</td>
    <td>x{{$trans->quantity}}</td>
    <td>{{$trans->price}}</td>
    <td>{{$trans->subtotal}}</td>
</tr>
        
@endforeach
</table>

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
