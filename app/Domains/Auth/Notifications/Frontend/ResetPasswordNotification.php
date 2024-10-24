<?php

namespace App\Domains\Auth\Notifications\Frontend;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use DB;
/**
 * Class ResetPasswordNotification.
 */
class ResetPasswordNotification extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;
    public $otp;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
        $this->otp = random_int(100000, 999999);

    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {   $resetData = DB::table('password_resets')->where(['email'=> $notifiable->email])->first();
        if($resetData){
            $resetData = DB::table('password_resets')->where(['email'=> $notifiable->email])->update(['otp' => $this->otp,'created_at' => date('Y-m-d H:i:s')]);
        }else{
            DB::table('password_resets')->create([
                'email'=> $notifiable->email,
                'otp' =>$this->otp,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        return (new MailMessage)
            ->subject(__('Reset Password Notification'))
            ->view('frontend.mail.reset-email',['otp' => $this->otp, 'notifiable' => $notifiable])
            ->from('no-reply@colorfulce.com')
            ->action(__('Reset Password'), route('password.update', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()]));
    }
}
