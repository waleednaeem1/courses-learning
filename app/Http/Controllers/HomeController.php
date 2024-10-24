<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\CourseCategory;
use App\Models\CourseEnrollment;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\Contact\SendContact;

class HomeController extends Controller
{
    public function home(){
        $user = auth()->user()->id;
        if(!$user || $user == null){
            return ['success' => false, 'message' => 'User doesn\'t exists'];
        }else{
            // $courseEnrollments = CourseEnrollment::with(['course' => function ($query) {
            //     $query->with(['category' => function ($query) {
            //         $query->select('id', 'slug');
            //     }]);
            // }])->where('user_id', '=', $user)->get();
            $courseEnrollments = CourseEnrollment::with('course')->where('user_id', '=', $user)->get();
            $data['course_list'] = Course::with('getCourseType')->with('getShallowCourseData')->with('enrollments')->where([['status','Y']])->orderBy('created_at', 'ASC')->get(array('id','course_category_id','course_type_id','slug','user_id','title','thumbnail','meta_title','meta_keywords','meta_description','marking_user','prerequisite_courses'));


            if ($courseEnrollments) {
                return view('home',compact('courseEnrollments','data'));
            } else {
                return view('home',compact('courseEnrollments','data'));
            }
        }
    }
    public function privacyPolicy()
    {
        return view('footer.privacypolicy');
    }
    public function cookiePolicy()
    {
        return view('footer.cookiepolicy');
    }

    public function termsOfService()
    {
        return view('footer.termsofservice');
    }
    public function faqs()
    {
        return view('footer.faq');
    }
    public function aboutus()
    {
        return view('footer.aboutus');
    }
    public function contact()
    {
        return view('footer.customersupport');
    }

    public function contactSupport(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // die;
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'enquiry_about' => $request->enquiryAbout,
            'message' => $request->message,
        ];
        $contactData = Contact::create($data);
        try {
            Mail::send(new SendContact($request));
        } catch (\Throwable $th) {

            return response()->json(['error' => $th->getMessage(),], 200);
        }
        return redirect()->back()->with('success', 'Message Sent Successfully.');
    }
}
