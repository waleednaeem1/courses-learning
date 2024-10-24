<x-app-layout>
   <section id="saasio-breadcurmb" class="saasio-breadcurmb-section">
      <div class="container">
         <div class="breadcurmb-title text-center">
            <h2>Team</h2>
         </div>
         <!--<div class="breadcurmb-item-list text-center ul-li">
              <ul class="saasio-page-breadcurmb">
                  <li><a href="#">Home</a></li>
                  <li><a href="#">About</a></li>
              </ul>
         </div> -->
      </div>
  </section>
   <div class="container mt-3">
      <div class="row">
         <div class="col-lg-10" style="margin-left: 4rem">
            <div class="page-header mb-4 d-md-flex justify-content-between">
               <div class="w-75">
                  {{-- <h1 class="page-title pl-6" style="padding-left: 12%;font-size: 32px;">
                     Team
                  </h1> --}}
               </div>
               <div class="btn-group" role="group">
                  <a data-toggle="collapse" class="btn btn-primary btn-md collapsed" style="height: 45px; color:#fff;padding-top: 9px;" onclick="toogle_add_colleague()">Add Colleague</a>
               </div>
            </div>
            <div class="card collapse" style="margin-left: 4rem" id="inviteForm">
               @if($errors->any())
                  <p class="alert alert-danger"> {{ $errors->first() }}  </p>
               @endif
               <div class="card-body">
                  <h3>Add Colleague</h3>
                  <div class="d-flex align-items-center">
                     <form class="post-text ms-3 w-100" action="{{ route('team.addColleague') }}" method="post" enctype="multipart/form-data" id="addColleageForm">
                     {{-- <form class="post-text ms-3 w-100" action="{{ route('team.addColleague') }}" method="post" enctype="multipart/form-data"> --}}
                        @csrf
                        <div class='row'>
                           <div class='form-group col-md-6'>
                              <label class="form-label d-block mt-4">User Name <span class="text-danger">*</span> </label>
                              <input type="text" id="username" name="username" value="{{old('username')}}" required class="form-control rounded"  placeholder="User Name">

                           </div>
                           <div class='form-group col-md-6'>
                              <label class="form-label d-block mt-4">First Name <span class="text-danger">*</span> </label>
                              <input type="text" name="first_name" value="{{old('first_name')}}" required class="form-control rounded"  placeholder="First Name">
                           </div>
                        </div>
                        <div class='row'>
                           <div class='form-group col-md-6'>
                              <label for="category" class="form-label d-block mt-4">Last Name <span class="text-danger">*</span></label>
                              <input type="text" name="last_name"  value="{{old('last_name')}}" required class="form-control rounded" placeholder="Last Name">
                           </div>
                           <div class='form-group col-md-6'>
                              <label class="form-label d-block mt-4">Email <span class="text-danger">*</span> </label>
                              <input type="email" name="email"  value="{{old('email')}}" required class="form-control rounded"  placeholder="Email">
                           </div>
                        </div>
                        <div class='row'>
                           <div class='form-group col-md-6'>
                              <label class="form-label d-block mt-4">Role <span class="text-danger">*</span> </label>
                              <select name="role_id" selected="" class="form-control" required>
                                 <option value="">Please select</option>
                                 @foreach($roles as $role)
                                    <option value={{$role->id}}>{{$role->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class='form-group col-md-6'>
                              <label for="category" class="form-label d-block mt-4">Phone</label>
                              <input type="text" name="phone_number"  value="{{old('phone')}}" class="form-control rounded phone" placeholder="Phone" id="phoneNumber" autocomplete="off" maxlength="10" minlength="10">
                           </div>
                        </div>
                        <div class='row'>
                           <div class='form-group col-md-6'>
                              <label for="category" class="form-label d-block mt-4">Coach Access</label>
                              <input type="checkbox" class="form-check-input" name="is_coach" id="is_coach" style="margin-left: 0.1rem;">
                              <label for="checkbox2" style="margin-left: 1.5rem;">Yes, please make this colleague a coach</label>
                           </div>
                        </div>
                        <button type="submit" id="createPageButtonClick" class="btn btn-primary d-block w-100 mt-3">Add Colleague</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row mt-4">
         <div class="col-lg-10" style="margin-left: 6rem">
            <div class="card">
               <div class="card-body">
                  <nav>
                     <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="colleague-user" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Team</button>
                        <button class="nav-link" id="removed-colleague" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Old Team</button>
                     </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                     <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="colleague-user">
                        <div class="d-flex align-items-center">

                           <div class="table-responsive">
                              <table id="datatable" class="table table-striped table-bordered" >
                                 <thead>
                                    <tr>
                                       <th>User</th>
                                       <th>Coach</th>
                                       <th>Courses</th>
                                       <th>Events</th>
                                       <th>Profile</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($team as $value)
                                       <tr>
                                          <td><b>{{$value->user->name}}</b>
                                             <br>{{$value->user->learningRole->name ?? null}}
                                          </td>
                                          <td>
                                             <a style="display: flex;justify-content: center;padding-top: 10px;" href="javascript:void(0)" onclick="coachAccessChange({{$value->id}})">@if($value->is_coach =='1') Remove Coach Access @else Assign Coach Access @endif </a>
                                          </td>
                                          <td>
                                             <a href="{{route('coursesList')}}" class="btn btn-primary d-block" style="width: auto;height: 42px; padding-top: 0.5rem; color:#fff">Browse Courses</a>
                                          </td>
                                          <td>
                                             <a href="{{route('events')}}" class="btn btn-primary d-block" style="width: auto;height: 42px; padding-top: 0.5rem; color:#fff">Browse Events</a>
                                          </td>
                                          <td>

                                        <a href={{url('team/profile/detail/'.$value->id)}} class="btn btn-primary d-block" style="width: auto;height: 42px; padding-top: 0.5rem; color:#fff">Profile</a>
                                          </td>
                                       </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="removed-colleague">
                        <div class="d-flex align-items-center">
                           <div class="table-responsive">
                              <table id="datatabletrashuser" class="table table-striped table-bordered" >
                                 <thead>
                                    <tr>
                                       <th>User</th>
                                       <th>Courses</th>
                                       <th>Events</th>
                                       <th>Profile</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($trashUsers as $value)
                                       <tr id="removeTeam-{{$value->id}}">
                                          <td><b>{{$value->user->name}}</b>
                                             <br>{{$value->user->learningRole->name ?? null}}
                                          </td>
                                          <td>
                                             <a href="{{route('courses.categories')}}" class="btn btn-primary d-block" style="width: auto;height: 42px; padding-top: 0.5rem;">Browse Courses</a>
                                          </td>
                                          <td>
                                             <a href="{{route('events')}}" class="btn btn-primary d-block" style="width: auto;height: 42px; padding-top: 0.5rem;">Browse Events</a>
                                          </td>
                                          <td>
                                             <a href={{url('team/profile/detail/'.$value->id)}}>Profile</a>
                                          </td>
                                          <td>
                                          <button type="button" class="btn btn-sm btn-light float-right"  value= "{{$value->id}}" onclick="confirmAlertTeam(this)">
                                          Reassign
                                          </button>
                                          </td>
                                       </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- modal for success or confirm -->
      <div class="modal fade"  id="reassignuser"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="padding-top: 120px;">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Reassign Team</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
               Are you sure you want to reassign to the team?
               <input type="hidden" id="team_id" />
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button class="btn btn-primary" onclick="confirmAssignToTeam()">Submit</button>
               </div>
            </div>
         </div>
      </div>
      <!-- end modal -->
   </div>
   <script>
      function toogle_add_colleague(){
         $('#inviteForm').toggle();
      }
      document.getElementById("username").addEventListener("input", function(event) {
            var regex = /[^a-z0-9_]/g;
            var input = event.target.value;
            if (regex.test(input)) {
                event.target.value = input.replace(regex, "");
            } else {
                event.target.value = input;
            }
        });
   </script>
</x-app-layout>


