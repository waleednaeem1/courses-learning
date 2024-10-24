<?php

namespace App\Mail\Frontend;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;


    public $details;
    public $request;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $request)
    {
        $this->details = $details;
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->request->vendor_type == 2){
            $subject = 'Become a DVM CENTRAL Service Provider';
        }else{
            $subject = 'Become a DVM CENTRAL Seller';
        }
        return $this->to($this->details['email'])
            // ->cc(['ycou@vetandtech.com', 'vallinir@vetandtech.com','mughal@germedusa.com','farhan@germedusa.com','waleed.gmit@gmail.com'])
            // ->cc(['waleed.gmit@gmail.com'])
            ->view('frontend.vendor.email')
            ->subject($subject)
            ->from('no-reply@dvmcentral.com', 'DVM Central')
            ->replyTo($this->details['email'], $this->details['name']);

    }
}