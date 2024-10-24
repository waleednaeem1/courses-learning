<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Storage;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */


    
    public function store(Request $request)
    {   
        if($request->otp == null || $request->otp ==''){
            return back()->withErrors(['msg'=> 'OTP code is required.']);
        }
        $request->validate([
            'otp' => 'required',
            'password' => 'required|string|confirmed|min:8',
        ]);
        $userOtpData = DB::table('password_resets')->where(['email'=> $request->email])->first();
        if(strtotime($userOtpData->created_at) < strtotime("-1 minutes") ){
            return back()->withErrors(['msg'=> 'Your OTP code is expired.']);
        }
        if($userOtpData->otp == $request->get('otp')){
            User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
            return redirect('/login')->withErrors(['msg'=> 'Your password has been changed!']);
        }else{
            return back()->withErrors(['msg'=> 'Your OTP code is invalid.']);
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.

        // $updatePassword = DB::table('password_resets')
        //                       ->where([
        //                         'email' => $request->email
        //                       ])
        //                       ->first();
        // if(!$updatePassword ){
        //     return redirect('/login')->withErrors('msg', 'something went wrong!');
        // }
        // $check=Hash::check($request->token,$updatePassword->token);
        //   if(!$check){
        //       return back()->with(['error' => 'Invalid token!']);
        //   }
        //     $user = User::where('email', $request->email)
        //     ->update(['password' => Hash::make($request->password)]);

        //     DB::table('password_resets')->where(['email'=> $request->email])->delete();
        // // $status = Password::reset(
        //     $request->only('email', 'password', 'password_confirmation', 'token'),
        //     function ($user) use ($request) {
        //         $user->forceFill([
        //             'password' => Hash::make($request->password),
        //             'remember_token' => Str::random(60),
        //         ])->save();

        //         event(new PasswordReset($user));
        //     }
        // );

        return redirect('/login')->withErrors(['msg'=> 'Your password has been changed!']);
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        // return $updatePassword == Password::PASSWORD_RESET
        //             ? redirect()->route('login')->with('status', __($updatePassword))
        //             : back()->withInput($request->only('email'))
        //                     ->withErrors(['email' => __($updatePassword)]);
    }
}
