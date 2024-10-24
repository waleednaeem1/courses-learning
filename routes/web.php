<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\CoursesCartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PracticeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__.'/auth.php';

// Route::get('/', function () {
//     return view('home');
// });
  Route::get('/course/applyCoach/{course_slug}/{coach_id}/{user_id}', [CoursesController::class, 'applyCoach'])->name('applyCoach');
  Route::get('/verified',[UserController::class, 'verifiedUser']);

  Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
    //Courses
    Route::get('courses-categories', [CoursesController::class, 'courseCategories'])->name('courses.categories');
    // for download certificate
    Route::post('courses-categories/certificate-download', [CoursesController::class, 'courseCertificateDownload'])->name('courseCertificateDownload');

    Route::get('courses', [CoursesController::class, 'coursesList'])->name('coursesList');
    Route::get('courses/{course_slug}', [CoursesController::class, 'courseDetail'])->name('courseDetail');
    Route::get('completeDetail/{course_slug}', [CoursesController::class, 'completeDetail'])->name('completeDetail');
    Route::get('courses/{course_slug}/{module_slug}', [CoursesController::class, 'courseModuleDetail'])->name('courseModuleDetail');
    Route::get('courses/{course_slug}/{module_slug}/{section_slug}', [CoursesController::class, 'courseModuleSectionDetail'])->name('courseModuleSectionDetail');
    Route::get('courses/{course_slug}/{module_slug}/{section_slug}/{exercise_slug}/{parent_course_module_section_id?}', [CoursesController::class, 'courseModuleSectionExcerciseDetail'])->name('courseModuleSectionExcerciseDetail');

    Route::post('/course/apply-coach-request', [CoursesController::class, 'applyCoachRequestToAdmin'])->name('applyCoachRequest');
    Route::post('/course/{course_slug}/enrollment', [CoursesController::class, 'courseEnrollment'])->name('courseEnrollment');
    Route::get('/coach/{course_slug}/enrollment', [CoursesController::class, 'enrollCoach'])->name('enrollCoach');
    Route::post('/courses/addToCart', [CoursesCartController::class, 'addToCart'])->name('addToCart');
    Route::post('upload-exercise-file', [CoursesController::class, 'uploadExerciseFile'])->name('uploadExerciseFile');

    Route::get('my-courses', [CoursesController::class, 'myCourses'])->name('myCourses');

    Route::post('course/quiz/save', [CoursesController::class, 'courseQuizSave'])->name('courseQuizSave');

    Route::get('courses-marking-list', [CoursesController::class, 'marking'])->name('marking');
    Route::get('courses-marking-detail/{id}', [CoursesController::class, 'markingCourseDetail'])->name('markingCourseDetail');
    Route::get('exercise-marking-detail/{exercise_id}/{marking_submission_id?}', [CoursesController::class, 'markingExerciseDetail'])->name('markingExerciseDetail');
    Route::post('exercise-marking-save', [CoursesController::class, 'exerciseMark'])->name('exerciseMark');


    //Cart
    Route::get('/cart', [CoursesCartController::class, 'index'])->name('cart');
    Route::post('/courses/delete', [CoursesCartController::class, 'deleteCartItems'])->name('deleteCartItems');
    Route::post('/purchaseCourse', [CoursesCartController::class, 'purchaseCourse'])->name('purchaseCourse');
    Route::post('/applyCoupon', [CoursesCartController::class, 'applyCoupon'])->name('applyCoupon');
    Route::get('/getCartItems', [CoursesCartController::class, 'getCartItems'])->name('getCartItems');

    //Team
    Route::get('team', [TeamController::class, 'index'])->name('team');
    Route::post('team/add-colleague', [TeamController::class, 'addColleague'])->name('team.addColleague');
    Route::get('team/change-coach/{id}', [TeamController::class, 'changeCoach'])->name('team.changeCoach');
    Route::get('team/profile/detail/{id}', [TeamController::class, 'profileDetail'])->name('team.profileDetail');
    // Route::get('team/user/remove/{id}', [TeamController::class, 'removeUser'])->name('team.removeUser');
    Route::get('team/user/restore/{id}', [TeamController::class, 'restoreUser'])->name('team.restoreUser'); //for restore team

    //Events
    Route::get('events', [EventsController::class, 'index'])->name('events');
    Route::get('events/{id}', [EventsController::class, 'details'])->name('event.details');

    Route::get('practice', [PracticeController::class, 'practice'])->name('practice');
    Route::get('myPractice', [PracticeController::class, 'myPractice'])->name('myPractice');
    Route::post('updatePractice', [PracticeController::class, 'updatePractice'])->name('updatePractice');

    Route::post('change-password',[HomeController::class,'changePassword'])->name('adminChangePassword');
    Route::resource('/users', UserController::class);
    Route::get('image-crop', [UserController::class, "imageCrop"]);
    Route::post('image-crop', [UserController::class, "imageCropPost"])->name("imageCrop");

    Route::post('updateProfile', [UserController::class, "updateProfile"])->name("updateProfile");

    Route::get('account', [UserController::class, 'account'])->name('user-account');
    Route::get('profileedit', [UserController::class, 'profileedit'])->name('profileedit');

     //Invoice
    Route::get('practiceBilling', [InvoiceController::class, 'invoices'])->name('practiceBilling');
    Route::get('invoice/{id}', [InvoiceController::class, 'details'])->name('invoice.details');

    Route::get('get-states', [UserController::class, 'get_states'])->name('get-states');

    Route::get('privacy-policy', [HomeController::class, 'privacyPolicy'])->name('footer.privacypolicy');
    Route::get('cookie-policy', [HomeController::class, 'cookiePolicy'])->name('footer.cookiePolicy');
    Route::get('faqs', [HomeController::class, 'faqs'])->name('footer.faqs');
    Route::get('about-us', [HomeController::class, 'aboutus'])->name('footer.aboutus');
    Route::get('contact', [HomeController::class, 'contact'])->name('footer.contact');
    Route::post('contactSupport',[HomeController::class,'contactSupport'])->name('user.contactSupport');
  });
  Route::get('terms-and-conditions', [HomeController::class, 'termsOfService'])->name('footer.termsandconditions');

