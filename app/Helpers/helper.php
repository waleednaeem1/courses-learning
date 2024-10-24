<?php

use App\Models\ShallowCourseModuleSection;
use App\Models\SectionCompletion;
use App\Models\ModuleCompletion;
use App\Models\ShallowCourseModule;
use App\Models\CourseCompletion;
use App\Models\ShallowCourse;

function removeSession($session){
    if(\Session::has($session)){
        \Session::forget($session);
    }
    return true;
}

function randomString($length,$type = 'token'){
    if($type == 'password')
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    elseif($type == 'username')
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    else
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $token = substr( str_shuffle( $chars ), 0, $length );
    return $token;
}

function activeRoute($route, $isClass = false): string
{
    $requestUrl = request()->fullUrl() === $route ? true : false;

    if($isClass) {
        return $requestUrl ? $isClass : '';
    } else {
        return $requestUrl ? 'active' : '';
    }
}

function checkRecordExist($table_list,$column_name,$id){
    if(count($table_list) > 0){
        foreach($table_list as $table){
            $check_data = \DB::table($table)->where($column_name,$id)->count();
            if($check_data > 0) return false ;
        }
        return true;
    }
    return true;
}

// Model file save to storage by spatie media library
function storeMediaFile($model,$file,$name)
{
    if($file) {
        $model->clearMediaCollection($name);
        if (is_array($file)){
            foreach ($file as $key => $value){
                $model->addMedia($value)->toMediaCollection($name);
            }
        }else{
            $model->addMedia($file)->toMediaCollection($name);
        }
    }
    return true;
}

// Model file get by storage by spatie media library
function getSingleMedia($model, $collection = 'image_icon',$skip=true)
{
    if (!\Auth::check() && $skip) {
        return asset('images/avatars/01.png');
    }
    if ($model !== null) {
        $media = $model->getFirstMedia($collection);
    }
    $imgurl= isset($media)?$media->getPath():'';
    if (file_exists($imgurl)) {
        return $media->getFullUrl();
    }
    else
    {
        switch ($collection) {
            case 'image_icon':
                $media = asset('images/avatars/01.png');
                break;
            case 'profile_image':
                $media = asset('images/avatars/01.png');
                break;
            default:
                $media = asset('images/common/add.png');
                break;
        }
        return $media;
    }
}

// File exist check
function getFileExistsCheck($media)
{
    $mediaCondition = false;
    if($media) {
        if($media->disk == 'public') {
            $mediaCondition = file_exists($media->getPath());
        } else {
            $mediaCondition = \Storage::disk($media->disk)->exists($media->getPath());
        }
    }
    return $mediaCondition;
}

function appName()
{
    return config('app.name', 'Colorful CE');
}

$totalModulesComplete=0;
$totalModules=0;

function getChildModules($subModule){
    global $totalModulesComplete, $totalModules;
    $totalModules++;
    $totalModuleSections = ShallowCourseModuleSection::where('course_module_id', $subModule->id )->where('status', '=', 'Y')->count();
    $totalSectionComplete= SectionCompletion::where('module_id',$subModule->id )->where('user_id',auth()->user()->id)->count();
    if($totalModuleSections == $totalSectionComplete){
        $totalModulesComplete++;
    }
    if ($subModule->sub_modules){
        foreach ($subModule->sub_modules as $childModule)
        {
            getChildModules($childModule);
        }
    }
    return array('totalModules'=>$totalModules, 'totalModulesComplete'=> $totalModulesComplete );
}

