<?php

namespace App\Mail\Frontend\Order;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class SendFormSubmission extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Request
     */
    public $data;

    /**
     * SendContact constructor.
     *
     * @param Request $request
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to('sales@gervetusa.com', 'Sales')
            ->cc('mughal@germedusa.com')
            ->bcc('farhan@germedusa.com')
            ->view('frontend.mail.form-request-demo')
            ->subject('Request for Demo at ' . appName())
            ->from('notifications@gervetusa.com', appName())
            ->replyTo('no-reply@gervetusa.com', 'No-Reply');
    }
}
