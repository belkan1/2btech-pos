<?php

namespace App\Mail;

use App\Model\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $transaction;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderId)
    {
        // $myOrder = Transaction::find($orderId);
        $myOrder = Transaction::find($orderId);
        $this->transaction = Transaction::with(['details.product','customer','payment_method'])
                                ->where('invoice',$myOrder->invoice)
                                ->orderBy('id','desc')->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invoice for Shopping')->markdown('emails.transaction',['transaction'=> $this->transaction]);
    }
}
