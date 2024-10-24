<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\Frontend\Auth\UserNeedsVerification;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        $id = (string) $request->route('id');
        $user = User::find($id);
        if (isset($user) && $user != "") {
            if ($user->email_verified_at == "" || $user->email_verified_at == Null) {
                $user->email_verified_at = date("Y-m-d H:i:s");
                $user->save();
                return redirect('/verified');
            }
        }
        // if ($request->user()->hasVerifiedEmail()) {
        //     return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        // }

        // if ($request->user()->markEmailAsVerified()) {
        //     event(new UserNeedsVerification($request->user()));
        // }

        // return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
