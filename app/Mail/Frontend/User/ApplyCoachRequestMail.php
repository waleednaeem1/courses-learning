<?php

namespace App\Mail\Frontend\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplyCoachRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
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
        $subject = 'Coach Assigning Request';
        // return $this->to('brian@colourfulcpd.com')
        // ->bcc(['waleed.gmit@gmail.com'])
        return $this->to('waleed.gmit@gmail.com')
            ->view('frontend.course.coach-assign-email',['data' => $this->data])
            ->subject($subject)
            ->from('no-reply@colorfulce.com', 'Colorful CE');

    }
}