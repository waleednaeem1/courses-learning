<x-app-layout>
   <div class="container mt-3">
      <div class="row">
         <div class="col-lg-12">
            <div class="card shadow-none p-0">
               <div class="card-header d-flex justify-content-between rounded border-bottom-0">
                  <div class="header-title">
                     <h4 class="card-title">Marking Dashboard</h4>
                  </div>
               </div>
            </div>
            @if(isset($modules) && count($modules) > 0)
               <div class="card shadow-none p-0">
                  <div class="card-header d-flex justify-content-between rounded border-bottom-0">
                     <div class="header-title">
                        <h4 class="card-title" style="color: #8C68CD;">Click on a course title below to view marking for that course</h4>
                     </div>
                  </div>
               </div><br>
            {{-- @if(isset($modules) && count($modules) > 0) --}}
               <div class="row">
                  <div class="col-lg-12">
                     <div id="faqAccordion">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="accordion" id="accordionExample">
                                 @foreach($modules as $module)

                                    @if ($module->course->coach_id == auth()->user()->id)
                                       <div class="accordion-item mb-3">
                                          <h2 class="accordion-header" id="heading1">
                                             <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                                {{$module->course->title}}
                                             </button>
                                          </h2>
                                          <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordionExample">
                                             <div class="accordion-body">
                                                <table class="table">
                                                   <thead>
                                                      <tr>
                                                         <th class="text-primary">USER</th>
                                                         <th class="text-danger">DATE</th>
                                                         <th class="text-success">PROGRESS</th>
                                                         <th class="text-warning">Exercises TO MARK</th>

                                                         <th class="text-secondary">ACTIONS</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                      <tr>
                                                          <td>{{ ucfirst($module->course->user['name']) }}</td>
                                                         <td>{{$module->course->created_at->toDateString()}}</td>
                                                         <td>
                                                            <div class="progress mb-3" style="margin-top: 0.25rem;">
                                                               <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                                            </div>
                                                         </td>
                                                         <td>{{ countModuleExercises(($module->course)) }}</td>

                                                         <td><a class="btn btn-primary text-white" href="{{route('markingCourseDetail',  ['id' => $module->course->id])}}">Mark</a></td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </div>
                                          </div>
                                       </div>
                                    @endif
                                 @endforeach
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            @else
               <div style="margin-top:2rem">
                  <h4 style="margin-bottom: 2rem;color: #8C68CD;margin-left:4rem">You have no course to mark!</h4>
               </div>
            @endif
         </div>
      </div>
   </div>
</x-app-layout>