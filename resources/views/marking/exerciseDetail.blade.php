<x-app-layout>
   <div class="container">
      <div class="row">
      <form method="POST" class="mt-4" action="{{ route('exerciseMark') }}" data-toggle="validator" class="">
                        {{csrf_field()}}
          @if($shallowExercise->type !='file_upload')
           <div class="col-lg-12">
            <div class="card shadow-none p-0">
               <div class="card-header d-flex justify-content-between rounded border-bottom-0">
                  <div class="header-title">
                     <a class="btn btn-primary text-white " href="{{route('markingCourseDetail',  ['id' => $exercise[0]->course_id])}}">Back</a>
                  </div>
               </div>
            </div>

                <input type="hidden" value="{{ $exercise[0]->course_id}}" name="course_id">
                <input type="hidden" value="{{$exercise[0]->module_id}}" name="module_id">
                <input type="hidden" value="{{$exercise[0]->section_id}}" name="section_id">
                <input type="hidden" value="{{ $exercise[0]->exercise_id}}" name="exercise_id">

            <div class="card shadow-none p-0">
               <div class="card-header d-flex justify-content-between rounded border-bottom-0">
                  <div class="header-title">
                     {{-- <h4 class="btn btn-primary">{{$exercise[0]['exercise'][0]->title}}</h4> --}}
                     <h4 class="text-primary">{{$exercise[0]['exercise'][0]->title}}</h4>
                     <div class="image-block position-relative">
                        <p class="mb-0">{!! ($exercise[0]['exercise'][0]->detail) !!}</p>
                     </div>
                     @if(isset($exercise[0]['exercise'][0]->video_id) && $exercise[0]['exercise'][0]->video_id !== '')
                        <div class="image-block position-relative">
                           <iframe src="{{'https://player.vimeo.com/video/'.$exercise[0]['exercise'][0]->video_id}}" width="100%" height="500" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                     @endif
                  </div>
               </div>
            </div>

             <input type="hidden" value="{{$exercise[0]['course']['purchased_user_id']}}" name="course_user_id">
            @foreach($exercise[0]->result as $key => $exerciseData)
               @if(isset($exercise[0]->result) && count($exercise[0]->result) > 0)

                 {{-- <input type="hidden" value="{{$exercise[0]['exercise'][0]['purchased_user_id']}}" name="course_user_id"> --}}

                  {{-- @php $questions = \App\Models\ShallowQuizQuestion::where('id',$exerciseData['question'])->with('answers')->first() @endphp --}}
                  @php $questions = \App\Models\ShallowQuizQuestion::where('id',$exerciseData['question'])->with('answers')->get() @endphp
                  @foreach($questions as $question)
                    @php
                        if(isset($submission->exercise_marking_result)){
                         $markingResults=searchMarkingResult($question->id, 'question_id', $submission->exercise_marking_result);
                       }

                    @endphp
                    <br>
                     <div class="row mt-3">
                        <div class="col-lg-12">
                           <div class="card" style="height: auto;justify-content: center;">  <br>
                              <div class="row">
                                 <div>
                                    <h4 class="card-title" style="padding-left: 2rem;color: #8C68CD;">Question: {{$key+1}}</h4>
                                 </div>
                                 <div>
                                    <p style="padding-left: 2rem;color: #8C68CD;">{{$question->question}}</p>
                                 </div>

                                 @if($question->type === 'mcq' || $question->type === 'feedback_mcq')

                                    <div class="form-group" style="margin-left: 2rem">
                                       @foreach($question['answers'] as $answer)
                                          <div class="form-check form-check-inline">
                                             <input class="form-check-input" disabled type="radio" value='{{$answer->id}}' name="{{$answer->question_id}}" id="{{$answer->id}}"
                                                @if($answer->is_true == 1) checked   @endif
                                                >
                                             <span>{{$answer->answer}}</span>
                                          </div>

                                        @if($answer->is_true == 1)


                                       @endif

                                       @endforeach
                                    </div>
                                 @elseif ($question->type == 'reflective_question' || $question->type == 'reflective_question_multiline' || $question->type == 'feedback_question_multiline')
                                    <div class="form-group" style="margin-left: 2rem; margin-top:1rem;width:90%">
                                       <label for="">User Response:</label>
                                       <p>{{$exerciseData['answer']}}</p>
                                      <input type="hidden" value="{{ $question->id}}" name="question_ids[]">
                                       <hr>
                                       <label for="">Provide User Feedback:</label>
                                       <textarea class="form-control" rows="4"  name="feedback[]">{{$markingResults['feedback'] ?? '' }}</textarea>
                                       <hr>
                                       <label>Verify User Response: &nbsp;</label>
                                         &nbsp;
                                       <input class="form-check-input ml-1" type="radio" id="inlineRadio{{$question->id}}{{$question->type}}" value='satisfactory' {{ isset($markingResults)  && $markingResults['status']==='satisfactory'  ? "checked" : "" }}  name="status[{{$question->id}}]"  required>
                                        <label class="form-check-label ml-4" for="inlineRadio{{$question->id}}{{$question->type}}"> Satisfactory</label>
                                         &nbsp; &nbsp; &nbsp;
                                         <input class="form-check-input ml-1" type="radio" id="inlineRadio{{$question->id}}{{$question->type}}" value='non_satisfactory' {{ isset($markingResults) && $markingResults['status']==='non_satisfactory'  ? "checked" : "" }}  name="status[{{$question->id}}]"  required>
                                        <label class="form-check-label  ml-4" for="inlineRadio{{$question->id}}{{$question->type}}"> Not Satisfactory</label>

                                    </div>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  @endforeach
               @endif
            @endforeach
            <div class="row" style="margin-top: 2rem;">
               <div class="col-lg-12">
                  <div class="card" style="height: 15rem;justify-content: center;">
                     <div class="row">
                        <div class="col-md-8">
                           <h4 class="card-title" style="padding-left: 2rem;color: #8C68CD;">Examiner Comments for the exercise</h4>
                        </div>
                        <div class="col-md-4">
                           <button class="btn btn-light" disabled style="margin-left: 6rem">This is shown to the user</button>
                        </div>
                        <form>
                           <div class="form-group" style="margin-left: 2rem; margin-top:1rem;width:93%">
                              <textarea class="form-control" id="" name="comments" required  rows="4">{{$submission->comments ?? '' }}</textarea>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div style="display: flex;justify-content: flex-end;">
                <button type="submit" id="resetFormButton" class="btn btn-primary btn-block">  {{ __('SUBMIT MARKING & CONTINUE') }}</button>
            </div>
         </div>
          @else

         <div class="col-lg-12">
            <div class="card shadow-none p-0">
               <div class="card-header d-flex justify-content-between rounded border-bottom-0">
                  <div class="header-title">
                     <a class="btn btn-primary text-white " href="{{route('markingCourseDetail',  ['id' => $shallowExercise->module->course->id])}}">Back</a>
                  </div>
               </div>
            </div>
                <input type="hidden" value="{{ $shallowExercise->module->course->id}}" name="course_id">
                <input type="hidden" value="{{$shallowExercise->course_module_id}}" name="module_id">
                 <input type="hidden" value="{{$shallowExercise->course_module_section_id}}" name="section_id">
                 <input type="hidden" value="{{  $shallowExercise->id}}" name="exercise_id">

               <div class="card shadow-none p-0">
               <div class="card-header d-flex justify-content-between rounded border-bottom-0">
                  <div class="header-title">

                     <h4 class="text-primary">{{$shallowExercise->title}}</h4>
                     <div class="image-block position-relative">
                        <p class="mb-0">{!! ($shallowExercise->detail) !!}</p>
                     </div>

                  </div>
               </div>
             </div>

             @if(isset($shallowExercise->file) && $shallowExercise->file !== '')

                    <div class="card">
                    <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                    <h5 class="card-title">View File:</h5>
                    </div>
                    </div>

                    <div class="card-body">
                    <div class="image-block position-relative">
                    <p class="mb-0">  <a href="{{ asset('storage/up_data/shallow_courses/upload/'.$shallowExercise->purchased_user_id.'/'.$shallowExercise->file)}}" target="_blank">{{ $shallowExercise->file  }}</a>
                    </p>
                    </div>
                    </div>
                </div>

                @endif


               @if(isset($shallowExercise->file))

                 <input type="hidden" value="{{$shallowExercise->purchased_user_id}}" name="course_user_id">

                     <div class="row">
                        <div class="col-lg-12">
                           <div class="card" style="height: auto;justify-content: center;">
                              <div class="row">

                                    <div class="form-group" style="margin-left: 2rem; margin-top:1rem;width:90%">

                                        <label for="">Provide User Feedback:</label>
                                        <textarea class="form-control" rows="4"  name="feedback">{{$submission->exercise_marking_result[0]['feedback'] ?? '' }}</textarea>
                                        <hr>
                                        <label>Verify User Response: &nbsp;</label>
                                        &nbsp;
                                        <input class="form-check-input ml-1" {{ isset($submission->exercise_marking_result[0])  && $submission->exercise_marking_result[ 0]['status']==='satisfactory'  ? "checked" : "" }}   type="radio" id="inlineRadio1" value='satisfactory' name="status"  required>
                                            <label class="form-check-label ml-4" for="inlineRadio1"> Satisfactory</label>
                                         &nbsp;
                                        <input class="form-check-input ml-1"  {{ isset($submission->exercise_marking_result[ 0])  && $submission->exercise_marking_result[ 0]['status']==='non_satisfactory'  ? "checked" : "" }} type="radio" id="inlineRadio1" value='non_satisfactory' name="status"  required>
                                        <label class="form-check-label ml-4" for="inlineRadio1"> Not Satisfactory</label>

                                    </div>

                              </div>
                           </div>
                        </div>
                     </div>

               @endif

            <div class="row" style="margin-top: 2rem;">
               <div class="col-lg-12">
                  <div class="card" style="height: 15rem;justify-content: center;">
                     <div class="row">
                        <div class="col-md-8">
                           <h4 class="card-title" style="padding-left: 2rem;color: #8C68CD;">Examiner Comments for the exercise</h4>
                        </div>
                        <div class="col-md-4">
                           <button class="btn btn-light" disabled style="margin-left: 6rem">This is shown to the user</button>
                        </div>
                        <form>
                           <div class="form-group" style="margin-left: 2rem; margin-top:1rem;width:93%">
                              <textarea class="form-control" id="" name="comments" required  rows="4">{{$submission->comments ?? '' }}</textarea>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div style="display: flex;justify-content: flex-end;">
                <button type="submit" id="resetFormButton" class="btn btn-primary btn-block">  {{ __('SUBMIT MARKING & CONTINUE') }}</button>
            </div>

         </div>
          @endif
            </form>
      </div>
   </div>
</x-app-layout>