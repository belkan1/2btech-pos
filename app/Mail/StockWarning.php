<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StockWarning extends Mailable
{
    use Queueable, SerializesModels;

    protected $product;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return 
     */
    public function build()
    {
        return $this->subject('Low Stock Warning!')
        ->markdown('emails.stockwarning',['product'=>$this->product]);
    }
}
