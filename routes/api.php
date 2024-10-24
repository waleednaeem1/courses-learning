<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CoursesCartController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\PracticeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/course/applyCoach', [CourseController::class, 'applyCoach']); //Done

Route::get('/courses-categories', [CourseController::class, 'courseCategories']); // Done
Route::post('/courses-categories/certificate-download', [CourseController::class, 'courseCertificateDownload']); //Done

Route::get('/course-listing/{user_id}', [CourseController::class, 'courseListing']); // Done
Route::get('/courses/{course_slug}/{user_id}', [CourseController::class, 'courseDetail']); //Done
Route::get('/courses/{course_slug}/{module_slug}/{user_id}', [CourseController::class, 'courseModuleDetail']); //Done
Route::get('/courses/{course_slug}/{module_slug}/{section_slug}/{user_id}', [CourseController::class, 'courseModuleSectionDetail']); //Done
Route::get('courses/{course_slug}/{module_slug}/{section_slug}/{exercise_slug}/{user_id}/{parent_course_module_section_id?}', [CourseController::class, 'courseModuleSectionExerciseDetail']); //done

Route::post('/course/apply-coach-request', [CourseController::class, 'applyCoachRequestToAdmin']);
Route::get('/course/{course_slug}/enrollment/{customer_id}', [CourseController::class, 'courseEnrollment']);
Route::get('/coach/{course_slug}/enrollment/{user_id}', [CourseController::class, 'enrollCoach']);
Route::post('upload-exercise-file', [CourseController::class, 'uploadExerciseFile']);

Route::post('/courses/addToCart', [CourseController::class, 'addToCart']); //done

Route::post('course/quiz/save', [CourseController::class, 'courseQuizSave']); 


Route::get('/my-courses/{user_id}', [CourseController::class, 'myCourses']);

// Apply Couch

// User Cart
Route::get('/cart/{user_id}', [CoursesCartController::class, 'index']); 
Route::post('/courses/delete', [CoursesCartController::class, 'deleteCartItems']); 
Route::post('/purchaseCourse', [CoursesCartController::class, 'purchaseCourse']);
Route::post('/applyCoupon', [CoursesCartController::class, 'applyCoupon']); 

// User Teams
Route::get('/team/{user_id}', [TeamController::class, 'index']);

Route::post('/team/add-colleague', [TeamController::class, 'addColleague']);
Route::get('/team/change-coach/{id}/{user_id}', [TeamController::class, 'changeCoach']);
Route::get('/team/profile/detail/{id}', [TeamController::class, 'profileDetail']);
Route::post('/team/user/restore', [TeamController::class, 'restoreUser']); 
Route::post('/team/user/profile/edit', [TeamController::class, 'teamUserEdit']);
Route::post('/team/user/profile/update', [TeamController::class, 'teamUserUpdate']);

//Coursing Marking Coach Adn Admin
Route::get('/courses-marking-list/{user_id}', [CourseController::class, 'marking']);
Route::get('/courses-marking-detail/{id}', [CourseController::class, 'markingCourseDetail']);
Route::get('/exercise-marking-detail/{id}', [CourseController::class, 'markingExerciseDetail']);
Route::post('/exercise-marking-save', [CourseController::class, 'exerciseMark']);

//User Paractice
Route::get('/practice/{user_id}', [PracticeController::class, 'practice']);
Route::get('/myPractice/{user_id}', [PracticeController::class, 'myPractice']);
Route::post('/updatePractice', [PracticeController::class, 'updatePractice']);