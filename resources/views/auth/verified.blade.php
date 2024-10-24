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
                        <a class="sign-in-logo mb-5" href="#">
                            {{-- <img src="{{asset('images/logo-full.png')}}" class="img-fluid" alt="logo"> --}}
                             <img src="https://colorfulce.vetandtech.com/assets/img/logo/colorful.png" alt="userimg" width="150px" height="100px" loading="lazy">
                             {{-- <h3 class="logo-title d-none d-sm-block" data-setting="app_name">VT Friends</h3> --}}
                        </a>
                        <div class="sign-slider overflow-hidden ">
                            <ul  class="swiper-wrapper list-inline m-0 p-0 ">
                                <li class="swiper-slide">
                                    <img src="{{asset('assets/login/images/graphic1.svg')}}" class="img-fluid mb-4 rounded" alt="logo">
                                    <h4 class="mb-1 text-white">Find new friends</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 bg-white pt-5 pt-5 pb-lg-0 pb-5">
                    <div class="EmailVerified_container__30zJM sec-container mt-5">
                        <img alt="Email verified" src="https://www.dvmcentral.com/_next/static/media/email.d7c8e4e0.svg" style="/* position:absolute; */top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;/* width: 38px; */height: 234px;/* min-width:100%; *//* max-width:100%; *//* min-height:100%; */max-height:100%"></span>
                        <div class="media-pl" style="padding-left: 28%;">
                            <h1 class="secondary-color">Congratulations</h1>
                            <h4>Welcome to Colorful CE</h4>
                            <p class="gray-color">Your email has verified and you can sign-in now.</p>
                            <a href="/login"><button class="btn btn-info" style="background-color: #6c2b95;color: #fff;">Proceed to Sign In</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-guest-layout>
