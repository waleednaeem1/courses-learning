<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <section id="saasio-breadcurmb" class="saasio-breadcurmb-section">
        <div class="container">
           <div class="breadcurmb-title text-center">
              <h2>Update Practice</h2>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="iq-edit-list">
                            <ul class="iq-edit-profile nav-row nav nav-pills">
                                <li class="col-md-4 p-0">

                                    <a class="nav-link active" id="change_personal_information" data-bs-toggle="pill" href="#personal-information">
                                        Personal Information
                                    </a>
                                </li>
                                @if(!$data['type'])
                                    <li class="col-md-4 p-0">
                                        <a class="nav-link" id="change_password" data-bs-toggle="pill" href="#chang-pwd">
                                            Change Password
                                        </a>
                                    </li>
                                    <li class="col-md-4 p-0">
                                        <a class="nav-link" id="manage_contact"   data-bs-toggle="pill" href="#manage-contact">
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
                <div class="iq-edit-list-data" style="width: 100%">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="personal-information" role="tabpanel">
                                    <br>
                                  @if( \Request::get('change_personal_information')==1)
                                   @if(session()->has('success'))
                                    <p class="alert alert-success">
                                        {{ session()->get('success') }}
                                    </p>
                                    @endif

                                    @if(session()->has('error'))
                                    <p class="alert alert-danger">
                                        {{ session()->get('error') }}
                                    </p>
                                    @endif
                                  @endif

                            <div class="card"><br>


                                    @if($errors->any())
                                     <p class="alert alert-danger"> {{$errors->first()}}</p>
                                    @endif

                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Personal Information</h4>
                                    </div>
                                 @if($data['type'])
                                    <div class="header-title" style="margin-right: 26px;">
                                        <a  href='{{url('team/profile/detail/'.$data['team_id'])}}'>
                                            <h4 class="card-title">Cancel</h4>
                                        </a>
                                    </div>
                                @endif

                                </div>
                                <div class="card-body">
                                    <div id="personalInformationSuccess"></div>
                                    {{-- <form class="update-form" method="POST" enctype="multipart/form-data"> --}}
                                    <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" class="form-control" name="profile_user_id" value="{{$data['user_id']}}">
                                        <input type="hidden" class="form-control" name="type" value="personalInformation">
                                        @csrf
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
                                                </div>
                                                <div id="dob-error"></div>
                                            </div>



                                            <div class="form-group col-sm-6">
                                                <label for="zip_code" class="form-label">Postcode:</label>
                                                <input type="text" class="form-control" maxlength="8" minlength="4" id="zip_code" name="zip_code" value="@if($user){{$user->zip_code}}@endif">
                                            </div>
                                            <div class="form-group col-sm-@if($data['type']){{'6'}}@else{{'12'}}@endif">
                                                <label for="cname" class="form-label">City:</label>
                                                <input type="text" class="form-control" id="cname" name="city" value="@if($users){{$users->city}}@endif">
                                            </div>
                                            {{-- @if($data['type']) --}}
                                                {{-- <div class="form-group col-sm-6">
                                                    <label for="zip_code" class="form-label">Postcode:</label>
                                                    <input type="text" class="form-control" id="zip_code" name="zip_code" value="@if($user){{$user->zip_code}}@endif">
                                                </div> --}}
                                            {{-- @endif --}}
                                            <div class="form-group col-sm-12">
                                                <label class="form-label">Address:</label>
                                                <textarea class="form-control" name="address" rows="5" style="line-height: 22px;" >{{$user->address}}</textarea>
                                            </div>
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
                                        </div>
                                        <button type="submit" onclick="scrollToTop()" class="btn btn-primary me-2">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="chang-pwd" role="tabpanel">
                                    <br>
                                @if( \Request::get('change_password')==1)
                                    @if(session()->has('success'))
                                    <p class="alert alert-success">
                                        {{ session()->get('success') }}
                                    </p>
                                    @endif

                                    @if(session()->has('error'))
                                    <p class="alert alert-danger">
                                        {{ session()->get('error') }}
                                    </p>
                                    @endif
                                @endif
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">Change Password</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="changePasswordSuccess"></div>
                                    {{-- <form class="form-horizontal update-form" action="{{ route('adminChangePassword') }}" method="POST" id="changePasswordAdminForm"> --}}
                                    <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                      <input type="hidden" class="form-control" name="profile_user_id" value="{{$data['user_id']}}">
                                      <input type="hidden" class="form-control" name="type" value="changePassword">
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
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="manage-contact" role="tabpanel">
                                     <br>
                                @if( \Request::get('manage_contact')==1)
                                    @if(session()->has('success'))
                                    <p class="alert alert-success">
                                        {{ session()->get('success') }}
                                    </p>
                                    @endif

                                    @if(session()->has('error'))
                                    <p class="alert alert-danger">
                                        {{ session()->get('error') }}
                                    </p>
                                    @endif
                                    @endif
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Manage Contact</h4>
                                </div>
                                </div>
                                <div class="card-body">
                                    <div id="manageContactSuccess"></div>
                                    <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" id="manageContact" name="type" value="manageContact">
                                         <input type="hidden" class="form-control" name="profile_user_id" value="{{$data['user_id']}}">
                                         <input type="hidden" class="form-control" name="type" value="manageContact">
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
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        document.getElementById("first_name").addEventListener("input", function(event) {
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
        });
        document.getElementById("username").addEventListener("input", function(event) {
            var regex = /[^a-z0-9_]/g;
            var input = event.target.value;
            if (regex.test(input)) {
                event.target.value = input.replace(regex, "");
            } else {
                event.target.value = input;
            }
        });
        $(document).ready(function() {

           var change_password = <?php echo  (\Request::get('change_password')) ? \Request::get('change_password') : 'null'; ?>;

            var change_personal_information = <?php echo  (\Request::get('change_personal_information')) ? \Request::get('change_personal_information') : 'null'; ?>;

            var manage_contact = <?php echo  (\Request::get('manage_contact')) ? \Request::get('manage_contact') : 'null'; ?>;

             if(change_password != null){
            $('#change_password')[0].click();
            }
            if(change_personal_information != null){
            $('#change_personal_information')[0].click();
            }
            if(manage_contact != null){
            $('#manage_contact')[0].click();
            }

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
        function get_states(country_id)
        {
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
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
    $( function() {
        $( "#datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '-100:-18',
        });
    });
    $("#datepicker").on('keypress',function(e){
        if(event.charCode == 9 ){
            return true;
        }
        return false;
    });
    </script>
</x-app-layout>
