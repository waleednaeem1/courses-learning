<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="assets/login/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/login/css/iofrm-style.css?version=0.01">
    <link rel="stylesheet" type="text/css" href="assets/login/css/iofrm-theme7.css?version=0.01">
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
                        @if(session()->has('msg'))
                         <p class="alert alert-success"> {{ session()->get('msg') }}</p>
                        @endif

                        @if($errors->any())
                          <p class="alert alert-danger"> {{ $errors->first() }}  </p>
                        @endif

                        <h3>Get more things done with Login platform.</h3>
                        <p>Access to the most powerfull tool in the entire design and web industry.</p>
                        <div class="page-links">
                            <a href="{{route('login')}}" class="active">Login</a>
                            <a href="{{route('register')}}">Register</a>
                        </div>
                        {{-- <form method="POST" action="{{ route('login') }}">
                            {{csrf_field()}}
                            <input class="form-control" type="text" name="username" placeholder="E-mail Address" required>
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Login</button> <a href="{{route('password.request')}}">Forget password?</a>
                            </div>
                        </form> --}}

                        <form method="POST" class="mt-4" action="{{ route('login') }}" data-toggle="validator" class="">
                            {{csrf_field()}}

                            <div class="form-group">
                                <input id="email" type="email" name="email"   class="form-control" @if(Cookie::has('adminuser')) value="{{ Cookie::get('adminuser') }}" @else value="{{env('IS_DEMO') ? 'admin@example.com' : old('email')}}" @endif  placeholder="admin@example.com" required autofocus>
                            </div>
                            <div class="form-group">
                                <div  class="flex justify-between items-center border-gray-200 mt-2 bg-gray-100 input-group mb-3">
                                    <input style="border-right: rgb(232, 240, 254);" class="input form-control" @if(Cookie::has('adminpwd')) value="{{ Cookie::get('adminpwd') }}" @else value="{{ env('IS_DEMO') ? 'password' : '' }}"  @endif type="password" placeholder="********" id="password"  name="password" required autocomplete="current-password">
                                    <span class="input-group-text" style="background-color: rgb(232, 240, 254);border: none;border-left: 2px solid #ced4da;" onclick="password_show_hide();">
                                        <i class="fas fa-eye-slash" id="show_eye"></i>
                                        <i class="fas fa-eye d-none" id="hide_eye"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Login</button> <a href="{{route('password.request')}}">Forget password?</a>
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
</body>
</html>