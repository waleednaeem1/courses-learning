<?php

namespace App\Mail\Frontend\App;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class SendAppOrder extends Mailable
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
        return $this->view('frontend.mail.app-order')
            ->subject(__('New App Order'))
            ->from('app@gervetusa.com', 'GerVetUSA Order App')
            ->replyTo('no-reply@gervetusa.com', 'No-Reply');

        /*return $this->to(config('mail.from.address'), config('mail.from.name'))
            ->view('frontend.mail.app-order')
            ->subject(__('Welcome to ' . appName()))
            ->replyTo('no-reply@veterinarysurgicalinstrument.com', 'No-Reply');*/
    }
}
