<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
/**
 * Class SendContact.
 */
class ResetEmailVTFriends extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Request
     */
    public $request;

    /**
     * SendContact constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this->to($this->request->email)
            ->view('frontend.mail.reset-email-vtf',['token' => $this->request->otp, 'email' => $this->request->email])
            ->from('no-reply@colorfulce.com')
            ->subject(__('Reset Password Notification'));
    }
    // public function build()
    // {
    //     return $this->to($this->request->email, 'DVM Central')
    //         ->view('frontend.mail.reset-email')
    //         ->subject(__('Reset Password Notification'))
    //         ->line(__('You are receiving this email because we received a password reset request for your account.'))
    //         ->action(__('Reset Password'), route('frontend.auth.password.reset', ['token' => $this->token, 'email' => $this->request->email]))
    //         ->line(__('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
    //         ->line(__('If you did not request a password reset, no further action is required.'));
    // }
}