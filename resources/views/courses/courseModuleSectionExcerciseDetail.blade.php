<x-app-layout>
  <section id="saasio-breadcurmb" class="saasio-breadcurmb-section">
      <div class="container">
         <div class="breadcurmb-title text-center">
            <h2>Exercise: {{$data['exercise']->title}}</h2>
         </div>

      </div>
  </section>

   <div class="content-page mt-4" id="content-page">
      <div class="container" id="page-container">

         <div class="row">
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
                        <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                       @else
                        <div class="progress-bar" role="progressbar" style="width: {{$data['percentage']}}%;" aria-valuenow="{{$data['percentage']}}" aria-valuemin="0" aria-valuemax="100">{{$data['percentage']}}%</div>
                      @endif

                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row mt-4">
            <div class="col-lg-12">
               <div class="">
                @if(isset($data['exercise']['exercise_marking']))

                <div class="alert alert-info" role="alert" style="color: #0c5460;background-color: #d1ecf1;border-color: #bee5eb;">

                <h4> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                </svg> &nbsp;<b>Examiner Comments<b></h4>

                {{ (($data['exercise']['exercise_marking']->comments))}}
                </div>

                @endif
               </div>

               @if(isset($data['exercise']->detail) || isset($data['exercise']->video_id))
               <div class="card">

                  <div class="card-body">
                     <div class="image-block position-relative">
                        <p class="mb-0">{!! ($data['exercise']->detail) !!}</p>
                     </div>
                     @if(isset($data['exercise']->video_id) && $data['exercise']->video_id !== '')
                        <div class="image-block position-relative">
                           <iframe src="{{'https://player.vimeo.com/video/'.$data['exercise']->video_id}}" width="100%" height="500" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                     @endif
                  </div>
               </div>
                @endif

               <form class="mt-4" id="exercise-form"  method="POST" enctype="multipart/form-data" action="{{ route('courseQuizSave') }}">
                  <input  type="hidden" value='{{  $data['course']->id}}' name="course_id">
                  <input type="hidden" value='{{  $data['module']->id}}' name="module_id">
                  <input  type="hidden" value='{{  $data['section']->id}}' name="section_id">
                  <input  type="hidden" value='{{  $data['exercise']->id}}' name="exercise_id">
                  {{ csrf_field() }}

                  @if($data['exercise']->type == 'quiz')
                     @foreach($data['exercise']['questions'] as $key=> $question)
                        @if($question->type)
                           <div class="card mb-4">
                              <div class="card-header d-flex justify-content-between">
                                 <div class="header-title">
                                    <h5 class="card-title" >{{$question->question}} ({{$question->score}} Mark) </h5>

                                    @if($data['is_feedback_module']==0)
                                     @if($question->type === 'mcq' || $question->type === 'feedback_mcq')
                                       <span  @if($data['is_disable']==1)  style="display:block;" @else  style="display:none;"  @endif  id="question_success_{{$question->id}}" class="correct-answer text-success"><svg style="width: 20px;" class="svg-inline--fa fa-check-circle fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path></svg></span>

                                       <span style="display:none;"  id="question_wrong_{{$question->id}}" class="incorrect-answer text-danger"><svg style="width: 20px;" class="svg-inline--fa fa-times-circle fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg></span>
                                      @endif
                                    @endif

                                    <input type='hidden' name='questions[]' value="{{$question->id}}">
                                    <input type='hidden' name='question_type[]' value="{{$question->type}}">
                                 </div>
                              </div>

                              @if($question->type === 'mcq' || $question->type === 'feedback_mcq')
                                 <div class="form-group mt-3" style="margin-left: 2rem;">

                                    @if(isset($data['FeedBackModule']))

                                    @foreach($question['answers'] as $answer)
                                       <div class="form-check form-check-inline">
                                         <input class="form-check-input" type="radio" id="inlineRadio{{$answer->id}}" value='{{$answer->id}}' name="{{$answer->question_id}}"
                                             @if(isset($data['FeedBackModule']) && (unserialize($data['FeedBackModule']['feedback_result'])[$answer->question_id]==$answer->id) ) checked @endif
                                           disabled='disabled'>
                                        <label class="form-check-label" for="inlineRadio{{$answer->id}}"> {{$answer->answer}}</label>
                                       </div>
                                    @endforeach

                                    @else
                                    @foreach($question['answers'] as $answer)
                                       <div class="form-check form-check-inline">
                                         <input class="form-check-input" type="radio" id="inlineRadio{{$answer->id}}" value='{{$answer->id}}' name="{{$answer->question_id}}"  required
                                             @if(isset($data['result']) && (unserialize($data['result']->result)[$answer->question_id]==$answer->id) ) checked @endif
                                          @if($data['is_disable']==1)  disabled='disabled' @endif>
                                        <label class="form-check-label" for="inlineRadio{{$answer->id}}"> {{$answer->answer}}</label>
                                       </div>
                                    @endforeach

                                   @endif

                                 </div>
                              @elseif ($question->type == 'reflective_question')

                                @if(isset($data['FeedBackModule']))

                                 <div class="form-group mt-3" style="margin-left: 2rem; margin-top:1rem;width:90%">
                                    <input type="text" class="form-control" value="@if(isset($data['FeedBackModule']) ) {{unserialize($data['FeedBackModule']['feedback_result'])[$question->id]}} @endif" name="{{$question->id}}"
                                       disabled='disabled' >
                                 </div>

                                @else

                                 <div class="form-group mt-3" style="margin-left: 2rem; margin-top:1rem;width:90%">
                                    <input type="text" class="form-control" value="@if(isset($data['result']) ) {{unserialize($data['result']->result)[$question->id]}} @endif" name="{{$question->id}}" required
                                       {{ ( $data['is_coach_feedback'] == 1) ? 'disabled' : '' }}>
                                 </div>

                                @endif



                              @elseif ($question->type == 'reflective_question_multiline')

                                @if(isset($data['FeedBackModule']))

                                 <div class="form-group mt-3" style="margin-left: 2rem; margin-top:1rem;width:90%">
                                    <textarea  disabled= 'disabled' class="form-control" name="{{$question->id}}" rows="4" required>@if(isset($data['FeedBackModule']) ) {{unserialize($data['FeedBackModule']['feedback_result'])[$question->id]}} @endif</textarea>
                                 </div>
                                 @else

                                 <div class="form-group mt-3" style="margin-left: 2rem; margin-top:1rem;width:90%">
                                    <textarea   {{ ( $data['is_coach_feedback'] == 1) ? 'disabled' : '' }} class="form-control" name="{{$question->id}}" rows="4" required>@if(isset($data['result']) ) {{unserialize($data['result']->result)[$question->id]}} @endif</textarea>
                                 </div>
                                @endif

                              @elseif ($question->type == 'feedback_question_multiline')

                                @if(isset($data['FeedBackModule']))

                                  <div  class="form-group mt-3" style="margin-left: 2rem; margin-top:1rem;width:90%">
                                    <textarea disabled= 'disabled' class="form-control" name="{{$question->id}}" rows="4" required>@if(isset($data['FeedBackModule']) ) {{unserialize($data['FeedBackModule']['feedback_result'])[$question->id]}} @endif</textarea>
                                  </div>

                                    @else

                                  <div class="form-group mt-3" style="margin-left: 2rem; margin-top:1rem;width:90%">
                                    <textarea {{ ( $data['is_coach_feedback'] == 1) ? 'disabled' : '' }}  class="form-control" name="{{$question->id}}" rows="4" required>@if(isset($data['result']) ) {{unserialize($data['result']->result)[$question->id]}} @endif</textarea>
                                  </div>
                                @endif


                              @endif

                                @if($question->type === 'feedback_question_multiline' || $question->type === 'reflective_question' || $question->type === 'reflective_question_multiline')

                                @if(isset($data['exercise']['exercise_marking']))


                                <div class="form-group mt-3" style="margin-left: 2rem; margin-top:1rem;width:90%">
                                @foreach($data['exercise']['exercise_marking']['exercise_marking_result'] as $result)

                                    @if($result->question_id==$question->id)

                                        @if($result->status==='satisfactory')
                                        <div class="alert alert-success" role="alert" style="color: #155724;background-color: #d4edda;border-color: #c3e6cb;">
                                         Feedback: {{$result->feedback}}
                                         </div>
                                    @else
                                        <div class="alert alert-info" role="alert" style="color: #0c5460;background-color: #d1ecf1;border-color: #bee5eb;">
                                        Feedback: {{$result->feedback}}
                                        </div>
                                     @endif

                                    @endif
                                @endforeach

                                    </div>
                                    @endif
                                @endif

                           </div>
                        @endif
                     @endforeach
                     <div class="row" style="margin-bottom:2rem;">
                        <div class="col-md-6">
                           <a href="{{ url($data['links'][0]['previous']) }}" class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.75rem;color:#fff" id="button1">Previous</a>
                        </div>
                        <div class="col-md-6" style="padding-left: 29rem;">
                           <input  type="hidden" value='{{ ($data['links'][1]['next']) }}' name="next" >
                           <button type="submit"  class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.1rem;">Next</button>
                        </div>
                     </div>
                  @elseif ($data['exercise']->type == 'video')
                     {{-- <div style="margin-top:2rem;margin-bottom:2rem">
                        <video width="100%" height="500px" controls>
                           <source src="{{asset('images/videos/3.mp4')}}">
                        </video>
                     </div> --}}
                     {{-- @if(isset($data['exercise']->video_id) && $data['exercise']->video_id !== '')
                        <div style="margin-top:2rem;margin-bottom:2rem">
                           <iframe src="{{'https://player.vimeo.com/video/'.$data['exercise']->video_id}}" width="100%" height="500" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                     @endif --}}
                     <div class="row" style="margin-bottom:2rem;">
                        <div class="col-md-6">
                           <a href="{{ url($data['links'][0]['previous']) }}" class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.75rem;color:#fff" id="button1">Previous</a>
                        </div>
                        <div class="col-md-6" style="padding-left: 29rem;">
                           <input  type="hidden" value='{{ ($data['links'][1]['next']) }}' name="next" >
                           <button type="submit"  class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.1rem;">Next</button>
                        </div>
                     </div>
                  @elseif ($data['exercise']->type == 'file_upload')

                     <div class="row" style="margin-bottom:2rem;padding-left: 1rem">

                        <div id="info-text"></div>
                         @if($data['exercise']->file)

                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                <h5 class="card-title">View File:</h5>
                                </div>
                              </div>

                              <div class="card-body">
                              <div class="image-block position-relative">

                                <p class="mb-0">  <a href="{{ asset('storage/up_data/shallow_courses/upload/'.auth()->user()->id.'/'.$data['exercise']->file)}}" target="_blank">{{ $data['exercise']->file }}</a>
                                </p>
                              </div>
                             </div>
                            </div>

                                @if(isset($data['exercise']['exercise_marking']))

                                <div class="form-group mt-3 pl-0">
                                  @php $coachFeedback=$data['exercise']['exercise_marking']['exercise_marking_result'][0];  @endphp

                                        @if($coachFeedback->status==='satisfactory')
                                        <div class="alert alert-success" role="alert" style="color: #155724;background-color: #d4edda;border-color: #c3e6cb;">
                                         Feedback: {{$coachFeedback->feedback}}
                                         </div>
                                    @else
                                        <div class="alert alert-info" role="alert" style="color: #0c5460;background-color: #d1ecf1;border-color: #bee5eb;">
                                        Feedback: {{$coachFeedback->feedback}}
                                        </div>
                                     @endif

                                    </div>
                                @endif

                        @else
                         <div class="d-flex p-3">
                           <input type="file" name="uploadDoc" id="uploadDoc" required class="form-control" accept=".pdf,.doc,.docx,.txt,.ppt" placeholder="Upload your document" style="border:none;">
                        </div>
                        @endif
                         <input  type="hidden" value='{{$data['exercise']->type}}' name="exercise_type">
                        <div class="col-md-6">
                           <a href="{{ url($data['links'][0]['previous']) }}" class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.75rem;color:#fff" id="button1">Previous</a>
                        </div>
                        <div class="col-md-6" style="padding-left: 29rem;">
                           <input  type="hidden" value='{{ ($data['links'][1]['next']) }}' name="next" >
                           <button type="submit"  class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.1rem;">Next</button>
                        </div>
                     </div>
                  @elseif ($data['exercise']->type == 'file_download')
                     <div style="margin-top:2rem;margin-bottom:2rem;margin-left:2rem">
                        @php
                        $path ='';
                        if(app()->environment() == 'local'){
                           $path = 'http://127.0.0.1:8000/up_data/shallow_courses/download/'.$data['exercise']->file;

                        }else{
                           $path = 'https://web.dvmcentral.com/up_data/shallow_courses/download/'.$data['exercise']->file;
                        }
                        @endphp
                        <a href="{{$path }}" target="_blank">Click here to download the document</a>
                     </div>
                     <div class="row" style="margin-bottom:2rem;">
                        <div class="col-md-6">
                           <a href="{{ url($data['links'][0]['previous']) }}" class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.75rem;color:#fff" id="button1">Previous</a>
                        </div>
                        <div class="col-md-6" style="padding-left: 29rem;">
                           <input  type="hidden" value='{{ ($data['links'][1]['next']) }}' name="next" >
                           <button type="submit"  class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.1rem;color:#fff">Next</button>

                        </div>
                     </div>
                  @endif
               </form>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">This section contains the following exercises</h4>
                     </div>
                  </div>
               </div>
            </div>
         </div><br>
         <div class="row">
            <div class="col-lg-12">
               <div id="faqAccordion" >
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="accordion" id="accordionExample">
                           @php $index = 1; @endphp
                           <div class="accordion-item mb-3">
                              <h2 class="accordion-header" id="heading{{$index}}">
                                 <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$index}}" aria-expanded="true" aria-controls="collapse{{$index}}">
                                   Section:  {{$data['section']->title}}
                                 </button>
                              </h2>
                              <div id="collapse{{$index}}" class="accordion-collapse collapse show" aria-labelledby="heading{{$index}}" data-bs-parent="#accordionExample">
                                 <div class="accordion-body">
                                    <div id="nestedAccordion" class="accordion">
                                       @foreach($data['all_exercise'] as $exercise)
                                          <div id="nestedCollapse{{$index}}" class="accordion-collapse collapse show" aria-labelledby="nestedHeading{{$index}}" data-bs-parent="#nestedAccordion">
                                             <div class="accordion-body" style="margin-left: 2rem;background-color: var(--bs-primary-tint-90);height: 60px;margin-bottom: 1rem;">
                                                <a>
                                                   <p>Exercise:   {{$exercise->title}}</p>
                                                </a>
                                             </div>
                                          </div>
                                          @php $index++; @endphp
                                       @endforeach
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>

