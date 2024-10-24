<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/croppie/croppie.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="iq-edit-list">
                            <ul class="iq-edit-profile row nav nav-pills">

                                @if(!$data['type'])
                                    <li class="col-md-4 p-0">
                                        <a class="nav-link" data-bs-toggle="pill" href="#chang-pwd">
                                            Change Password
                                        </a>
                                    </li>
                                    <!-- <li class="col-md-3 p-0">
                                        <a class="nav-link" data-bs-toggle="pill" href="#emailandsms">
                                            Email and SMS
                                        </a>
                                    </li> -->
                                    <li class="col-md-4 p-0">
                                        <a class="nav-link" data-bs-toggle="pill" href="#manage-contact">
                                            Manage Contact
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="iq-edit-list-data">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="personal-information" role="tabpanel">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">

                                    @if(session()->has('msg'))
                                    <p class="alert alert-success"> {{ session()->get('msg') }}</p>
                                    @endif

                                    @if($errors->any())
                                    <p class="alert alert-danger"> {{ $errors->first() }}  </p>
                                    @endif

                                    <div class="header-title" style="position: relative;top: 6px;">
                                        <h4 class="card-title">Personal Information</h4>
                                    </div>
                                 @if($data['type'])
                                    <div class="header-title" style="margin-right: 26px;position: relative;top: 6px;">
                                        <a  href='{{url('team/profile/detail/'.$data['team_id'])}}'>
                                            <h4 class="card-title">Cancel</h4>
                                        </a>
                                    </div>
                                @endif
                                </div>
                                <div class="card-body">
                                    <div id="personalInformationSuccess"></div>

                                    <form class="update-form"  action="{{ route('users.update',$users->id ?? '') }}" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" name="profile_user_id" value="{{$data['user_id']}}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" class="form-control" id="personalInformation" name="type" value="personalInformation">

                                        <div class=" row align-items-center">
                                            <div class="form-group col-sm-6">
                                                <label for="first_name"  class="form-label">First Name:</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control" id="first_name" minlength="2" name="first_name" value="{{$user->first_name}}" maxlength="14" required>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="last_name" class="form-label">Last Name:</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control" id="last_name" minlength="2" name="last_name" value="{{$user->last_name}}" maxlength="14" required>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="username" class="form-label">Username:</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control" id="username" name="username" value="{{$user->username}}" required >
                                                <div id="username-error"></div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">Marital Status:</label>
                                                <select class="form-select" aria-label="Default select example" name="marital_status" id="marital_status">
                                                    <option value="" disabled>Select Marital Status</option>
                                                    <option value="Single" {{ optional($users)->marital_status == 'Single' ? 'selected' : '' }}>Single</option>
                                                    <option value="In a Relationship" {{ optional($users)->marital_status == 'In a Relationship' ? 'selected' : '' }}>In a Relationship</option>
                                                    <option value="Engaged" {{ optional($users)->marital_status == 'Engaged' ? 'selected' : '' }}>Engaged</option>
                                                    <option value="Married" {{ optional($users)->marital_status == 'Married' ? 'selected' : '' }}>Married</option>
                                                    <option value="Divorced" {{ optional($users)->marital_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                                    <option value="Don’t want to specify" {{ optional($users)->marital_status == 'Don’t want to specify' ? 'selected' : '' }}>Don’t want to specify</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label d-block">Gender:</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio10" value="Male" @if($user->gender == 'Male') checked @endif>
                                                    <label class="form-check-label" for="inlineRadio10"> Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio11" value="Female" @if($user->gender == 'Female') checked @endif>
                                                    <label class="form-check-label" for="inlineRadio11"> Female</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" style="margin-top: 4px;" type="radio" name="gender" id="inlineRadio12" value="Don’t want to specify" @if ($user->gender == "Don’t want to specify") {{ 'checked' }} @endif>
                                                    <label class="form-check-label" for="inlineRadio12">Don’t want to specify</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="dob" class="form-label">Date Of Birth:</label><span class="text-danger">*</span>
                                                    <div>
                                                        <div class="date-picker">
                                                            <div class="span2">
                                                                <input type="text" style="font-size: inherit;border-color: darkgray;color: currentcolor;" class="rounded alert example px-2 py-1 rounded w-75" value="{{$user->dob ? \Carbon\Carbon::parse($user->dob)->format('m/d/Y') : "MM-DD-YYYY"}}" style="border: groove;" name="dob" id="datepicker" placeholder="MM-DD-YYYY">
                                                            </div>
                                                        </div>
                                                        {{-- <input type="date"  class="form-control" id="dob" name="dob" value="{{$user->dob}}"> --}}
                                                        {{-- <input type="date" class="form-control" id="dob" name="dob" value="{{ date('Y-m-d', strtotime($user->dob)) }}"> --}}
                                                        {{-- <select class="form-select my-1" id="month" name="dob_month" required>
                                                        <option value="" disabled>Month</option>
                                                        <option value="01" {{ optional ($data['dob'])[1] == '01' ? 'selected' : '' }}>January</option>
                                                        <option value="02" {{ optional ($data['dob'])[1] == '02' ? 'selected' : '' }}>February</option>
                                                        <option value="03" {{ optional ($data['dob'])[1] == '03' ? 'selected' : '' }}>March</option>
                                                        <option value="04" {{ optional ($data['dob'])[1] == '04' ? 'selected' : '' }}>April</option>
                                                        <option value="05" {{ optional ($data['dob'])[1] == '05' ? 'selected' : '' }}>May</option>
                                                        <option value="06" {{ optional ($data['dob'])[1] == '06' ? 'selected' : '' }}>June</option>
                                                        <option value="07" {{ optional ($data['dob'])[1] == '07' ? 'selected' : '' }}>July</option>
                                                        <option value="08" {{ optional ($data['dob'])[1] == '08' ? 'selected' : '' }}>August</option>
                                                        <option value="09" {{ optional ($data['dob'])[1] == '09' ? 'selected' : '' }}>September</option>
                                                        <option value="10" {{ optional ($data['dob'])[1] == '10' ? 'selected' : '' }}>October</option>
                                                        <option value="11" {{ optional ($data['dob'])[1] == '11' ? 'selected' : '' }}>November</option>
                                                        <option value="12" {{ optional ($data['dob'])[1] == '12' ? 'selected' : '' }}>December</option>
                                                        </select>
                                                        <select class="form-select my-1 mx-2" id="day" name="dob_day" required>
                                                        <option value="" disabled>Day</option>
                                                        @php
                                                        for($day = 1 ; $day <= 31 ; $day++){
                                                            if(isset($data['dob']) && count($data['dob']) > 0){
                                                                if($day < 10){$day = '0'.$day;}
                                                                if (isset($data['dob'][2]) && $data['dob'][2] == $day) {
                                                                    echo '<option value="'.$day.'" selected>'.$day.'</option>';
                                                                }else {
                                                                    echo '<option value="'.$day.'">'.$day.'</option>';
                                                                }
                                                            }
                                                        }
                                                        @endphp
                                                        </select>

                                                        <select class="form-select my-1" id="year" name="dob_year" required>
                                                        <option value="" disabled>Year</option>
                                                        @php
                                                            $min_age = 18;
                                                            $current_year = date('Y');
                                                            for($year = $current_year - $min_age; $year >= 1900; $year--){
                                                                if ($data['dob'][0] == $year) {
                                                                    echo '<option value="'.$year.'" selected>'.$year.'</option>';
                                                                }else {
                                                                    echo '<option value="'.$year.'">'.$year.'</option>';
                                                                }
                                                            }
                                                        @endphp --}}
                                                    {{-- </select> --}}
                                                </div>
                                                <div id="dob-error"></div>
                                            </div>
                                            {{-- <div class="form-group col-sm-6">
                                                <label class="form-label">Age:</label>
                                                <input type="text" class="form-control" name="age" maxlength="3" id="age" value="@if($users){{$users->age}}@else{{null}}@endif">
                                            </div> --}}
                                            <div class="form-group col-sm-6">
                                                {!! Form::label('country_id', 'Country:') !!}<span class="text-danger">*</span>
                                                {!! Form::select('country_id', $data['country'], $users->country,['class'=>'form-control','onchange="get_states(this.value);"', 'required', 'placeholder'=>'Select country ...']) !!}
                                            </div>
                                            <div class="form-group col-sm-6">
                                                {!! Form::label('state', 'State:') !!}<span class="text-danger">*</span>
                                                <div id="div_state">
                                                    {!! Form::select('state',$data['states'],$users->state,['class'=>'form-control', 'required', 'placeholder'=>'Select state ...']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-@if($data['type']){{'6'}}@else{{'12'}}@endif">
                                                <label for="cname" class="form-label">City:</label>
                                                <input type="text" class="form-control" id="cname" name="city" value="@if($users){{$users->city}}@endif">
                                            </div>
                                            @if($data['type'])
                                                <div class="form-group col-sm-6">
                                                    {!! Form::label('role_id', 'Role:') !!}<span class="text-danger">*</span>
                                                    {!! Form::select('role_id', $data['roles'],$users->user->role_id,['class'=>'form-control', 'required', 'placeholder'=>'Select Role ...']) !!}
                                                </div>
                                            @endif
                                            @if($data['type'])
                                                <div class="form-group col-sm-6">
                                                    <label for="zip_code" class="form-label">Postcode:</label>
                                                    <input type="text" maxlength="8" minlength="4" class="form-control" id="zip_code" name="zip_code" value="@if($user){{$user->zip_code}}@endif">
                                                </div>
                                            @endif
                                            <div class="form-group col-sm-12">
                                                <label class="form-label">Address:</label>
                                                <textarea class="form-control" name="address" rows="5" style="line-height: 22px;" >{{$user->address}}</textarea>
                                            </div>
                                            @if($data['type'])
                                                <div class="form-group col-sm-6">
                                                    <div class="bg-light border px-4 pt-4 mb-3" style="background-color:#f5f5f5 !important;">
                                                        <div class="form-group">
                                                            <div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input" id="email_event_reminder" name="email_event_reminder" value="1" {{ old('email_event_reminder') == 1 ? 'checked' : '' }} @if($user->email_event_reminder == '1') checked @endif>
                                                            <label class="form-check-label privacy-status" for="acc-private">Email - Event Reminders</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input" id="email_general_info" name="email_general_info" value="1" {{ old('email_general_info') == 1 ? 'checked' : '' }} @if($user->email_general_info == '1') checked @endif>
                                                            <label class="form-check-label privacy-status" for="acc-private">Email - General Information</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-check form-check-inline">
                                                            <input type="checkbox" class="form-check-input" id="email_marketing_events_courses" name="email_marketing_events_courses" value="1" {{ old('email_marketing_events_courses') == 1 ? 'checked' : '' }} @if($user->email_marketing_events_courses == '1') checked @endif>
                                                            <label class="form-check-label privacy-status" for="acc-private">Email - Marketing of new events and courses</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="submit" onclick="scrollToTop()" class="btn btn-primary me-2">Submit</button>
                                        {{-- <button type="reset" class="btn bg-soft-danger">Cancel</button> --}}
                                    </form>
                                </div>
                                <div class="modal fade" id="group-post-modal" aria-labelledby="groupPost-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 5rem">
                                    <div class="modal-dialog modal-groupCreatePost">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="groupPost-modalLabel">Upload Profile Picture
                                                </h5>
                                                <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                    <span class="material-symbols-outlined">close</span>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="container" style="margin-top:30px;">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-6 text-center">
                                                                        <div id="cropie-demo" style="width:250px;"></div>
                                                                    </div>
                                                                    <div class="col-md-6" style="padding-top:30px;">
                                                                        <strong>Select Image:</strong>
                                                                        {{-- <input type="file" required id="upload"> --}}
                                                                        <input type="file"name="profileImage" id="profile-image" required class="form-control" accept="image/x-png,image/gif,image/jpeg" placeholder="Profile Image" style="border:none;">
                                                                        <input type="hidden" name="userId" value={{ $user->id }}>
                                                                        <input type="hidden" name="type" value="profile">
                                                                        <br />
                                                                        <span id="error-profile" style="color: red; display: none;">Please select a valid image file</span>
                                                                    </div>
                                                                    {{-- <button class="btn btn-primary upload-result">Upload Image</button> --}}
                                                                    <button style="display:none;" type="submit" id="showAndHideButtonProfile" class="btn btn-primary w-100 mt-3 upload-result">Update Profile Picture</button>
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
                        <div class="tab-pane fade" id="chang-pwd" role="tabpanel">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Change Password</h4>
                                </div>
                                </div>
                                <div class="card-body">
                                    <div id="changePasswordSuccess"></div>
                                    <form class="form-horizontal update-form" action="{{ route('adminChangePassword') }}" method="POST" id="changePasswordAdminForm">
                                        @csrf
                                      <input type="hidden" class="form-control" name="profile_user_id" value="{{$data['user_id']}}">
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label for="cpass" class="form-label">Current Password:</label>
                                                <div class="input-group">
                                                    <input type="Password" class="form-control" name="current_password" id="current_password" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" style="height:39px;" onclick="current_password_show_hide();">
                                                        <i class="fas fa-eye-slash" id="show_eye2"></i>
                                                        <i class="fas fa-eye d-none" id="hide_eye2"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <span class="text-danger error-text current_password_error"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label for="npass" class="form-label">New Password:</label>
                                                <div class="input-group">
                                                    <input type="Password" class="form-control" name="new_password" id="password" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" style="height:39px;" onclick="password_show_hide();">
                                                        <i class="fas fa-eye-slash" id="show_eye"></i>
                                                        <i class="fas fa-eye d-none" id="hide_eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <span class="text-danger error-text new_password_error"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                            <label for="vpass" class="form-label">Confirm New Password:</label>
                                                <div class="input-group">
                                                    <input type="Password" class="form-control" name="new_password_confirmation" id="password_confirmation" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" style="height:39px;" onclick="confirm_password_show_hide();">
                                                        <i class="fas fa-eye-slash" id="show_eye1"></i>
                                                        <i class="fas fa-eye d-none" id="hide_eye1"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <span class="text-danger error-text new_password_confirmation_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                        <div class="col-sm-10">
                                            <button type="submit" id="changePasswordButton" class="btn btn-primary me-2">Update Password</button>
                                            {{-- <button type="reset" class="btn bg-soft-danger">Cancel</button> --}}
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="tab-pane fade" id="emailandsms" role="tabpanel">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Email and SMS</h4>
                                </div>
                                </div>
                                <div class="card-body">
                                <form>
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-3" for="emailnotification">Email Notification:</label>
                                        <div class="col-md-9 form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked11" checked>
                                            <label class="form-check-label" for="flexSwitchCheckChecked11">Checked switch checkbox input</label>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-3" for="smsnotification">SMS Notification:</label>
                                        <div class="col-md-9 form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked12" checked>
                                            <label class="form-check-label" for="flexSwitchCheckChecked12">Checked switch checkbox input</label>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-3" for="npass">When To Email</label>
                                        <div class="col-md-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12">
                                                <label class="form-check-label" for="flexCheckDefault12">
                                                    You have new notifications.
                                                </label>
                                            </div>
                                            <div class="form-check d-block">
                                                <input class="form-check-input" type="checkbox" value="" id="email02">
                                                <label class="form-check-label" for="email02">You're sent a direct message</label>
                                            </div>
                                            <div class="form-check d-block">
                                                <input type="checkbox" class="form-check-input" id="email03" checked="">
                                                <label class="form-check-label" for="email03">Someone adds you as a connection</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-3" for="npass">When To Escalate Emails</label>
                                        <div class="col-md-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="email04">
                                                <label class="form-check-label" for="email04">
                                                    Upon new order.
                                                </label>
                                            </div>
                                            <div class="form-check d-block">
                                                <input class="form-check-input" type="checkbox" value="" id="email05">
                                                <label class="form-check-label" for="email05">New membership approval</label>
                                            </div>
                                            <div class="form-check d-block">
                                                <input type="checkbox" class="form-check-input" id="email06" checked="" value="">
                                                <label class="form-check-label" for="email06">Member registration</label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    <button type="reset" class="btn bg-soft-danger">Cancel</button>
                                </form>
                                </div>
                            </div>
                        </div> -->
                        <div class="tab-pane fade" id="manage-contact" role="tabpanel">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Manage Contact</h4>
                                </div>
                                </div>
                                <div class="card-body">
                                    <div id="manageContactSuccess"></div>
                                    <form class="update-form"  action="{{ route('users.update',$users->id ?? '') }}" method="POST" enctype=”multipart/form-data”>
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" class="form-control" id="manageContact" name="type" value="manageContact">
                                         <input type="hidden" class="form-control" name="profile_user_id" value="{{$data['user_id']}}">
                                        <div class="form-group">
                                            <label for="cno"  class="form-label">Contact Number:</label>
                                            <input type="text" id="phoneNumber" class="form-control phone" autocomplete="off" name="phone" value="{{$user->phone}}" maxlength="10" minlength="10" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email"  class="form-label">Email:</label>
                                            <input disabled type="text" class="form-control" id="email" value="{{$user->email}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="url"  class="form-label">Website:</label>
                                            <input type="url" class="form-control" id="url" name="website" value="{{$user->website}}">
                                        </div>
                                        <button type="submit" id="submitBtn" class="btn btn-primary me-2">Submit</button>
                                        {{-- <button type="reset" class="btn bg-soft-danger">Cancel</button> --}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/croppie/croppie.js')}}"></script>
    <script type="text/javascript">
      /*   document.getElementById("first_name").addEventListener("input", function(event) {
            var input = event.target.value;
            var regex = /([^a-zA-Z\s])/g;
            if (regex.test(input)) {
                event.target.value = input.replace(regex, "");
            } else {
                if(input.length < 2 || input.length > 14){}else{
                    event.target.value = input;
                }
            }
            });
            document.getElementById("last_name").addEventListener("input", function(event) {
            var input = event.target.value;
            var regex = /([^a-zA-Z\s])/g;
            if (regex.test(input)) {
                event.target.value = input.replace(regex, "");
            } else {
                if(input.length < 2 || input.length > 14){}else{
                    event.target.value = input;
                }
            }
        }); */
        document.getElementById("username").addEventListener("input", function(event) {
            var regex = /[^a-z0-9_]/g;
            var input = event.target.value;
            if (regex.test(input)) {
                event.target.value = input.replace(regex, "");
            } else {
                event.target.value = input;
            }
        });

        // $( "#changePasswordButton" ).click(function() {
        //     alert("Test");
        //     var inputs = $('#changePasswordForm :input');
        //     console.log(inputs);
        //     // return false;
        //     // var values = {};
        //     // inputs.each(function() {
        //     //     values[this.name] = $(this).val();
        //     // });
        //     // alert(values[this.name] = $(this).val();
        //     // $( "#changePasswordForm" ).submit();
        // });
            $(document).ready(function() {
            $('#profileImage').change(function() {
            var file = this.files[0];
            var fileType = file.type;
            var validImageTypes = ["image/jpeg", "image/png", "image/gif"];

            if ($.inArray(fileType, validImageTypes) < 0) {
                $('#error').show();
                $('#profileImage').val("");
            } else {
                $('#error').hide();
            }
            });
        });

        function get_states(country_id) {

            $.ajax({
                method: 'GET',
                url: '/get-states',
                data: { country_id: country_id }
            }).done(function (obj) {
                let html = '';
                if (obj.status == '1') {
                    html += '<select name="state" id="state" class="form-control" required><option value="">Please select ...</option>';

                    obj.data.forEach(function (data) {
                        html += '<option value="' + data.id + '">' + data.name + '</option>';
                    });

                    html += '</select>';
                } else {
                    html += '<select name="state" id="state" class="form-control" required><option value="">Please select ...</option>';

                    html += '</select>';
                }

                $('#div_state').html(html);
            });
        }


        $('.phone').on('input', function(event) {
            var input = event.target.value;
            var regex = /[^a-zA-Z0-9]/g;
            if (regex.test(input)) {
                event.target.value = input.replace(regex, '');
            }
            $(this).val(formatPhoneNumber($(this).val()));
        });

        function formatPhoneNumber(input) {
            var phoneNumberCheck = document.getElementById("phoneNumber");
            var checkregex = /[^a-zA-Z0-9]/g;
            var phoneNumber = input.replace(checkregex, "");
            var regex = /^([a-zA-Z0-9]{3})([a-zA-Z0-9]{3})([a-zA-Z0-9]{4})$/;
            if (regex.test(input)) {
                phoneNumberCheck.setCustomValidity("");
                return input.replace(regex, '($1) $2-$3');
            } else {
                if(phoneNumber.length < 10 || phoneNumber.length > 11){
                    event.preventDefault();
                    phoneNumberCheck.setCustomValidity("Phone number must be between 10 and 11 digits");
                    return input;
                }else{
                    phoneNumberCheck.setCustomValidity("");
                    return input;
                }
            }
        }


    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $uploadCrop = $('#cropie-demo').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'square'
            },
            boundary: {
                width: 300,
                height: 300
            }
        });


        $('#profile-image').on('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function() {
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
        });


        $('.upload-result').on('click', function(ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function(resp) {
                $.ajax({
                    url: "{{ route('imageCrop') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "image": resp,
                        "type": "Profile_image"
                    },
                    success: function(data) {
                        location.reload(true);
                    }
                });
            });
        });
        $(document).ready(function() {
            $('#profile-image').change(function() {
            var file = this.files[0];
            var fileType = file.type;
            var validImageTypes = ["image/jpeg", "image/png", "image/jpg"];

            if ($.inArray(fileType, validImageTypes) < 0) {
                $('#error-profile').show();
                $('#showAndHideButtonProfile').hide();
                $('#profileImage').val("");
            } else {
                $('#error-profile').hide();
                $('#showAndHideButtonProfile').show();
            }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
    $( function() {
        $( "#datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '-100:-18',
        });
    } );
    $("#datepicker").on('keypress',function(e){
    if(event.charCode == 9 ){
        return true;
    }
        return false;
    });
    </script>
</x-app-layout>
