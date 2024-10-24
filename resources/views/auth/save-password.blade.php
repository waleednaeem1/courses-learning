<x-guest-layout>
    @php
        $url = url()->current();
        $url = explode('/', $url);
        $email =$url[4];
        $userOtpData = DB::table('password_resets')->where(['email'=> $email])->first();
    @endphp
        <div class="form-body">
           <div class="website-logo">
            <a href="{{route('login')}}">
                <div class="logo">
                    <img class="logo-size" src={{ asset("https://colorfulce.vetandtech.com/assets/img/logo/colorful.png") }} alt="">
                </div>
            </a>
        </div>
            <div class="row">
                <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src={{ asset("assets/login/images/graphic1.svg") }} alt="">
                </div>
               </div>
                <div class="col-md-6 bg-white pt-5 pb-lg-0 pb-5" style="margin-left: 44%;padding-top: 6% !important;">
                    <h2 class="mb-2">Create New Password</h2>
                    <p>Create a new strong password to protect your account</p>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" class="mt-4" action="{{ route('password.update') }}" data-toggle="validator" class="">
                        @csrf
                        <input type="hidden" name="email" value = {{$email}}>
                        {{-- <input type="hidden" name="token" id="token" value="{{$url[4]}}" > --}}
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            {{-- <a href="{{route('password.request')}}" class="float-end">Forgot password?</a> --}}
                            <input class="form-control" type="password" placeholder="********"  name="password" value="{{ env('IS_DEMO') ? 'password' : '' }}" required autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <label for="confirm-password" class="form-label">Confirm Password</label>
                            <input class="form-control" type="password" placeholder="********"  name="password_confirmation" value="{{ env('IS_DEMO') ? 'password' : '' }}" required autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <label for="otp" class="form-label">OTP</label>
                            <input class="form-control"  type="text" placeholder="********"  name="otp" required">
                        </div>

                        <div style="font-size: 14px; color:rgb(180, 25, 25)" id="otp-timer">Your OTP will expire in <span id="timer"></span> seconds</div> <br>
                        <button type="submit" class="btn btn-primary btn-block">  {{ __('Submit') }}</button>
                    </form>
                    <div class="mt-2">
                        <form method="POST" action="{{ route('email.resend')}}">
                            @csrf
                            <input type="hidden" name="email" value = {{$email}}>
                            <button type="submit" class="btn btn-primary btn-block">  {{ __('Resend OTP') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-guest-layout>
    @if(strtotime($userOtpData->created_at) > strtotime("-1 minutes"))
    @php
        $diff = strtotime($userOtpData->created_at) - strtotime("-1 minutes");
    @endphp
        <script>
            let diff = {!! json_encode($diff) !!}; console.log(diff)
            setTimeout(() => {
                    timer(diff);
                }, "10")
                timer(60);
        </script>
    @else
        <script>
            document.getElementById('otp-timer').innerHTML = '';
        </script>
    @endif
    <script>
        let timerOn = true;
        function timer(remaining) {
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;
            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            document.getElementById('timer').innerHTML =  s;
            remaining -= 1;
            if(remaining >= 0 && timerOn) {
                setTimeout(function() {
                    timer(remaining);
                }, 1000);
                return;
            }
            if(!timerOn) {
                document.getElementById('otp-timer').innerHTML = '';
            }
            document.getElementById('otp-timer').innerHTML = 'OTP expired. Click on Resend OTP button to get a new code';
        }
    </script>

