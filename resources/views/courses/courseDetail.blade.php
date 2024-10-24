<x-app-layout>
 <section id="saasio-breadcurmb" class="saasio-breadcurmb-section">
      <div class="container">
         <div class="breadcurmb-title text-center">
            <h2>Course : {{$data['course']->title ?? ''}}</h2>
         </div>

      </div>
  </section>
  {{--  <div class="header-for-bg">
      <div class="background-header position-relative">
         <img src="{{asset('images/user/courseCover.png')}}" class="img-fluid w-100" style="height: 368px;" alt="header-bg">
         <div class="title-on-header">
            <div class="data-block">
               <h2>{{$data['course']->title}}</h2>
            </div>
         </div>
      </div>
   </div> --}}
   <div class="content-page mt-3" id="content-page">
      <div class="container" id="page-container">
         <div class="row mb-3">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Progress</h4>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="progress mb-3">
                        @if($data['is_course_complete'])
                           <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">100%</div>
                        @else
                           <div class="progress-bar" role="progressbar" style="width: {{$data['percentage']}}%;" aria-valuenow="{{$data['percentage']}}" aria-valuemin="0" aria-valuemax="100">{{$data['percentage']}}%</div>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row mb-3">
            <div class="col-lg-12">
               <div class="card">
                  <div class="d-flex justify-content-between">

                     @if (isset($data['coachData']) && $data['coachData']->email != '')
                        <span class="ml-3" style="color: #8C68CD;">Your coach is {{$data['coachData']->first_name.' '.$data['coachData']->last_name}}:  {{$data['coachData']->email}}</span>
                     @endif
                 </div>
                  <div class="card-body">
                     <div class="image-block position-relative">
                        <p class="mb-0">{{$data['course']->short_description}}
                           <span>
                              {{-- <a class="mt-1" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">See Detail</a> --}}
                              <a class="mt-1" target="_blank" href="{{ route('completeDetail', ['course_slug' => $data['course']->slug]) }}" style="color:blueviolet">  See Detail</a>
                           </span>
                        </p>
                     </div>
                     {{-- <div class="header-title" style="margin-top:2rem">
                        <h4 class="card-title">Services:</h4>
                     </div>
                     <div class="form-check form-check-inline">
                        @if($data['course']->general_guidance == 1)
                           <div class="form-check">
                              <input type="checkbox" disabled checked class="form-check-input">
                              <label for="customCheck7">General Guidance</label></i>
                           </div>
                        @endif
                        @if($data['course']->is_24_7_support_service == 1)
                           <div class="form-check" style="margin-left:1rem">
                              <input type="checkbox" disabled checked class="form-check-input">
                              <label for="customCheck8">24/7 support service</label>
                           </div>
                        @endif
                        @if($data['course']->is_practice_questions == 1)
                           <div class="form-check" style="margin-left:1rem">
                              <input type="checkbox" disabled checked class="form-check-input">
                              <label for="customCheck9">Practice Questions</label>
                           </div>
                        @endif
                     </div> --}}
                     @if($data['is_download_certificate']==1)
                        <div class="header-title" style="margin-top:2rem">
                           <h4 class="card-title">Download Certificate:</h4>
                        </div>
                        <div class="form-check form-check-inline">
                           <div class="form-check" style="margin-left:-1rem">
                              <form method="post" action="{{route('courseCertificateDownload')}}">
                                 @csrf
                                 <input type="hidden" name="course_id" value="{{$data['course']->id}}">
                                 <input type="hidden" name="course_marking_user" value="{{$data['course']->marking_user}}">
                                 <button class="btn btn-primary text-center" type="submit">DOWNLOAD YOUR CERTIFICATE</button>
                              </form>
                           </div>
                        </div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
         <div class="modal fade bd-example-modal-lg" style="margin-top:4rem" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title">Course Detail</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                     </button>
                  </div>
                  <div class="modal-body">
                     <p>{{$data['course']->short_description}}</p>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
               <div id="faqAccordion">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="accordion" id="accordionExample">
                           @foreach($data['modules_list'] as $module)
                              @php
                                 $check =false;
                                 $module_total_exercises=0;
                                 $is_module_makred=0;
                                 $is_marking_pending=0;
                                 if(getModuleExercises($module,'course_listing')>0  && isset($module->moduleCompletion->is_mark) && $module->moduleCompletion->is_mark==0 ){
                                    $is_marking_pending=1;
                                 }

                                foreach($module->sections as $sectionIndex => $section){

                                    if(count($section->exercise) > 0){
                                       $check =true; //flag for lock
                                       foreach($section->exercise as $sectionExercise){
                                          $type=$sectionExercise->type;
                                          $id=$sectionExercise->id;
                                          if($type==='file_upload'){
                                             $module_total_exercises++;
                                          }elseif($type==='quiz'){
                                             $result_type=$sectionExercise['exercise_result']->type ?? '';
                                             if(isset($result_type) && ($result_type==='both' ||  $result_type==='text' ) ){
                                                $module_total_exercises++;
                                             }
                                          }
                                       }
                                    }
                                 }
                                 if($check == true){
                                    $moduleLock[$loop->iteration] = false;
                                    $moduleCompletion = \App\Models\ModuleCompletion::where(['course_id' => $module->course_id , 'module_id' => $module->id, 'user_id' => auth()->user()->id])->count();
                                    $moduleSubmission = \App\Models\MarkingSubmission::where(['course_id' => $module->course_id , 'module_id' => $module->id, 'course_user_id' => auth()->user()->id])->count();
                                    if($module_total_exercises==$moduleSubmission && $is_marking_pending==0){
                                       $is_module_makred=1;
                                    }
                                    if($data['course']->marking_user!='auto'){
                                       if($moduleCompletion==0 || $is_module_makred==0){
                                          $moduleLock[$loop->iteration] = true;
                                       }
                                    }else{
                                       if($moduleCompletion==0){
                                          $moduleLock[$loop->iteration] = true;
                                       }
                                    }
                                    if(Request::get('test')){
                                       echo '<br>';
                                       echo 'course_id ' .$module->course_id. '  module_id ' . $module->id. ' course_user_id' . auth()->user()->id;
                                       echo '<br>module_total_exercises= '.$module_total_exercises.' moduleSubmission= '.$moduleSubmission;
                                       echo '<br>is_marking_pending='.$is_marking_pending;
                                       echo '<br>moduleCompletion=  '.$moduleCompletion.' is_module_makred=  '.$is_module_makred;
                                    }
                                 }
                              @endphp

                              <div class="accordion-item mb-3">

                                @if($loop->iteration > 1 && isset($moduleLock[$loop->iteration -1]) && $moduleLock[$loop->iteration -1] )

                                    <div class="d-flex justify-content-between">
                                       <span class="text-body pt-2" style="padding-left: 15px;
                                       font-weight: normal;" class="mt-4 pt-1">
                                          Module {{ $loop->iteration }}- &nbsp;{{ $module->title }}
                                       </span>
                                       <svg style="margin-right:10px;" class="pr-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#8c68cd" version="1.1" id="Capa_1" width="40" height="50px" viewBox="0 0 342.52 342.52" xml:space="preserve">
                                          <g>
                                             <g>
                                                <path d="M171.254,110.681c-14.045,0-25.47,11.418-25.47,25.476v21.773h50.933v-21.773    C196.724,122.104,185.29,110.681,171.254,110.681z"/>
                                                <path d="M171.26,0C76.825,0,0.006,76.825,0.006,171.257c0,94.438,76.813,171.263,171.254,171.263    c94.416,0,171.254-76.825,171.254-171.263C342.514,76.825,265.683,0,171.26,0z M226.225,239.291c0,4.119-3.339,7.446-7.458,7.446    h-95.032c-4.113,0-7.446-3.327-7.446-7.446v-73.91c0-4.119,3.333-7.458,7.446-7.458h7.152V136.15    c0-22.266,18.113-40.361,40.367-40.361c22.251,0,40.355,18.095,40.355,40.361v21.773h7.151c4.119,0,7.458,3.338,7.458,7.458v73.91    H226.225z"/>
                                             </g>
                                          </g>
                                       </svg>
                                    </div>
                                 @else
                                    <h2 class=" accordion-header" id="heading{{ $loop->iteration }}">
                                       <button class="course_list accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                          data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="false"
                                          aria-controls="collapse{{ $loop->iteration }}">
                                         <div style="width: 100%;">  <b>Module {{ $loop->iteration }}-  </b>&nbsp;{{ $module->title }}</div>
                                         <div style="min-width: max-content;">@if($data['course']->marking_user != 'auto' && $is_marking_pending==1 )
                                         <b style="color: #adc330;border-color: #9fa915;">Module Submitted For Marking.</b>
                                        @endif</div>

                                       <div style="min-width: max-content;">
                                         @if($data['course']->marking_user!='auto' && !empty($moduleCompletion) && $moduleCompletion==1 && $is_module_makred==1 )
                                         <b style="color: #adc330;border-color: #9fa915;">Module Completed.</b>
                                        @elseif($data['course']->marking_user==='auto' && !empty($moduleCompletion) && $moduleCompletion==1)
                                         <b style="color: #adc330;border-color: #9fa915;">Module Completed.</b>
                                        @endif
                                      </div>

                                    </button>
                                    </h2>
                                 @endif

                                 <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $loop->iteration }}" data-bs-parent="#accordionExample">
                                     <div class="accordion-body">
                                       <div class="accordion" id="nestedAccordion{{ $loop->iteration }}">
                                          <a href="{{ route('courseModuleDetail', ['course_slug' => $data['course']->slug,'module_slug' => $module->slug]) }}">
                                             {{ $module->title }}
                                          </a>
                                          @if(isset($module['sections']) && count($module['sections']) > 0)

                                             <div id="nestedAccordion{{ $loop->iteration }}-sections" class="accordion">
                                                @foreach($module['sections'] as $section)
                                                    @php
                                                    $is_section_complete=0;
                                                    if(isset($section['exercise']) && count($section['exercise']) > 0){

                                                     $sectionLock[$loop->iteration] = false;

                                                    $totalSectionExercise= App\Models\ShallowCourseModuleSectionEexercise::where('course_module_section_id',$section->id)->count();

                                                    $totalExerciseComplete= App\Models\ExerciseCompletion::where('section_id',$section->id)->where('user_id',auth()->user()->id)->count();

                                                    if($totalExerciseComplete!=$totalSectionExercise){
                                                        $sectionLock[$loop->iteration] = true;
                                                    }else{
                                                     $is_section_complete=1;
                                                    }
                                                    }
                                                    @endphp

                                                    @if($loop->iteration > 1 && isset($sectionLock[$loop->iteration -1]) && $sectionLock[$loop->iteration -1] )
                                                <div class="accordion-item" style="margin-left: 2rem;">
                                                    <div class="d-flex justify-content-between">
                                                    <span class="text-body pt-2" style="padding-left: 15px;
                                                    font-weight: normal;" class="mt-4 pt-1">
                                                          <b>Section {{ $loop->parent->iteration}}.{{ $loop->iteration }} - <b> &nbsp;{{ $section->title }}
                                                    </span>
                                                    <svg style="margin-right:10px;" class="pr-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#8c68cd" version="1.1" id="Capa_1" width="40" height="50px" viewBox="0 0 342.52 342.52" xml:space="preserve">
                                                        <g>
                                                            <g>
                                                                <path d="M171.254,110.681c-14.045,0-25.47,11.418-25.47,25.476v21.773h50.933v-21.773    C196.724,122.104,185.29,110.681,171.254,110.681z"/>
                                                                <path d="M171.26,0C76.825,0,0.006,76.825,0.006,171.257c0,94.438,76.813,171.263,171.254,171.263    c94.416,0,171.254-76.825,171.254-171.263C342.514,76.825,265.683,0,171.26,0z M226.225,239.291c0,4.119-3.339,7.446-7.458,7.446    h-95.032c-4.113,0-7.446-3.327-7.446-7.446v-73.91c0-4.119,3.333-7.458,7.446-7.458h7.152V136.15    c0-22.266,18.113-40.361,40.367-40.361c22.251,0,40.355,18.095,40.355,40.361v21.773h7.151c4.119,0,7.458,3.338,7.458,7.458v73.91    H226.225z"/>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                 </div>
                                                 </div>
                                                     @else
                                                        <div class="accordion-item" style="margin-left: 2rem;">
                                                      <h2 class="accordion-header"  id="nestedHeading{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}">


                                                         <button class="course_list accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#nestedCollapse{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}"
                                                            aria-expanded="false"
                                                            aria-controls="nestedCollapse{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}">

                                                          <div style="width: 100%;">

                                                            <b>Section {{ $loop->parent->iteration}}.{{ $loop->iteration }} - </b> &nbsp;{{ $section->title }}

                                                            </div>
                                                              <div style="min-width: max-content;">

                                                             <span>
                                                            @if($is_section_complete==1)
                                                             <i class="fa fa-check" aria-hidden="true" style="color: #0cdf1a;"></i>
                                                            @endif</span>

                                                            </div>

                                                         </button>
                                                      </h2>
                                                      <div
                                                         id="nestedCollapse{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}"
                                                         class="accordion-collapse collapse"
                                                         aria-labelledby="nestedHeading{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}"
                                                         data-bs-parent="#nestedAccordion{{ $loop->iteration }}-sections">
                                                         <div class="accordion-body">
                                                            <div class="accordion"
                                                               id="nestedAccordion{{ $loop->parent->iteration ?? '' }}-sub-module">
                                                               <a href="{{ route('courseModuleSectionDetail', ['course_slug' => $data['course']->slug,'module_slug' => $module->slug,'section_slug' => $section->slug]) }}">
                                                                  <p>{{ $section->title }}</p>
                                                               </a>
                                                               @if(isset($section['exercise']) && count($section['exercise']) > 0)

                                                                  <div
                                                                     class="accordion"
                                                                     id="nestedAccordion{{ $loop->iteration }}-{{ $loop->parent->iteration }}-exercises">
                                                                     @foreach($section['exercise'] as $sectionExercise)
                                                                        @php
                                                                       $exerciseLock[$loop->iteration] = false;
                                                                        $is_exercise_complete=0;
                                                                       $exerciseComplete= App\Models\ExerciseCompletion::where( ['section_id'=>$section->id,'user_id'=>auth()->user()->id,'exercise_id'=>$sectionExercise->id])->count();

                                                                        if($exerciseComplete ==0 ){
                                                                         $exerciseLock[$loop->iteration] = true;
                                                                        }else{
                                                                        $is_exercise_complete=1;
                                                                        }
                                                                        @endphp

                                                            <div class="accordion-item">

                                                            @if($loop->iteration > 1 && isset($exerciseLock[$loop->iteration -1]) && $exerciseLock[$loop->iteration -1]  )
                                                            <div class="accordion-item">
                                                            <div class="d-flex justify-content-between">
                                                            <span class="text-body pt-2" style="padding-left: 15px;
                                                            font-weight: normal;" class="mt-4 pt-1">
                                                                <b> Exercise {{ $loop->parent->iteration}}.{{ $loop->iteration }} </b> - &nbsp;{{ $sectionExercise->title }}
                                                            </span>
                                                            <svg style="margin-right:10px;" class="pr-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#8c68cd" version="1.1" id="Capa_1" width="40" height="50px" viewBox="0 0 342.52 342.52" xml:space="preserve">
                                                                <g>
                                                                    <g>
                                                                <path d="M171.254,110.681c-14.045,0-25.47,11.418-25.47,25.476v21.773h50.933v-21.773    C196.724,122.104,185.29,110.681,171.254,110.681z"/>
                                                                <path d="M171.26,0C76.825,0,0.006,76.825,0.006,171.257c0,94.438,76.813,171.263,171.254,171.263    c94.416,0,171.254-76.825,171.254-171.263C342.514,76.825,265.683,0,171.26,0z M226.225,239.291c0,4.119-3.339,7.446-7.458,7.446    h-95.032c-4.113,0-7.446-3.327-7.446-7.446v-73.91c0-4.119,3.333-7.458,7.446-7.458h7.152V136.15    c0-22.266,18.113-40.361,40.367-40.361c22.251,0,40.355,18.095,40.355,40.361v21.773h7.151c4.119,0,7.458,3.338,7.458,7.458v73.91    H226.225z"/>
                                                            </g>
                                                            </g>
                                                                </svg>
                                                            </div>
                                                            </div>
                                                                    @else
                                                                    <div class="accordion-body"
                                                                              style="background-color: var(--bs-primary-tint-90); height: 60px; margin-bottom: 1rem;">
                                                                              <a href="{{ route('courseModuleSectionExcerciseDetail', ['course_slug' => $data['course']->slug,'module_slug' => $module->slug,'section_slug' => $section->slug,'exercise_slug' => $sectionExercise->slug,'parent_course_module_section_id'=>$section->parent_course_module_section_id]) }}">
                                                                                 <div style="display: flex;justify-content: space-between;">
                                                                                    <div style="width: 70%;">
                                                                                       <p> <b>Exercise {{ $loop->parent->parent->iteration }}.{{ $loop->parent->iteration }}.{{ $loop->iteration }} -</b>  &nbsp;{{ $sectionExercise->title }}</p>
                                                                                    </div>
                                                                                    <div>

                                                                                    @if($is_exercise_complete==1)
                                                                                    <i class="fa fa-check" aria-hidden="true" style="color: #0cdf1a;"></i>
                                                                                    @endif</span>

                                                                                       @if(isset($sectionExercise->exercise_marking ))
                                                                                          &nbsp;    &nbsp; <b style="    color: #721c24;border-color: #f5c6cb;">Please Review Feedback!</b>
                                                                                       @endif
                                                                                    </div>
                                                                                 </div>
                                                                              </a>
                                                                           </div>
                                                                        @endif
                                                                        </div>
                                                                     @endforeach
                                                                  </div>
                                                               @endif
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                     @endif

                                                   {{-- --}}
                                                @endforeach
                                             </div>
                                          @endif
                                          @if(isset($module->childSubModules) && count($module->childSubModules) > 0)
                                             @foreach ($module->childSubModules as $childModule)
                                                @include('courses/child_modules', ['childModule' => $childModule, 'count'=>1])
                                             @endforeach
                                          @endif
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>