function getModuleExercises($module,$type='')
{
    $totalSectionsHide=0;
    $totalModuleExercises=0;
    $totalSections=count($module['sections']);
    if($totalSections>0){
        foreach($module['sections'] as $key => $section)
        {
            $section['is_hide']=0;
            $total_marked_exercises=0;
            $totalExercises=count($section['completed_exercises']);
            if($totalExercises>0){
                foreach($section['completed_exercises'] as $index => $cExercise){
                    if(isset($cExercise) && isset($cExercise['exercise'])){
                        if($cExercise['exercise']->type==='quiz' && isset($cExercise['exercise']['exercise_result']->type)){
                            if ($cExercise['exercise']['exercise_result']->type == 'both' || $cExercise['exercise']['exercise_result']->type == 'text')
                            {
                                $total_marked_exercises++;
                                $totalModuleExercises++;
                            }
                        }
                        elseif($cExercise['exercise']->type==='file_upload')
                        {
                            $total_marked_exercises++;
                            $totalModuleExercises++;
                        }
                    }
                }
            }
            if($total_marked_exercises==0 || $totalExercises==0){
                $section['is_hide']=1;
                $totalSectionsHide++;
            }
        }
    }
    if($totalSectionsHide==$totalSections || $totalSections==0){
        $module->is_mark=1;
        if(!$type){
            $module->save();
        }
        $module['is_hide']=1;
    }else{
        $module['is_hide']=0;
    }
    return  $totalModuleExercises;
}

function searchMarkingResult($value, $key, $array) {
    foreach ($array as $k => $val) {
        if ($val[$key] == $value) {
            return $val;
        }
    }
    return null;
}

function countModuleExercises($course){
     $modules=ModuleCompletion::where(['course_id'=>$course->id,'is_mark'=>0])->get();
     $total_exercises=0;
     foreach($modules as $key=>$module){
     $total= getModuleExercises($module);
     if($total>0){
       $total_exercises=$total;
     }
     }
    return $total_exercises;
}

 function checkCourseComplete($course_id,$marking_user=''){
    $is_download_certificate=0;

    $total_modules=0;
    $modules_arr=array();
    $courseModules=ShallowCourseModule::with('sections.exercise')->where(['course_id'=> $course_id,'purchased_user_id'=>auth()->user()->id])->where('status', '=', 'Y')->get();

    foreach($courseModules as $subModule)
    {
        if($subModule->sections->count()!=0){
            foreach($subModule['sections'] as $section){
                if(count($section['exercise'])!=0){
                    if(!in_array($subModule->id,$modules_arr))
                    {
                        array_push($modules_arr,$subModule->id);
                    }
                }
            }
        }
    }

   $total_modules= count($modules_arr);
    if($marking_user==='auto'){
    $moduleCompletion = ModuleCompletion::where(['course_id' => $course_id , 'user_id' => auth()->user()->id])->count();

    }else{
    $moduleCompletion = ModuleCompletion::where(['course_id' => $course_id , 'user_id' => auth()->user()->id,'is_mark'=>1])->count();

    }
    if($total_modules== $moduleCompletion){
    $is_download_certificate=1;
    }
   return $is_download_certificate;
 }

    function getCourseProgress($course_id){
        $user_id=auth()->user()->id;
        $is_course_complete=false;
        $percentage=0;
        $completed_courses=CourseCompletion::where([['user_id', $user_id],['course_id', $course_id]])->count();
        if($completed_courses>0){
            $is_course_complete=true;
        }else{
            $totalModules= ShallowCourseModule::where(['course_id'=> $course_id,'purchased_user_id'=>$user_id])->where('status', '=', 'Y')->count();
            $totalModulesCompleted=ModuleCompletion::where('course_id',$course_id)->where('user_id',auth()->user()->id)->count();
            if($totalModules!=$totalModulesCompleted){
                $percentage=($totalModulesCompleted/$totalModules)*100;
                $percentage=round($percentage);
            }
        }
      return [ $is_course_complete,$percentage];
    }

  function getPrerequisiteCourses($prerequisite_courses){

     if(!empty($prerequisite_courses)){
     $total_prerequisite_courses = count(json_decode($prerequisite_courses));
     $courses= ShallowCourse::with('completed_course')->whereIn('parent_course_id',json_decode($prerequisite_courses))->where(['status'=>'Y','purchased_user_id'=>auth()->user()->id]);

     $totalShallowCourses=$courses->count();
     $totalCompleted=0;
     if($totalShallowCourses!=$total_prerequisite_courses){
      return 0;
     }else{

       foreach ($courses->get() as $key => $course) {

        if(!$course['completed_course']){
            return 0;
            break;
        }else{
            $totalCompleted++;
        }

     }
       if( $totalCompleted==$total_prerequisite_courses){
        return 1;
       }
     }


      }else{
     return null;
      }
  }