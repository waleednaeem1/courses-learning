<x-app-layout>
   <section id="saasio-breadcurmb" class="saasio-breadcurmb-section">
      <div class="container">
         <div class="breadcurmb-title text-center">
            <h2>Courses</h2>
         </div>
      </div>
  </section>
   <div class="container mt-3">
      <div class="row">
         @if(isset($data['course_list']) && count($data['course_list']) > 0)
            <div class="col-lg-12">
               {{-- <div class="card shadow-none p-0">
                  <div class="card-header d-flex justify-content-between rounded border-bottom-0">
                     <div class="header-title">
                        <h4 class="card-title">Courses</h4>
                     </div>
                  </div>
               </div> --}}
               <div class="row updateFeed">
                  @foreach($data['course_list'] as $course)
                     <div class="col-sm-6 col-md-6 col-lg-4">
                        <div class="card card-block card-stretch card-height product radius-lg shadow box-height-fix" style="border-radius: 10px;">
                           <div class="card-body">
                              <div class="d-flex align-items-center justify-content-between pb-3">
                                 <div class="d-flex align-items-center">
                                    <div class="ms-2">
                                       <h6>

                                          @if(isset($course['enrollments']) && count($course['enrollments']) > 0 && $course->id == $course['enrollments'][0]->course_id)

                                             @if ($course->marking_user == 'coach')
                                                @if($course['getShallowCourseData'][0]->coach_id == '' || $course['getShallowCourseData'][0]->coach_id == null)
                                                   <a style="color: #8C68CD; font-size: 15px;" onclick="enrollCoach('{{ $course->slug }}')">{{$course->title}}</a>
                                                @else

                                                   {{-- <a href="{{route('courseDetail',  ['cat_slug' => $data['category']->slug,'course_slug' => $course->slug])}}">{{$course->title}}</a> --}}
                                                   <a href="{{route('courseDetail',  ['course_slug' => $course['getShallowCourseData'][0]->slug])}}" style="color: #8C68CD; font-size: 15px;">{{$course->title}}</a>
                                                @endif
                                             @else

                                                {{-- <a href="{{route('courseDetail',  ['cat_slug' => $data['category']->slug,'course_slug' => $course->slug])}}">{{$course->title}}</a> --}}
                                                <a href="{{route('courseDetail',  ['course_slug' => $course['getShallowCourseData'][0]->slug])}}" style="color: #8C68CD; font-size: 15px;">{{$course->title}}</a>
                                             @endif
                                          @else

                                             <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Purchase this course for further processing!">
                                                <h6><a style="color: #8C68CD; font-size: 15px;">{{$course->title}}</a></h6>
                                             </span>
                                          @endif
                                       </h6>
                                    </div>
                                 </div>
                              </div>
                              <div class="image-block position-relative">
                                 {{-- <img src="{{asset('images/store/01.jpg')}}" class="img-fluid w-100 rounded" alt="product-img"> --}}
                                @if($course->marking_user==='admin')

                                 <img src="https://web.dvmcentral.com/up_data/courses/thumbnails/{{$course->thumbnail}}" class="w-100 rounded" style="height:252px;width:168px;object-fit: contain;margin-top: 7px !important;" alt="course-img">
                                 @else
                                 <img src="https://web.dvmcentral.com/up_data/courses/thumbnails/{{$course->thumbnail}}" class="w-100 rounded" style="height:252px;width:168px;object-fit: contain;" alt="course-img">
                                 @endif
                                 {{-- <div class="offer">
                                    <div class="offer-title">20%</div>
                                 </div> --}}
                                 {{-- <h6 class="price"><span class="regular-price text-dark pr-2">$87.00</span>$75.00</h6> --}}
                              </div>

                              <div class="product-description mt-3">
                                 {{-- <h6 class="mb-1">{{$course['getCourseType']->name}}</h6> --}}
                                 @if(isset($course['enrollments']) && count($course['enrollments']) > 0)
                                    <button type="button" class="btn btn-primary d-block w-100 mt-3" onclick="enrollCourse('{{ $course->slug }}')" data-bs-toggle="modal" data-bs-target="#enrollCourse">
                                       Enrolled
                                    </button>
                                 @else


                                    @php
                                   $result=getPrerequisiteCourses($course->prerequisite_courses);
                                    @endphp

                                     @if($result===0)
                                      <span  tabindex="0" data-bs-toggle="tooltip" title="Purchase and complete prerequisite courses first!">
                                        <button type="button" class="btn btn-primary d-block w-100 mt-4" disabled='disabled'>
                                       Enroll
                                    </button>
                                     </span>
                                     @elseif($result ===null || $result===1)

                                     <button type="button" class="btn btn-primary d-block w-100 mt-4" onclick="enrollCourse('{{ $course->slug }}')" data-bs-toggle="modal" data-bs-target="#enrollCourse">
                                       Enroll
                                    </button>
                                   @endif
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  @endforeach
               </div>
            </div>
            <div id="enrollCoach" class="modal fade bd-example-modal-lg" style="margin-top:4rem" tabindex="-1" role="dialog"  aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     <form>
                        <div class="modal-header">
                           <h5 class="modal-title">Select coach first</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                           </button>
                        </div>
                        <div class="modal-body">
                           <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                           <div class="form-group col-sm-6">
                              {!! Form::label('coach', 'Select Coach:') !!}<span class="text-danger">*</span>
                              <div id="div_coach">
                                 <select id="coach-select" class="form-control"></select>
                              </div>
                           </div>
                           <input type="hidden" id="courseSlug" name="courseSlug" value=""/>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                           <button type="button" disabled class="btn btn-primary applyCoach">Add Coach</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         @else
            <div style="margin-top:2rem">
               <h4 style="margin-bottom: 2rem;color: #8C68CD;margin-left:4rem">No course available in {{$data['category']->name}} category</h4>
            </div>
         @endif
      </div>
      <div id="enrollCourse" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="enrollCourseTitle" aria-hidden="true">
         <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="image-section position-relative" id="image-section">
                  <img id="enrolled-course-thumbnail" src="https://web.dvmcentral.com/up_data/courses/thumbnails/" class="img-fluid w-100 rounded" style="height:252px;width:168px;object-fit:contain" alt="product-img">
               </div>
               <div class="row">
                  <div class="col-md-9">
                     <h5 class="modal-title" id="enrollCourseTitle" style="padding-left: 1rem;padding-top: 1rem;"></h5>
                  </div>
                  <div class="col-md-3">
                     <h5 class="price" id="enrollCoursePrice" style="padding-top: 1.5rem; padding-left: 2rem;"></h5>
                  </div>
               </div>
               <div class="modal-body">
                  <p id="enrollCourseDescription" style="padding-top: 1rem;"></p>
               </div>
               <div>
                  {{-- <h5 class="modal-title" id="enrollCourseModule"></h5> --}}
               </div>
               <div class="modal-footer" id="addToCartBtnDiv" style="display:none;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button id="addToCartBtn" type="button" onclick="addToCart()" class="btn btn-primary">Add to Cart</button>
               </div>
               <div class="modal-footer" id="alreadyinCart" style="display:none;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" disabled class="btn btn-primary">Already in Cart</button>
               </div>
               <div class="modal-footer" id="alreadyEnrolled" style="display:none;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" disabled class="btn btn-primary">Purchased</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>