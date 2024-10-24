<?php

namespace App\Mail\Frontend\Order;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class SendOrderStatus extends Mailable
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
    public function __construct($order_status)
    {
        $this->order = $order_status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->order->email, $this->order->name)
            ->cc('sales@vetonly.com')
            ->cc('mughal@vetonly.com')
            ->view('frontend.mail.order-status')
            ->subject('Your Order Update at ' .  appName())
            ->from('notifications@vetonly.com',  appName())
            ->replyTo('no-reply@vetonly.com', 'No-Reply');
    }
}
