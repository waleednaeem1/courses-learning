<?php

namespace App\Mail\Frontend\App;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class SendGiveawayWinnerNotification extends Mailable
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
        return $this->view('frontend.mail.winner-notification')
            ->subject(__('Here is the lucky winner of a Random Draw for Our Grand Giveaway.'))
            ->replyTo('melissaa@gervetusa.com', 'Melissa A');
    }
}