<script>

   function alertConfirmModule(msg,icon)
     {
        Swal.fire({
              text: msg,
              icon: icon,
           });
     }
   $(document).ready(function(){
    var FeedBackModule = <?php echo (isset($data['FeedBackModule']) && $data['FeedBackModule']) ? $data['FeedBackModule'] : 'null'; ?>;

      $('#exercise-form').submit(function(e){
         e.preventDefault();
         if('{{$data['is_coach_feedback']}}'==1 ||  ('{{$data['exercise']->type}}'==='file_upload' && '{{$data['exercise']->file}}' !='' ) || FeedBackModule !=null || '{{$data['exerciseComplete']}}'==1 ){
            var base_url = window.location.origin;
            window.location.href =base_url+'/'+$('input[name = next]').val();
         }else{
            var form = $(this);
            var formData = new FormData(this);
             var homeUrl= '{{route("home")}}';
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': csrfToken
                }
            });
            $.ajax({
                url:'/course/quiz/save',
                method:'POST',
                data:formData,
                processData:false,
                dataType:'json',
                contentType:false
            }).done(function(response){
               if(response.only_text==1 ){
                  window.location.href = response.next ;
               }
               if(response.all_exist==1 ){
                  var errors=JSON.parse(response.data);
                     $('html, body').animate({
                        scrollTop: $("#exercise-form").offset().top
                    }, 1000);
                  $('.correct-answer').css('display','none');
                  $('.incorrect-answer').css('display','none');
                  for (const property in errors) {
                     if(errors[property].is_true){
                        $('#question_success_'+errors[property].question_id).css('display','block');
                        $('#question_wrong_'+errors[property].question_id).css('display','none');
                     }else{
                        $('#question_success_'+errors[property].question_id).css('display','none');
                        $('#question_wrong_'+errors[property].question_id).css('display','block');
                     }
                  }

                  if(!response.is_error){
                     window.location.href = response.next ;
                  }
                  return false;
               }
               if(response.course_complete && response.success)
               {
                  var title='{{$data['course']->title}}';
                  var html = `<div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                        <div class="header-title">
                                            <h3 class="card-title">Certificate</h3>
                                        </div>
                                        </div>
                                        <div class="card-body">
                                        <h4>Congratulations!</h4>
                                        <br>
                                            <p>  You have successfully completed the ${title} programme. Your certificate is available to download now from your dashboard.

                                            Why not proceed to the next programme which you can find out more about on our website. <a href="https://colorfulce.vetandtech.com">Colorful CE</a></p>
                                            <br>
                                            All the best
                                            <br>
                                            The Colorful CE Team
                                            <br>
                                            <form method="post" action="{{route('courseCertificateDownload')}}">
                                            @csrf
                                            <input type="hidden" name="course_id" value="${response.sectionCompleteDetail.course_id}">
                                            <input type="hidden" name="module_id" value="${response.sectionCompleteDetail.module_id}">
                                            <input type="hidden" name="section_id" value="${response.sectionCompleteDetail.section_id}">
                                            <button class="btn btn-primary text-center" type="submit">DOWNLOAD YOUR CERTIFICATE</button>
                                            <a class="btn btn-primary text-center text-white" style='float: right;' href="${homeUrl}" >Finish</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                  $("#page-container").html(html);
                  return;
               }
               if(response.is_last_exercise==1 && response.is_last_exercise_count==2){
                  window.location.href = response.next;
               }
               if (response.success) {
                  window.location.href = response.next;
               }
               else {
                  var errors=JSON.parse(response.data);
                    $('html, body').animate({
                        scrollTop: $("#exercise-form").offset().top
                    }, 1000);
                    //document.getElementById('exercise-form').scrollIntoView({ behavior: 'smooth', block: 'start', inline: 'nearest' })
                  $('.correct-answer').css('display','none');
                  $('.incorrect-answer').css('display','none');
                  errors.forEach((element) => {
                     if(element.is_true){
                        $('#question_success_'+element.question_id).css('display','block');
                        $('#question_wrong_'+element.question_id).css('display','none');
                     }else{
                        $('#question_success_'+element.question_id).css('display','none');
                        $('#question_wrong_'+element.question_id).css('display','block');
                     }
                  });
               }
            });
         }
      });
   });
</script>