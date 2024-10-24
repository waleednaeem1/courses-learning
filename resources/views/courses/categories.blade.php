{{-- @php
   echo "<pre>";
   print_r($data);
   die;
@endphp --}}

<x-app-layout>
      <div class="container">
         <div class="row">
         <div class="col-lg-12">
            <div class="card shadow-none p-0">
               <div class="card-header d-flex justify-content-between rounded border-bottom-0">
                  <div class="header-title">
                     <h4 class="card-title">Courses Categories</h4>
                  </div>
               </div> 
            </div>
            <div class="row">   
               @foreach($data['course_categories'] as $category)                     
                  <div class="col-sm-6 col-md-6 col-lg-4">
                     <div class="card card-block card-stretch card-height product">
                        <div class="card-body">
                           <div class="d-flex align-items-center justify-content-between pb-3">
                              <div class="d-flex align-items-center">
                                 <div class="ms-2">
                                    <h5><a href="{{route('coursesList',  ['slug' => $category->slug])}}">{{$category->name}}</a></h5>
                                 </div>
                              </div>
                           </div>
                           <div class="image-block position-relative">
                              <p class="mb-0">{{$category->short_description}}</p>
                           </div>
                           <div class="course_wrapper">
                              <div class="course-heading-container">
                                 <h5 class="mb-1">Enrollments</h5>
                                 <h5 class="mb-1" style="margin-left: 4rem;">Courses Count</h5>
                              </div>
                              <div class="course-heading-container">
                                 <span class="categry text-primary ps-3 mb-2 position-relative">{{$category->enrollments}}</span>
                                 <span class="categry text-primary ps-3 mb-2 position-relative" style="margin-left: 9rem;">{{$category->course_count}}</span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</x-app-layout>