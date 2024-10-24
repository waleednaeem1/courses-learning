<x-guest-layout>

    <section class="sign-in-page">
        <div id="container-inside">
            <div id="circle-small"></div>
            <div id="circle-medium"></div>
            <div id="circle-large"></div>
            <div id="circle-xlarge"></div>
            <div id="circle-xxlarge"></div>
        </div>
        <div class="container p-0">
            <div class="row no-gutters">
                <div class="col-md-6 text-center pt-5">
                    <div class="sign-in-detail text-white">
                        <a class="sign-in-logo mb-5" href="#"><img src="{{asset('images/logo-full.png')}}" class="img-fluid" alt="logo"></a>
                        <div class="sign-slider overflow-hidden ">
                            <ul  class="swiper-wrapper list-inline m-0 p-0 ">
                                <li class="swiper-slide">
                                    <img src="{{asset('images/login/1.png')}}" class="img-fluid mb-4" alt="logo">
                                    <h4 class="mb-1 text-white">Find new friends</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                </li>
                                <li class="swiper-slide">
                                    <img src="{{asset('images/login/2.png')}}" class="img-fluid mb-4" alt="logo">
                                    <h4 class="mb-1 text-white">Connect with the world</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                </li>
                                <li class="swiper-slide">
                                    <img src="{{asset('images/login/3.png')}}" class="img-fluid mb-4" alt="logo">
                                    <h4 class="mb-1 text-white">Create new events</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 bg-white pt-5 pt-5 pb-lg-0 pb-5">
                    <img src="{{asset('images/avatars/01.png')}}" class="rounded avatar-80 mb-3" alt="">
                     <h2 class="mb-2">Hi ! Ruben Dokidis</h2>
                     <p>Enter your password to access the admin.</p>
                     <x-auth-validation-errors class="mb-4" :errors="$errors" />
                     <form>
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="floating-label form-group">
                                 <label for="password" class="form-label">Password</label>
                                 <input type="password" class="form-control" id="password" aria-describedby="password" placeholder=" ">
                              </div>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                     </form>
                </div>
            </div>
        </div>
    </section>

</x-guest-layout>
