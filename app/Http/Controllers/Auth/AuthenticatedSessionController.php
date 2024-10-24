<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
// use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if(auth()->user()){
            return view('home');
        }
        else{
            return view('auth.login');
        }
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();
        if(isset($user) && $user->soft_delete == 1){
            return back()->withErrors(['msg' => 'The account has been deleted. To activate your account, please contact the administrator on this email info@vtfriends.com.']);
        }
        if(isset($user) && $user->active == 0){
            return back()->withErrors(['msg' => 'The account has been deactivated. To activate your account, please contact the administrator on this email info@vtfriends.com']);
        }
        $checkForBoth = User::where('email', $request->email)->where(['allow_on_dvm' => '1', 'allow_on_vetandtech' => '1','allow_on_vt_friend' => 0 ])->first();
        if($checkForBoth){
            return back()->withInput()->withErrors(['msg' => 'You have an account with us on DVM Central and Vet and Tech. Would you like to use the same account at VT Friends?', 'allow' => 'true']);
        }
        $checkForVetandtech = User::where('email', $request->email)->where(['allow_on_dvm' => '0' ,'allow_on_vetandtech' => '1' ,'allow_on_vt_friend' => 0])->first();
        if($checkForVetandtech){
            return back()->withInput($request->all())->withErrors(['msg' => 'You have an account with us on Vet and Tech. Would you like to use the same account at VT Friends?', 'allow' => 'true']);
        }
        $checkForDvmCentral = User::where('email', $request->email)->where(['allow_on_dvm' => '1', 'allow_on_vetandtech' => '0','allow_on_vt_friend' => 0 ])->first();
        if($checkForDvmCentral){
            $error = 'You have an account with us on DVM Central. Would you like to use the same account at VT Friends?';
            return back()->withInput($request->all())->withErrors(['msg' => $error, 'allow' => 'true']);
        }
        if(!$user){
            return back()->withErrors(['msg' => 'This email does not exists']);
        }
        if($user->email_verified_at == null || $user->email_verified_at =='') {
            (new User())->verificationEmail($user);
            return back()->withErrors(['msg' => 'Your email is not verified, we have resent you verification email. Please check your email and verify!']);
        }
        if(! Hash::check($request->password,$user->password)){
            return back()->withInput()->withErrors(['msg' => 'Please enter the correct password and try again.']);
        }
        if($request->has('remember_me')){
            Cookie::queue(Cookie::make('adminuser', $request->email, 1440));
            Cookie::queue(Cookie::make('adminpwd', $request->password, 1440));
        }else{
            Cookie::queue(Cookie::forget('adminuser'));
            Cookie::queue(Cookie::forget('adminpwd'));
        }
        $request->authenticate();
        $request->session()->regenerate();
        return redirect(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
