<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CoursePayment;
use App\Models\Customer;
use App\Models\CourseCategory;
use App\Models\CartItem;
use App\Models\ShallowCourse;
use App\Models\ShallowCourseModule;
use App\Models\ShallowCourseModuleSection;
use App\Models\ShallowCourseModuleSectionEexercise;
use App\Models\CourseModuleSection;
use App\Models\CourseModuleSectionEexercise;
use App\Models\CourseModule;
use App\Models\QuizQuestion;
use App\Models\ShallowQuizQuestion;
use App\Models\QuizAnswer;
use App\Models\Coupon;
use App\Models\User;
use App\Models\ShallowQuizAnswer;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;

class CoursesCartController extends Controller
{
    public function index($userId)
    {
        $id = $userId;
        try
        {
            $user_cart_items = CartItem::where([['customer_id', $id], ['type' , 'course']])->get();
            $data =[];
            foreach($user_cart_items as $key => $item)
            {
                if(isset($item) && $item != ''){
                    $data[$key] = Course::find($item->course_id, ['id', 'title' ,'price' , 'price_original', 'thumbnail','slug','course_category_id']);
                    if(isset($data[$key])){
                        $data['category'] = CourseCategory::where('id', $data[$key]->course_category_id)->get();
                        $data[$key]->courseCategoryId = $data['category'][0]->slug;
                        if($data[$key] !== null)
                        {
                            $data[$key]->quantity =$item->quantity;
                            $data[$key]->cart_item_id =$item->id;
                        }
                    }
                }
            }
            return response()->json([
                'data' => $data,
                'user_cart_items' => $user_cart_items, 
                'success' => true
            ], 200);
        } 
        catch (\Throwable $th) 
        {
            return response()->json(['success' => false,'message' =>$th->getMessage(), 'line' => $th->getLine()],201);
        }  
    }

