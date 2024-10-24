<?php

namespace App\Mail\Frontend\Order;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class SendOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Request
     */
    public $order;

    /**
     * SendContact constructor.
     *
     * @param Request $request
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->order->email, $this->order->first_name . ' ' . $this->order->last_name)
            ->cc('orders@dvmcentral.com')
            ->view('frontend.mail.order')
            ->subject('Your Order Details at ' . appName())
            ->from(config('mail.from.address'), appName())
            ->replyTo('no-reply@dvmcentral.com', 'No-Reply');
    }
}
