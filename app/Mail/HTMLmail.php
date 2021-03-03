<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HTMLmail extends Mailable
{
    use Queueable, SerializesModels;

    public $cartProducts;
    public $inputs;

    /**
     * Create a new message instance.
     *
     * @param $cartProducts
     * @param $inputs
     */
    public function __construct($cartProducts, $inputs)
    {
        $this->cartProducts = $cartProducts;
        $this->inputs = $inputs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.html_order');
    }
}
