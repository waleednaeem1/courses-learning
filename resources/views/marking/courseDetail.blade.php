<x-app-layout>
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="card shadow-none p-0">
               <div class="card-header d-flex justify-content-between rounded border-bottom-0">
                  <div class="header-title">
                     <a class="btn btn-primary text-white " href="{{route('marking')}}">Back</a>
                  </div>
               </div>
            </div>

            @foreach($modules as $key => $module)

                @if($module->is_hide==0)
                     <div class="row" style="margin-top: 2rem;">
                        <div class="col-lg-12">
                           <div class="card" style="height: 4rem;justify-content: center;background-color:rgba(97, 96, 96, 0.17)">
                              <div class="row">
                                 <div class="col-md-8">
                                    <h4 class="card-title" style="padding-left: 2rem;color: #8C68CD;">Module {{$key}}: {{$module['module']->title}}</h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     @foreach($module['sections'] as $check => $section)
                        @if($section->is_hide==0)
                           <div class="row" style="margin-top:-15px">
                              <div class="col-lg-12">
                                 <div class="card" style="height: 4rem;justify-content: center;">
                                    <div class="row">
                                       <div class="col-md-8">
                                          <h5 class="card-title" style="padding-left: 4rem;color: #8C68CD;">Section {{$check}}: {{$section->title}}</h5>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row" style="margin-top:-15px">
                              <div class="col-lg-12">
                                 <div class="card">
                                    <table class="table">
                                       <thead>
                                          <tr class="bg-soft-primary">
                                             <th class="text-primary c-title" style="width: 55%;">ITEM</th>
                                             <th class="text-danger align-property" style="width: 14%;">TYPE</th>
                                             <th class="text-success align-property" style="width: 18%;">STATUS</th>
                                             <th class="text-secondary">ACTIONS</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($section['completed_exercises'] as $index => $cExercise)

                                          @if(isset($cExercise) && isset($cExercise['exercise']))

                                            @if($cExercise['exercise']->type==='quiz' && isset($cExercise['exercise']['exercise_result']->type))
                                                @if ($cExercise['exercise']['exercise_result']->type == 'both' || $cExercise['exercise']['exercise_result']->type == 'text')
                                                    <tr>
                                                    <td class='align-property c-title'>{{ $cExercise['exercise']->title }}</td>
                                                    <td class="align-property">{{ $cExercise['exercise']->type }}</td>
                                                    <td class="align-property">
                                                        <div style="margin-top: 0.25rem;">
                                                            <button type="button" disabled class="btn btn-warning rounded-pill mb-1">

                                                        @if(!isset($cExercise['exercise']['exercise_marking']))
                                                            Processing
                                                           @elseif(isset($cExercise['exercise']['exercise_marking']) &&  ($cExercise['exercise']       ['exercise_marking']->is_exercise_mark)>0 )
                                                            Processing
                                                          @else
                                                            Completed
                                                           @endif
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                    @if(!isset($cExercise['exercise']['exercise_marking']))
                                                            <a class="btn btn-primary text-white " href="{{route('markingExerciseDetail',  ['exercise_id' => $cExercise['exercise']->id])}}">Mark</a>
                                                    @elseif(isset($cExercise['exercise']['exercise_marking']) &&  ($cExercise['exercise']       ['exercise_marking']->is_exercise_mark)>0 )

                                                      <a class="btn btn-primary text-white " href="{{route('markingExerciseDetail',  ['exercise_id' => $cExercise['exercise']->id,'marking_submission_id'=>$cExercise['exercise']['exercise_marking']->id])}}">Mark</a>

                                                    @else
                                                      <a style="opacity: .4;cursor: default !important;pointer-events: none;" class="btn btn-primary text-white">Mark</a>
                                                    @endif
                                                    </td>
                                                    </tr>
                                                   @endif
                                                  @else

                                                @if($cExercise['exercise']->type==='file_upload')

                                                <tr>
                                                    <td class='align-property c-title'>{{ $cExercise['exercise']->title }}</td>
                                                    <td class="align-property">{{ $cExercise['exercise']->type }}</td>
                                                    <td class="align-property">
                                                        <div style="margin-top: 0.25rem;">
                                                        <button type="button" disabled class="btn btn-warning rounded-pill mb-1">
                                                           @if(!isset($cExercise['exercise']['exercise_marking']))
                                                            Processing
                                                           @elseif(isset($cExercise['exercise']['exercise_marking']) &&  ($cExercise['exercise']       ['exercise_marking']->is_exercise_mark)>0 )
                                                            Processing
                                                          @else
                                                            Completed
                                                           @endif
                                                        </button>
                                                    </div>
                                                    </td>
                                                    <td>

                                                     @if(!isset($cExercise['exercise']['exercise_marking']))
                                                            <a class="btn btn-primary text-white " href="{{route('markingExerciseDetail',  ['exercise_id' => $cExercise['exercise']->id])}}">Mark</a>
                                                    @elseif(isset($cExercise['exercise']['exercise_marking']) &&  ($cExercise['exercise']       ['exercise_marking']->is_exercise_mark)>0 )

                                                      <a class="btn btn-primary text-white " href="{{route('markingExerciseDetail',  ['exercise_id' => $cExercise['exercise']->id,'marking_submission_id'=>$cExercise['exercise']['exercise_marking']->id])}}">Mark</a>

                                                    @else
                                                      <a style="opacity: .4;cursor: default !important;pointer-events: none;" class="btn btn-primary text-white ">Mark</a>
                                                    @endif

                                                    </td>
                                                    </tr>
                                                @endif

                                             @endif

                                            @else
                                            <tr>
                                                <td class='align-property c-title'>No exercise to mark</td>
                                            </tr>
                                            @endif
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        @endif
                     @endforeach
                     @endif
            @endforeach

         </div>
      </div>
   </div>
</x-app-layout>