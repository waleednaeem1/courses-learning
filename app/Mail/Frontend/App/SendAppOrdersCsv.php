<?php

namespace App\Mail\Frontend\App;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class SendAppOrdersCsv extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Request
     */
    public $file_path;

    /**
     * SendContact constructor.
     *
     * @param Request $request
     */
    public function __construct($file_path)
    {
        $this->file_path = $file_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('frontend.mail.app-order-csv')
            ->subject(__('App Orders of ' . date('M d, Y')))
            ->attach($this->file_path)
            ->replyTo('no-reply@gervetusa.com', 'No-Reply');

        /*return $this->to(config('mail.from.address'), config('mail.from.name'))
            ->view('frontend.mail.app-order')
            ->subject(__('Welcome to ' . appName()))
            ->replyTo('no-reply@veterinarysurgicalinstrument.com', 'No-Reply');*/
    }
}
