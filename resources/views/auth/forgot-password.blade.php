<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="assets/login/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="assets/login/css/iofrm-theme7.css">
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
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Password Reset</h3>
                        <p>To reset your password, enter the email address you use to sign in to Colorful CE</p>
                        {{-- <form method="POST" class="mt-4" action="{{ route('password.email') }}" data-toggle="validator" class="">
                            {{csrf_field()}}
                            <input class="form-control" type="text" name="email" placeholder="E-mail Address" required>
                            <div class="form-button full-width">
                                <button id="submit" type="submit" class="ibtn btn-forget">Send Reset Link</button>
                            </div>
                        </form> --}}
                        <form method="POST" class="mt-4" action="{{ route('password.email') }}" data-toggle="validator" class="">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="floating-label form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email", name="email" aria-describedby="email" placeholder=" ">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" id="resetFormButton" class="btn btn-primary btn-block">  {{ __('Reset') }}</button>
                        </form>
                    </div>
                    <div class="form-sent">
                        <div class="tick-holder">
                            <div class="tick-icon"></div>
                        </div>
                        <h3>Password link sent</h3>
                        <p>Please check your inbox iofrm@iofrmtemplate.io</p>
                        <div class="info-holder">
                            <span>Unsure if that email address was correct?</span> <a href="#">We can help</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="assets/login/js/jquery.min.js"></script>
<script src="assets/login/js/popper.min.js"></script>
<script src="assets/login/js/bootstrap.min.js"></script>
<script src="assets/login/js/main.js"></script>
</body>
</html>