<?php

namespace App\Mail\Frontend\Newsletter;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class SendSubscriptionWithCoupon extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Request
     */
    public $data;
    public $type;

    /**
     * SendContact constructor.
     *
     * @param Request $request
     */
    public function __construct($data, $type)
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->type == 'vetandtech'){
            return $this->to($this->data['email'], $this->data['name'])
                //->cc('farhanasim@gmail.com')
                ->view('frontend.mail.subscription-discount-coupon')
                ->subject('Here is your 10% Discount Coupon from Vet and Tech' )
                ->from('no-reply@vetandtech.com')
                ->replyTo('no-reply@vetandtech.com', 'No-Reply');
        }else{
            return $this->to($this->data['email'], $this->data['name'])
                //->cc('farhanasim@gmail.com')
                ->view('frontend.mail.subscription-discount-coupon-dvm')
                ->subject('Here is your 10% Discount Coupon from DVM Central')
                ->from('no-reply@dvmcentral.com')
                ->replyTo('no-reply@dvmcentral.com', 'No-Reply');
        }
    }
}