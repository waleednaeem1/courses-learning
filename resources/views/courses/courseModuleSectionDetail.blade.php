<x-app-layout>

<section id="saasio-breadcurmb" class="saasio-breadcurmb-section">
      <div class="container">
         <div class="breadcurmb-title text-center">
            <h2>Section: {{$data['section']->title}}</h2>
         </div>

      </div>
  </section>

   <div class="content-page mt-4" id="content-page">
      <div class="container">
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
         <div class="row">
            <div class="col-lg-12"><br>
               <div class="card">

                  <div class="card-body">
                     <div class="image-block position-relative">
                        <p class="mb-0">{!! ($data['section']->detail) !!}</p>
                     </div>
                     @if(isset($data['section']->video_id) && $data['section']->video_id !== '')
                        <div class="image-block position-relative">
                           <iframe src="{{'https://player.vimeo.com/video/'.$data['section']->video_id}}" width="100%" height="500" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
         <div class="row" style="margin-bottom:2rem;">
            <div class="col-md-6">
               <a href="{{ url($data['links'][0]['previous']) }}" class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.75rem;color:#fff" id="button1">Previous</a>
            </div>
            <div class="col-md-6" style="padding-left: 29rem;">
               <a href="{{ url($data['links'][1]['next']) }}" class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.75rem;color:#fff" id="button2">Next</a>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">This module contains the following sections and exercises​</h4>
                     </div>
                  </div>
               </div>
            </div>
         </div><br>
         <div class="row">
            <div class="col-lg-12">
               <div id="faqAccordion">
                  <div class="row">
                      <div class="col-lg-12">
                          <div class="accordion" id="accordionExample">
                              {{-- @foreach($data['module']['sections'] as $section) --}}
                              @foreach($data['all_sections'] as $section)
                                 <div class="accordion-item mb-3">
                                    <h2 class="accordion-header" id="heading{{ $loop->iteration }}">
                                       <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                                           Section:  {{ $section->title }}
                                       </button>
                                    </h2>
                                  <div id="collapse{{$loop->iteration}}" class="accordion-collapse collapse show" aria-labelledby="heading{{$loop->iteration}}" data-bs-parent="#accordionExample">
                                      <div class="accordion-body">

                                             <a style="margin-left: 3rem;">
                                               <b> Exercises:</b>
                                            </a>
                                              @foreach($section['exercise'] as $exercise)

                                                  <div class="pl-4" style="margin-left: 2rem;">
                                                      <a>
                                                          <p>{{$exercise->title}}</p>
                                                      </a>
                                                  </div>

                                              @endforeach

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