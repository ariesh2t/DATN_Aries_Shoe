<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $user;
    protected $orderUrl;
    protected $cart;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $cart, $user)
    {
        $this->order = $order;
        $this->user = $user;
        $this->cart = $cart;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('customers.emails.orders.shipped')
            ->with([
                'user' => $this->user,
                'order' => $this->order,
                'cart' => $this->cart,
            ]);
    }
}