    public function deleteCartItems(Request $request)
    { 
        try{
            if($request->cart_item){
                $user_cart_item = CartItem::find($request->cart_item);
                if($user_cart_item){
                    $user_cart_item->delete();
                    return ['success' => true, 'type' => 'course','message' => 'Course deleted from the cart successfully'];
                }else{
                    return ['success' => false, 'type' => $request->type,'message' => 'Course does not exists in the cart.'];
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['success' => false,'message' =>$th->getMessage(), 'line' => $th->getLine()],201);
        }
    }

    public function purchaseCourse(Request $request)
    {   
        $user = User::find($request->userId);
        
        $explodedArray = explode('/',$request->expiryDate);
        try {
            $user = User::find($request->userId);
            if($user){
                $courses =[];
                if(count($user->cartItems) > 0){
                    foreach($user->cartItems as $key => $cart_item){
                        $courses[$key]= Course::find($cart_item->course_id, ['*']);
                    }
                    $amount = 0;
                    if($courses > 0 && $courses != null){
                        foreach($courses as $cart){
                            $amount += $cart['price_original'];
                        }
                        Stripe::setApiKey(config('app.STRIPE_SECRET'));
                        $token = Stripe::tokens()->create([
                            'card' => [
                                'number'    => $request->input('cardNumber'),
                                'exp_month' => $explodedArray[0],
                                'cvc'       => $request->input('cvc'),
                                'exp_year'  => $explodedArray[1],
                            ],
                        ]);
                        if(isset($request->totalCartPriceToPay) && $request->totalCartPriceToPay != null){
                            $amount = $request->totalCartPriceToPay;
                        }
                        $charge = Stripe::charges()->create([
                            'source' => $token['id'],
                            'currency' => 'USD',
                            'amount' => round($amount, 2),
                            'metadata' => [
                                'name' => $user->first_name,
                                'email' => $user->email,
                                'phone' => $user->phone
                            ]
                        ]);
                        if($charge['status'] == 'succeeded')
                        {
                            $data['customer_id']        = $user->id;
                            $data['title']              = 'Paid $'.number_format($amount, 2).' for the purchase of course.';
                            $data['amount']             = $amount;
                            $data['card_number']        = $charge['source']['last4'];
                            $data['card_type']          = $charge['source']['brand'];
                            $data['transaction_id']     = $charge['id']; // First Data's Transaction Tag
                            $data['balance_transaction'] = $charge['balance_transaction']; // First Data's Authorization Number
                            $data['payment_method']     = $charge['payment_method']; // Our own generated number for cross reference at First Data
                            $data['receipt_url']        = $charge['receipt_url']; // First Data Returns CTR - Response so saving that
                            $data['card_holder_name']   = $request->cardHolder;
                            $course_payment = CoursePayment::create($data);

                            foreach($courses as $course_cart)
                            {
                                CourseEnrollment::create(['course_id' => $course_cart['id'], 'user_id' => $user->id, 'amount' => $course_cart['price_original'], 'course_payment_id' => $course_payment->id]);
                            }
                            foreach($courses as $shallowCourse){
                                $shallowCourseData = [
                                    'course_category_id' => $shallowCourse->course_category_id,
                                    'parent_course_id' => $shallowCourse->id,
                                    'purchased_user_id' => $user->id,
                                    'course_type_id' => $shallowCourse->course_type_id,
                                    'title' => $shallowCourse->title,
                                    'short_description' => $shallowCourse->short_description,
                                    'description' => $shallowCourse->description,
                                    'price' => $shallowCourse->price,
                                    'price_original' => $shallowCourse->price_original,
                                    'price_placeholder' => $shallowCourse->price_placeholder,
                                    'discount_start_time' => $shallowCourse->discount_start_time,
                                    'discount_end_time' => $shallowCourse->discount_end_time,
                                    'thumbnail' => $shallowCourse->thumbnail,
                                    'is_24_7_support_service' => $shallowCourse->is_24_7_support_service,
                                    'is_videos' => $shallowCourse->is_videos,
                                    'general_guidance' => $shallowCourse->general_guidance,
                                    'is_practice_questions' => $shallowCourse->is_practice_questions,
                                    'slug' => $shallowCourse->slug,
                                    'marking_user' => $shallowCourse->marking_user,
                                    'meta_title' => $shallowCourse->meta_title,
                                    'meta_keywords' => $shallowCourse->meta_keywords,
                                    'meta_description' => $shallowCourse->meta_description,
                                    'status' => $shallowCourse->status,
                                ];
                                $newshallowCourse = ShallowCourse::create($shallowCourseData);
                                if(isset($newshallowCourse))
                                {
                                    $getModules = CourseModule::where(['course_id'=> $newshallowCourse->parent_course_id,'status' => 'Y'])->get();
                                    if(isset($getModules) && count($getModules) > 0){
                                        foreach($getModules as $newShallowModule){
                                            $index = 1;
                                            $shallowCourseModuleData = [
                                                'parent_course_module_id' => $newShallowModule->id,
                                                'purchased_user_id' => $user->id,
                                                'course_id' => $newshallowCourse->id,
                                                'parent_id' => $newShallowModule->parent_id,
                                                'sequence_no' => $newShallowModule->sequence_no,
                                                'title' => $newShallowModule->title,
                                                'description' => $newShallowModule->description,
                                                'watch_hours' => $newShallowModule->watch_hours,
                                                'is_free' => $newShallowModule->is_free,
                                                'allow_quiz' => $newShallowModule->allow_quiz,
                                                'slug' => $newShallowModule->slug,
                                                'detail' => $newShallowModule->detail,
                                                'video_type' => $newShallowModule->video_type,
                                                'video_id' => $newShallowModule->video_id,
                                                'is_feedback' => $newShallowModule->is_feedback,
                                                'status' => $newShallowModule->status,
                                            ];
                                            $newshallowCourseModule = ShallowCourseModule::create($shallowCourseModuleData);
                                            if(isset($newshallowCourseModule)){
                                                $getSections = CourseModuleSection::where('course_module_id', $newshallowCourseModule->parent_course_module_id)->get();
                                                if(isset($getSections) && count($getSections) > 0){
                                                    foreach($getSections as $newShallowModuleSection){
                                                        $shallowCourseModuleSectionData = [
                                                            'parent_course_module_id' => $newShallowModule->id,
                                                            'parent_course_module_section_id' => $newShallowModuleSection->id,
                                                            'purchased_user_id' => $user->id,
                                                            'course_module_id' => $newshallowCourseModule->id,
                                                            'sequence_no' => $newShallowModuleSection->sequence_no,
                                                            'title' => $newShallowModuleSection->title,
                                                            'slug' => $newShallowModuleSection->slug,
                                                            'detail' => $newShallowModuleSection->detail,
                                                            'video_type' => $newShallowModuleSection->video_type,
                                                            'video_id' => $newShallowModuleSection->video_id,
                                                            'status' => $newShallowModuleSection->status,
                                                        ];
                                                        $newshallowCourseModuleSection = ShallowCourseModuleSection::create($shallowCourseModuleSectionData);
                                                    }   
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $getAllSections = ShallowCourseModuleSection::where(['purchased_user_id' => $user->id])->get(array('id','parent_course_module_id','parent_course_module_section_id','course_module_id'));
                            foreach($getAllSections as $shallow){
                                $getExercises = CourseModuleSectionEexercise::where(['course_module_id'=> $shallow->parent_course_module_id,'course_module_section_id' => $shallow->parent_course_module_section_id])->get();
                                if(isset($getExercises) && count($getExercises) > 0){
                                    foreach($getExercises as $newShallowModuleSectionExercises){
                                        $shallowCourseModuleSectionExerciseData = [
                                            'parent_course_module_section_exercise_id' => $newShallowModuleSectionExercises->id,
                                            'purchased_user_id' => $user->id,
                                            'course_module_id' => $shallow->course_module_id,
                                            'course_module_section_id' => $shallow->id,
                                            'sequence_no' => $newShallowModuleSectionExercises->sequence_no,
                                            'title' => $newShallowModuleSectionExercises->title,
                                            'slug' => $newShallowModuleSectionExercises->slug,
                                            'detail' => $newShallowModuleSectionExercises->detail,
                                            'type' => $newShallowModuleSectionExercises->type,
                                            'video_type' => $newShallowModuleSectionExercises->video_type,
                                            'video_id' => $newShallowModuleSectionExercises->video_id,
                                        ];
                                        $newshallowCourseModule = ShallowCourseModuleSectionEexercise::create($shallowCourseModuleSectionExerciseData);

                                        if(isset($newshallowCourseModule)){
                                            // $getQuestions = QuizQuestion::where(['module_id'=> $newShallowModuleSectionExercises->course_module_id,'section_id' => $newShallowModuleSectionExercises->course_module_section_id,'exercise_id' => $newShallowModuleSectionExercises->id])->get();
                                            $getQuestions = QuizQuestion::where(['exercise_id' => $newShallowModuleSectionExercises->id])->get();
                                            if(isset($getQuestions) && count($getQuestions) > 0){
                                                foreach($getQuestions as $question){
                                                    $shallowCourseModuleSectionExerciseQuizQuestionsData = [
                                                        'parent_quiz_question_id' => $question->id,
                                                        'module_id' => $shallow->course_module_id,
                                                        'section_id' => $shallow->id,
                                                        'exercise_id' => $newshallowCourseModule->id,
                                                        'detail' => $question->detail,
                                                        'quiz_id' => $question->quiz_id,
                                                        'question' => $question->question,
                                                        'type' => $question->type,
                                                        'score' => $question->score,
                                                        'file' => $question->file,
                                                        'video_id' => $question->video_id,
                                                        'active' => 1,
                                                    ];
                                                    $newshallowExerciseQuizData = ShallowQuizQuestion::create($shallowCourseModuleSectionExerciseQuizQuestionsData);

                                                    if(isset($newshallowExerciseQuizData)){
                                                        $getAnswers = QuizAnswer::where(['question_id' => $question->id])->get();
                                                        if(isset($getAnswers) && count($getAnswers) > 0){
                                                            foreach($getAnswers as $answer){
                                                                $shallowCourseModuleSectionExerciseQuizQuestionsAnswersData = [
                                                                    'parent_question_id' => $question->id,
                                                                    'parent_quiz_answer_id' => $answer->id,
                                                                    'question_id' => $newshallowExerciseQuizData->id,
                                                                    'answer' => $answer->answer,
                                                                    'is_true' => $answer->is_true,
                                                                    'active' => $answer->active,
                                                                ];
                                                                $newshallowExerciseQuizAnswerData = ShallowQuizAnswer::create($shallowCourseModuleSectionExerciseQuizQuestionsAnswersData);
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            foreach($user->cartItems as $item){
                                $item->delete();
                            }
                            return response()->json(['success' => true , 'message' => 'Course Purchased Successfully'], 200);
                        }
                    }
                }else{
                    return response()->json(['success' => false, 'message' => 'No Course Found'], 404);
                }
            }else{
                return response()->json(['success' => false , 'message' => "user Not Found"], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['success' => false , 'message' => $th->getMessage(), 'line' => $th->getLine(),'file' => $th->getFile()], 200);
        }
    }

    public function applyCoupon(Request $request)
    {
        $data = Coupon::where([['coupon', $request->coupon]])->first();
        if(isset($data) && $data->status == 'Y'){
            return ['success' => true, 'message' => 'Your coupon is valid.', 'data' => $data];
        }elseif(isset($data) && $data->status == 'N'){
            return ['success' => false, 'message' => 'Your coupon has expired.', 'data' => $data];
        }else{
            return ['success' => false, 'message' => 'Your coupon is not valid'];
        }
    }

}
