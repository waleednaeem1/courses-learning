<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="assets/login/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/css/iofrm-style.css?version=0.01">
    <link rel="stylesheet" type="text/css" href="assets/login/css/iofrm-theme7.css?version=0.01">
    <link rel="stylesheet" type="text/css" href="assets/css/jquery-ui.css">
</head>
<body>
    <div class="form-body">
        <div class="website-logo">
            <a href="{{route('login')}}">
                <div class="logo">
                    <img class="logo-size" src="https://colorfulce.vetandtech.com/assets/img/logo/colorful.png" alt="">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="assets/login/images/graphic1.svg" alt="">
                </div>
            </div>
             <div class="img-holder" style="top: 557px;">
                <div class="bg"></div>
                <div class="info-holder">

                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                    @if(session()->has('msg'))
                         <p class="alert alert-success"> {{ session()->get('msg') }}</p>
                     @endif
                        @if($errors->any())

                       <p class="alert alert-danger"> {{$errors->first()}}</p>
                        @endif
                        <h3>Get more things done with Login platform.</h3>
                        <p>Access to the most powerfull tool in the entire design and web industry.</p>
                        <div class="page-links">
                            <a href="{{route('login')}}">Login</a><a href="{{route('register')}}" class="active">Register</a>
                        </div>
                        <form method="POST" action="{{route('register')}}" data-toggle="validator" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="username-name" class="form-label">Username <span class="text-danger">*</span></label>
                                    <input id="username-name" name="username" value="{{old('username')}}" class="form-control" type="text" placeholder=" "  required autofocus >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone" class="form-label">Phone No <span class="text-danger">*</span></label>
                                    <input type="text" id="phoneNumber" class="form-control phone" required  name="phone_number" value="{{old('phone_number')}}" maxlength="10"  required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="first-name" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input name="first_name" id="first_name_text" value="{{old('first_name')}}" class="form-control" type="text" placeholder=" "  required autofocus minlength="2" maxlength="14">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last-name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input name="last_name" id="last_name_text" value="{{old('last_name')}}" class="form-control" type="text" placeholder=" "  required autofocus minlength="2" maxlength="14">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="exampleInputEmail2">Email Address <span class="text-danger">*</span></label>
                                    <input class="form-control" pattern ="[^@]+@[^@]+\.[a-zA-Z]{2,6}" type="email" placeholder=" " id="email"  name="email" value="{{old('email')}}" required>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="dob" class="form-label">Date Of Birth <span class="text-danger">*</span></label><br />
                                    <div class="date-picker">
                                        <div class="span2">
                                            <input type="text" required class="rounded alert example px-2 py-1 rounded" value="{{old('dob')}}" autocomplete="off" style="width:64%; font-size: inherit;border-color: darkgray;color: currentcolor;" name="dob" id="datepicker" placeholder="MM-DD-YYYY">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">

                                    <label class="form-label d-block">Gender <span class="text-danger">*</span></label>
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" style="margin-top: 4px;" required type="radio" name="gender" id="inlineRadio10" value="male" @if (old('gender') == "male") {{ 'checked' }} @endif>
                                        <label class="form-check-label" for="inlineRadio10"> Male</label>
                                    </div>
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" style="margin-top: 4px;" type="radio" name="gender" id="inlineRadio11" value="female" @if (old('gender') == "female") {{ 'checked' }} @endif>
                                        <label class="form-check-label" for="inlineRadio11">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" style="margin-top: 4px;" type="radio" name="gender" id="inlineRadio12" value="Don’t want to specify" @if (old('gender') == "Don’t want to specify") {{ 'checked' }} @endif>
                                        <label class="form-check-label" for="inlineRadio12">Don’t want to specify</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <input name="password"  autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" type="password" value="" class="input form-control" id="password" required="true" aria-label="password" aria-describedby="basic-addon1" />
                                        <div class="input-group-append">
                                          <span class="input-group-text"  style="background-color: rgb(232, 240, 254);border: none;border-left: 2px solid #ced4da;" onclick="password_show_hide();">
                                            <i class="fas fa-eye-slash" id="show_eye"></i>
                                            <i class="fas fa-eye d-none" id="hide_eye"></i>
                                          </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirm-password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <input name="password_confirmation"  autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" type="password" value="" class="input form-control" id="password_confirmation" required="true" aria-label="password"   aria-describedby="basic-addon1" />
                                        <div class="input-group-append">
                                          <span class="input-group-text" style="background-color: rgb(232, 240, 254);border: none;border-left: 2px solid #ced4da;"  onclick="confirm_password_show_hide();">
                                            <i class="fas fa-eye-slash" id="show_eye1"></i>
                                            <i class="fas fa-eye d-none" id="hide_eye1"></i>
                                          </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-inline-block mt-2 pt-1" style="margin-left: 1rem;">
                                    <input type="checkbox" class="custom-control-input" id="dvmCheck" value="1" name="allow_on_dvm" @if (old('allow_on_dvm') == 1) {{ 'checked' }} @endif>
                                    <label class="form-check-label" for="dvmCheck">Would like to Sign Up on DVM Central</label>
                                </div>
                                <div class="d-inline-block mt-2 pt-1" style="margin-left: 1rem;">
                                    <input type="checkbox" class="custom-control-input" id="vetandtechCheck" value="1" name="allow_on_vetandtech" @if (old('allow_on_vetandtech') == 1) {{ 'checked' }} @endif>
                                    <label class="form-check-label" for="vetandtechCheck">Would like to Sign Up on Vet and Tech</label>
                                </div>
                                <div class="d-inline-block mt-2 pt-1" style="margin-left: 1rem;">
                                    <input type="checkbox" class="custom-control-input" id="vtFriendsCheck" value="1" name="allow_on_vt_friend" @if (old('allow_on_vt_friend') == 1) {{ 'checked' }} @endif>
                                    <label class="form-check-label" for="vtFriendsCheck">Would like to Sign Up on VT Friends</label>
                                </div>
                            </div>
                            <div class="d-inline-block w-100" style="margin-left: 0.70rem;">
                                <div class="d-inline-block mt-2 pt-1">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="customCheck1" required value="1" @if (old('customCheck1') == 1) {{ 'checked' }} @endif>
                                    <label class="form-check-label" for="customCheck1">I accept <a href="{{route('footer.termsandconditions')}}">Terms and Conditions</a></label>
                                </div>
                            </div>
                            {{-- <div class="row" style="margin-left: 0.70rem;margin-top:2rem">
                                <button type="submit" id="submitBtn" class="btn btn-primary float-end">Sign Up</button>
                            </div> --}}
                            <div class="form-button" style="margin-left: 0.70rem;">
                                <button id="submit" type="submit" class="ibtn">Sign Up</button>
                            </div>
                            <div class="sign-info" style="margin-left: 1rem;margin-top:2rem">
                                <span class="dark-color d-inline-block line-height-2">Already Have Account ? <a href="{{route('login')}}">Sign In</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="assets/login/js/jquery.min.js"></script>
<script src="assets/login/js/popper.min.js"></script>
<script src="assets/login/js/bootstrap.min.js"></script>
<script src="assets/login/js/main.js"></script>


<script type="text/javascript">
    document.getElementById("first_name_text").addEventListener("input", function(event) {
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
    document.getElementById("last_name_text").addEventListener("input", function(event) {
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
</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">

        document.getElementById("username-name").addEventListener("input", function(event) {
            var regex = /[^a-z0-9_]/g;
            var input = event.target.value;
            if (regex.test(input)) {
                event.target.value = input.replace(regex, "");
            } else {
                event.target.value = input;
            }
        });

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
                constrainInput: false,
                defaultDate: new Date(1980, 01, 01)
            });
        });
        $("#datepicker").on('keypress',function(e){
        if(event.charCode == 9 ){
            return true;
        }
            return false;
        });
    </script>
</body>
</html>