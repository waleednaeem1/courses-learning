<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserPractice;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class PracticeController extends Controller
{
    public function practice()
    {
        $data['practice'] = UserPractice::where('user_id',  auth()->user()->id)->first();
        $data['country'] = Country::all()->pluck('name','id');
         $data['states'] =$data['practice']? State::where('id',$data['practice']->postal_state)->pluck('name','id'): State::pluck('name','id');
        return view('dashboards.practice', compact('data'));
    }

    public function myPractice()
    {
        $practice = UserPractice::where('user_id',  auth()->user()->id)->first();
        if(isset($practice) && $practice->postal_state !== '' && $practice->postal_country !== ''){
            $state = State::where('id',$practice->postal_state)->pluck('name','id');
            $country = Country::where('id',$practice->postal_country)->pluck('name','id');
            $practice->postal_state = $state[$practice->postal_state];
            $practice->postal_country = $country[$practice->postal_country];
        }
        return view('dashboards.myPractice', compact('practice'));
    }

    public function updatePractice(Request $request)
    {
        $practice = UserPractice::where('user_id',  auth()->user()->id)->first();
        if(!$practice){
            $practice = new UserPractice([
                'user_id' => auth()->user()->id,
            ]);
            $practice->save();
        }
        $userData = User::find(auth()->user()->id);
        if($userData){
            User::where('id', auth()->user()->id)->update(['register_from_colorful' => 1]);
        }
        if($practice)
        {
            if(isset($request->type)){
                $practice->type = $request->type;
            }
            if($request->practice_name){
                $practice->practice_name = $request->practice_name;
            }
    
            if($request->phone){
                $practice->phone = $request->phone;
            }
            if($request->website){
                $practice->website = $request->website;
            }
            if($request->practice_type){
                $practice->practice_type = $request->practice_type;
            }
            if($request->animals_treated){
                $practice->animals_treated = $request->animals_treated;
            }
            if($request->postal_address){
                $practice->postal_address = $request->postal_address;
            }
            if($request->postal_address_line_one){
                $practice->postal_address_line_one = $request->postal_address_line_one;
            }
            if($request->postal_address_line_two){
                $practice->postal_address_line_two = $request->postal_address_line_two;
            }
            if($request->postal_address_line_three){
                $practice->postal_address_line_three = $request->postal_address_line_three;
            }
            if($request->postal_address_line_four){
                $practice->postal_address_line_four = $request->postal_address_line_four;
            }
            if($request->postal_city){
                $practice->postal_city = $request->postal_city;
            }
            if($request->postal_country){
                $practice->postal_country = $request->postal_country;
            }
            if($request->postal_state){
                $practice->postal_state = $request->postal_state;
            }
            if($request->postal_post_code){
                $practice->postal_post_code = $request->postal_post_code;
            }
            if($request->billing_address){
                $practice->billing_address = $request->billing_address;
            }
            if($request->billing_address_line_one){
                $practice->billing_address_line_one = $request->billing_address_line_one;
            }
            if($request->billing_address_line_two){
                $practice->billing_address_line_two = $request->billing_address_line_two;
            }
            if($request->billing_address_line_three){
                $practice->billing_address_line_three = $request->billing_address_line_three;
            }
            if($request->billing_address_line_four){
                $practice->billing_address_line_four = $request->billing_address_line_four;
            }
            if($request->billing_city){
                $practice->billing_city = $request->billing_city;
            }
            if($request->billing_country){
                $practice->billing_country = $request->billing_country;
            }
            if($request->billing_state){
                $practice->billing_state = $request->billing_state;
            }
            if($request->billing_post_code){
                $practice->billing_post_code = $request->billing_post_code;
            }
            $practice->save();
            return redirect()->back()->with('success', 'Practice updated successfully');
        }
        else{
            return redirect()->back()->with('error', 'Practice not updated');
        }
    }
}