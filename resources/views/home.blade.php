<x-app-layout>
    <body class="saas-classic">
        <!-- preloader - start -->
        {{-- <div id="preloader" class="saas-classic-preloader"></div> --}}
        <div class="up">
            <a href="#" id="scrollup" class="saas-classic-scrollup text-center"><i class="fas fa-angle-up"></i></a>
        </div>
        <section id="saasio-breadcurmb" class="saasio-breadcurmb-section">
            <div class="container">
                <div class="breadcurmb-title text-center">
                    <h2>Home</h2>
                </div>
                <!--<div class="breadcurmb-item-list text-center ul-li">
                    <ul class="saasio-page-breadcurmb">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                    </ul>
                </div> -->
            </div>
        </section>
        <div id="s2-pricing">
            <div class="container mt-3">
                @if (auth()->user()->type == 'admin')
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    ​Welcome to your Colorful CE Account Administrator dashboard
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        You will notice the navigation tabs above which allow you to manage your team as well as browse and purchase courses and events for them.
                                    </p>
                                    <p class="card-text">
                                        When a colleague makes a request for you to pay for a course it will appear here when you log in. You can pay their request immediately using a credit or debit card or download the invoice and forward it onto your head office for payment via bacs. Alternatively, you can cancel the request.​
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    Notice Board
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        There are no notices at present
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->type != 'admin')
                    {{-- <div class="card mt-3">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                            <h4 class="card-title">My Courses</h4>
                            </div>
                        </div>
                    </div> --}}
                    @if(count($courseEnrollments) > 0)
                        <div class="purchased-courses-wrapper updateFeed">
                            @foreach($courseEnrollments as $course)
                                @if(!empty($course['course']))
                                    @if ($course['course']->marking_user == 'coach')

                                        @if($course['course']->coach_id == '' || $course['course']->coach_id == null)
                                            {{-- <a class="mt-1" onclick="enrollCoach('{{ $course->slug }}')">{{$course->title}}</a> --}}
                                            <a onclick="enrollCoach('{{ $course['course']->slug }}')" class="iq-sub-card">
                                                <div class="card mb-0 radius-lg shadow box-height-fix" >
                                                    <div class="align-items-center card-body d-flex p-3">
                                                        <div class="mt-0" style="">
                                                            @if (isset($course['course']->thumbnail) && $course['course']->thumbnail !== '')
                                                                <img class="avatar-120 rounded" style="object-fit:contain" src="https://web.dvmcentral.com/up_data/courses/thumbnails/{{$course['course']->thumbnail}}"alt="">
                                                            @else
                                                                <img class="avatar-100 rounded" src="{{asset('images/user/Users_60x60.png')}}" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="p-3">
                                                            <h6>{{$course['course']->title}}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @else
                                            {{-- <a href="{{route('courseDetail',  ['cat_slug' => $course['course']['category']->slug,'course_slug' => $course['course']->slug])}}" class="iq-sub-card"> --}}
                                            <a href="{{route('courseDetail',  ['course_slug' => $course['course']->slug])}}" class="iq-sub-card">
                                                <div class="card mb-0 radius-lg shadow box-height-fix">
                                                    <div class="align-items-center card-body d-flex p-3">
                                                        <div class="mt-0" style="">
                                                            @if (isset($course['course']->thumbnail) && $course['course']->thumbnail !== '')
                                                                <img class="avatar-120 rounded" style="object-fit:contain" src="https://web.dvmcentral.com/up_data/courses/thumbnails/{{$course['course']->thumbnail}}"alt="">
                                                            @else
                                                                <img class="avatar-100 rounded" src="{{asset('images/user/Users_60x60.png')}}" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="p-3">
                                                            <h6>{{$course['course']->title}}</h6>
                                                        @if(checkCourseComplete($course['course']->id,$course['course']->marking_user)==1)
                                                                <div class="form-check form-check-inline">
                                                                <div class="form-check" style="margin-left:-1rem">
                                                                    <form method="post" action="{{route('courseCertificateDownload')}}">
                                                                        @csrf
                                                                    <input type="hidden" name="course_id" value="{{$course['course']->id}}">
                                                                        <input type="hidden" name="course_marking_user" value="{{$course['course']->marking_user}}">
                                                                        <button class="btn btn-primary text-center" type="submit">DOWNLOAD YOUR CERTIFICATE</button>
                                                                    </form>
                                                                </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    @else
                                        {{-- <a href="{{route('courseDetail',  ['cat_id' => $course['course']->course_category_id,'course_id' => $course['course']->id])}}" class="iq-sub-card"> --}}
                                        {{-- <a href="{{route('courseDetail',  ['cat_slug' => $course['course']['category']->slug,'course_slug' => $course['course']->slug])}}" class="iq-sub-card"> --}}
                                        <a href="{{route('courseDetail',  ['course_slug' => $course['course']->slug])}}" class="iq-sub-card">
                                            <div class="card mb-0 radius-lg shadow box-height-fix">
                                                <div class="align-items-center card-body d-flex p-3">
                                                    <div class="mt-0" style="">
                                                        @if (isset($course['course']->thumbnail) && $course['course']->thumbnail !== '')
                                                            <img class="avatar-120 rounded" style="object-fit:contain" src="https://web.dvmcentral.com/up_data/courses/thumbnails/{{$course['course']->thumbnail}}"alt="">
                                                        @else
                                                            <img class="avatar-100 rounded" src="{{asset('images/user/Users_60x60.png')}}" alt="">
                                                        @endif
                                                    </div>
                                                    <div class="p-3">
                                                        <h6>{{$course['course']->title}}</h6>
                                                        {{-- <small>{{ $course['course']->created_at->diffForHumans() }}</small> --}}
                                                        @if(checkCourseComplete($course['course']->id,$course['course']->marking_user)==1)
                                                            <div class="form-check form-check-inline">
                                                            <div class="form-check" style="margin-left:-1rem">
                                                                <form method="post" action="{{route('courseCertificateDownload')}}">
                                                                    @csrf
                                                                    <input type="hidden" name="course_id" value="{{$course['course']->id}}">
                                                                    <input type="hidden" name="course_marking_user" value="{{$course['course']->marking_user}}">
                                                                    <button class="btn btn-primary text-center" type="submit">Download Your Certificate</button>
                                                                </form>
                                                            </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @else
                        {{-- <div style="margin-top:2rem">
                            <h4 style="margin-bottom: 2rem;color:#8C68CD;">You have no purchased courses yet</h4>
                            <a href="{{route('coursesList')}}" class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.75rem;color:#fff">View Courses</a>
                        </div> --}}
                        @if(isset($data['course_list']) && count($data['course_list']) > 0)
                            <div class="col-lg-12">
                                <div class="card shadow-none p-0">
                                    <div class="card-header d-flex justify-content-between rounded border-bottom-0">
                                        <div class="header-title mt-2">
                                            <h4 class="card-title">Purchase Courses</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="row updateFeed mt-3">
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
                                                                        <a class="mt-1" onclick="enrollCoach('{{ $course->slug }}')">{{$course->title}}</a>
                                                                        @else
                                                                        {{-- <a href="{{route('courseDetail',  ['cat_slug' => $data['category']->slug,'course_slug' => $course->slug])}}">{{$course->title}}</a> --}}
                                                                        <a href="{{route('courseDetail',  ['course_slug' => $course['getShallowCourseData'][0]->slug])}}">{{$course->title}}</a>
                                                                        @endif
                                                                    @else
                                                                        {{-- <a href="{{route('courseDetail',  ['cat_slug' => $data['category']->slug,'course_slug' => $course->slug])}}">{{$course->title}}</a> --}}
                                                                        <a href="{{route('courseDetail',  ['course_slug' => $course['getShallowCourseData'][0]->slug])}}">{{$course->title}}</a>
                                                                    @endif
                                                                @else
                                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Purchase this course for further processing!">
                                                                        <h6><a style="color: #8C68CD">{{$course->title}}</a></h6>
                                                                    </span>
                                                                @endif
                                                            </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="image-block position-relative">
                                                        {{-- <img src="{{asset('images/store/01.jpg')}}" class="img-fluid w-100 rounded" alt="product-img"> --}}
                                                        <img src="https://web.dvmcentral.com/up_data/courses/thumbnails/{{$course->thumbnail}}" class="w-100 rounded" style="height:252px;width:168px;object-fit: contain;" alt="course-img">
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
                                                            // $result=getPrerequisiteCourses($course->prerequisite_courses);
                                                            $result=null;
                                                        @endphp
                                                        @if($result===0)
                                                            <span tabindex="0" data-bs-toggle="tooltip" style="width: 100%" title="Purchase and complete prerequisite courses first!">
                                                                <button type="button" class="btn btn-primary d-block w-100" disabled='disabled'>
                                                                    Enroll
                                                                </button>
                                                            </span>
                                                            @elseif($result ===null || $result===1)
                                                                <button type="button" class="btn btn-primary d-block w-100 mt-3" onclick="enrollCourse('{{ $course->slug }}')" data-bs-toggle="modal" data-bs-target="#enrollCourse">
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
                        @else
                            <div style="margin-top:2rem">
                            <h4 style="margin-bottom: 2rem;color: #8C68CD;margin-left:4rem">No course available in {{$data['category']->name}} category</h4>
                            </div>
                        @endif
                    @endif

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
                                        <div id="error-message" class="alert alert-success" style="display: none;"></div>
                                        {{-- <div class="form-group col-sm-6">
                                        {!! Form::label('coach', 'Select Coach:') !!}<span class="text-danger">*</span>
                                        <div id="div_coach">
                                            <select id="coach-select" class="form-control"></select>
                                        </div>
                                        </div> --}}
                                        <div class="form-group col-sm-6">
                                            <label for="coach">Select Coach:<span class="text-danger">*</span></label>
                                            <div id="div_coach">
                                                <select id="coach-select" class="form-control"></select>
                                            </div>
                                        </div>

                                        <input type="hidden" id="courseSlug" name="courseSlug" value=""/>
                                    </div>
                                    <div class="col-sm-12 text-center loader-div" style="display: none;">
                                        <img src="{{asset('images/page-img/page-load-loader.gif')}}" alt="loader" style="height: 100px;">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" disabled class="btn btn-primary applyCoach">Add Coach</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                @endif
            </div>
        </div>
    </body>
</x-app-layout>
