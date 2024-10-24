<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;
use Closure;
use App\Domains\Auth\Notifications\Frontend\ResetPasswordNotification;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */

    public function create()
    {
        return view('auth.forgot-password');
    }

    public function resetWithOtp(){
        return view('auth.save-password');
    }
    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if(!$user){
           return redirect()->back()->withErrors(['msg'=>  'This email does not exists']);
        }
;
        // $updatePassword = DB::table('password_resets')
        // ->where([
        //   'email' => $request->email
        // ])
        // ->first();
        // if($updatePassword){
        //     $updatePassword->email =  $request->email; 
        //     $updatePassword->token  = $token; 
        //     $updatePassword->created_at = Carbon::now();
        // }else{
        //     DB::table('password_resets')->insert([
        //         'email' => $request->email, 
        //         'token' => $token, 
        //         'created_at' => Carbon::now()
        //     ]);
        // }
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink($request->only('email'));

        // return back()->withErrors(['message' => 'Please check your email for password reset link']);
        return $status == Password::RESET_LINK_SENT
                    ? redirect('/save-password/'.$request->email)->withInput($request->only('email'))->withErrors(['msg'=>  'Please check your email for password reset code'])
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
    public function sendResetLink(array $credentials, Closure $callback = null)
    {
        // First we will check to see if we found a user at the given credentials and
        // if we did not we will redirect back to this current URI with a piece of
        // "flash" data in the session to indicate to the developers the errors.
        $user = $this->getUser($credentials);

        if (is_null($user)) {
            return static::INVALID_USER;
        }

        if ($this->tokens->recentlyCreatedToken($user)) {
            // return static::RESET_THROTTLED;
        }

        $token = $this->tokens->create($user);

        if ($callback) {
            $callback($user, $token);
        } else {
            // Once we have the reset token, we are ready to send the message out to this
            // user with a link to reset their password. We will then redirect back to
            // the current URI having nothing set in the session to indicate errors.
            $user->sendPasswordResetNotification($token);
        }

        return static::RESET_LINK_SENT;
    }
    public function sendPasswordResetNotification($token,$user )
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function resend(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        $token =null;

        $user->notify(new ResetPasswordNotification($token));
        return back()->withErrors(['msg' => 'We have resent you reset password code. Please check your email and retry!']); 
        
    }
}
