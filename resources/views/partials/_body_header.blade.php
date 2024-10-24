@php
   use App\Models\CartItem;
   if(auth()->user()){
   $user = auth()->user();
   $userCartItemsCount = count(CartItem::where([['customer_id', $user->id], ['type' , 'course']])->get());
  }

@endphp
<div class="iq-top-navbar">
   <header id="header_main" class="saas_two_main_header">
      <div class="container">
         <div class="s_main_menu">
            <div class="row">
               <div class="col-md-3">
                     <div class="brand_logo">
                        <a href="{{route('home')}}"><img src="https://colorfulce.vetandtech.com/assets/img/logo/colorful2.png" alt=""></a>
                     </div>
               </div>
               <div class="col-md-9">
                  <div class="main_menu_list clearfix float-right">
                     <nav class="s2-main-navigation  clearfix ul-li">
                        <ul id="main-nav" class="navbar-nav text-capitalize clearfix">
                           <li class="side-demo position-relative"><a href="{{route('home')}}">Home</a></li>
                           <li><a href="{{route('practice')}}">Practice Profile</a></li>
                           <li><a href="{{route('team')}}"> My Team</a></li>
                           <li><a href="{{route('user-account')}}">My Account</a></li>
                           <li><a href="{{route('cart')}}">My Basket <span id='cart_items'> @if( isset($userCartItemsCount) && $userCartItemsCount > 0) ({{$userCartItemsCount}}) @endif</span></a></li>
                        </ul>
                     </nav>
                     <div class="dropdown show saas_sign_up_btn text-center">
                        <a class="saas_sign_up_btn text-center dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           @if(isset($user)) {{strlen($user->fullname) > 17 ? substr($user->fullname,0,17)."..." : $user->fullname}}   @else User @endif</a>
                        </a>
                        <div class="dropdown-menu" style="line-height: 1;border-bottom: none !important;" aria-labelledby="dropdownMenuLink">
                           @if(isset($user) && $user->username != null && $user->username != '')
                              <a href="{{route('user-account')}}" class="dropdown-item" style="color: blueviolet;margin-bottom: 10px;">
                                 <div class="d-flex align-items-center iq-sub-card border-0">
                                    <span class="material-symbols-outlined">
                                       person
                                    </span>
                                    &nbsp;  My Account
                                 </div>
                              </a>
                           @endif
                          {{-- <a href="{{route('profileedit')}}" class="dropdown-item" style="color: blueviolet;margin-bottom: 10px;">
                              <div class="d-flex align-items-center iq-sub-card border-0">
                                 <span class="material-symbols-outlined">
                                    edit_note
                                 </span>
                                    Edit Profile
                              </div>
                           </a> --}}
                          <a href="{{route('myCourses')}}" class="dropdown-item" style="color: blueviolet;margin-bottom: 10px;">
                              <div class="d-flex align-items-center iq-sub-card border-0">
                                 <span class="material-symbols-outlined">
                                    library_books
                                 </span>
                                &nbsp; My Courses
                              </div>
                           </a>
                          <a href="{{route('coursesList')}}" class="dropdown-item" style="color: blueviolet;margin-bottom: 10px;">
                              <div class="d-flex align-items-center iq-sub-card border-0">
                                 <span class="material-symbols-outlined">
                                    library_books
                                 </span>
                                &nbsp; Purchase Courses
                              </div>
                           </a>
                           <a href="{{route('marking')}}" class="dropdown-item" style="color: blueviolet;margin-bottom: 10px;">
                              <div class="d-flex align-items-center iq-sub-card border-0">
                                 <span class="material-symbols-outlined">
                                    edit_note
                                 </span>
                                 &nbsp;  Marking
                              </div>
                           </a>
                           <a href="{{route('events')}}" class="dropdown-item" style="color: blueviolet;margin-bottom: 10px;">
                              <div class="d-flex align-items-center iq-sub-card border-0">
                                 <span class="material-symbols-outlined">
                                    notifications
                                 </span>
                                    &nbsp;  My Events
                              </div>
                           </a>
                           <hr>
                           <a href="{{route('myPractice')}}" class="dropdown-item" style="color: blueviolet;margin-bottom: 10px;">
                              <div class="d-flex align-items-center iq-sub-card border-0">
                                 <span class="material-symbols-outlined">
                                    line_style
                                 </span>
                                 &nbsp; My Practice
                              </div>
                           </a>
                           {{-- <a href="{{route('certificates')}}" class="dropdown-item" style="color: blueviolet;margin-bottom: 10px;">
                              <div class="d-flex align-items-center iq-sub-card border-0">
                                 <span class="material-symbols-outlined">
                                    article
                                 </span>
                                 &nbsp; Certificates
                              </div>
                           </a> --}}
                           <a href="{{route('practice')}}" class="dropdown-item" style="color: blueviolet;margin-bottom: 10px;">
                              <div class="d-flex align-items-center iq-sub-card border-0">
                                 <span class="material-symbols-outlined">
                                    person
                                 </span>
                                &nbsp; Edit Practice
                              </div>
                           </a>
                           <a href="{{route('team')}}" class="dropdown-item" style="color: blueviolet;margin-bottom: 10px;">
                              <div class="d-flex align-items-center iq-sub-card border-0">
                                 <span class="material-symbols-outlined">
                                    groups
                                 </span>
                               &nbsp; Manage Staff
                              </div>
                           </a>
                           {{-- <a href="{{route('practiceBilling')}}" class="dropdown-item" style="color: blueviolet;margin-bottom: 10px;">
                              <div class="d-flex align-items-center iq-sub-card border-0">
                                 <span class="material-symbols-outlined">
                                    menu
                                 </span>
                               &nbsp; Practice Billing
                              </div>
                           </a> --}}
                           <form method="POST" class="signout-anchor mb-3" action="{{route('logout')}}">
                              @csrf
                              <a href="javascript:void(0)" style="color: blueviolet;padding-left:0;margin-bottom: 10px;" onclick="event.preventDefault(); this.closest('form').submit();">
                                 <div class="d-flex align-items-center iq-sub-card">
                                    <span class="material-symbols-outlined">
                                       logout
                                    </span>
                                    <div>
                                       &nbsp;    {{ __('Sign out') }}
                                    </div>
                                 </div>
                              </a>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- //desktop menu -->
         <div class="s2-mobile_menu relative-position">
            <div class="s2-mobile_menu_button s2-open_mobile_menu">
               <i class="fas fa-bars"></i>
            </div>
            <div class="s2-mobile_menu_wrap">
               <div class="mobile_menu_overlay s2-open_mobile_menu"></div>
               <div class="s2-mobile_menu_content">
                     <div class="s2-mobile_menu_close s2-open_mobile_menu">
                        <i class="far fa-times-circle"></i>
                     </div>
                     <div class="m-brand-logo text-center">
                        <a href="{{route('home')}}"><img src="https://colorfulce.vetandtech.com/assets/img/logo/colorful2.png" alt=""></a>
                     </div>
                     <nav class="s2-mobile-main-navigation  clearfix ul-li">
                        <ul id="m-main-nav" class="navbar-nav text-capitalize clearfix">
                           {{-- <li class="side-demo position-relative"><a href="#!">Demos</a> <span>New</span></li> --}}
                           <li><a href="{{route('home')}}">Home</a></li>
                           <li><a href="{{route('practice')}}">Practice Profile</a></li>
                           <li><a href="{{route('team')}}">My Team</a></li>
                           <li><a href="{{route('user-account')}}">My Account</a></li>
                           <li><a href="{{route('cart')}}">My Basket <span id='cart_items'> @if( isset($userCartItemsCount) && $userCartItemsCount > 0) ({{$userCartItemsCount}}) @endif</span></a></li>

                           {{-- <li class="dropdown">
                                 <a href="#">Pages</a>
                                 <ul class="dropdown-menu clearfix">
                                    <li><a target="_blank" href="team.html">Team Page</a></li>
                                    <li><a target="_blank" href="service.html">Service 1</a></li>
                                    <li><a target="_blank" href="service-2.html">Service 2</a></li>
                                    <li><a target="_blank" href="faq.html">FAQ Page</a></li>
                                    <li><a target="_blank" href="privacy-policy.html">Privacy Policy</a></li>
                                    <li><a target="_blank" href="terms-condition.html">Terms & Condition</a></li>
                                 </ul>
                           </li>
                           <li class="dropdown">
                                 <a href="#">Contact</a>
                                 <ul class="dropdown-menu clearfix">
                                    <li><a target="_blank" href="contact.html">Contact 1</a></li>
                                    <li><a target="_blank" href="contact-2.html">Contact 2</a></li>
                                 </ul>
                           </li>
                           <li class="dropdown">
                                 <a href="#">Portfolio</a>
                                 <ul class="dropdown-menu clearfix">
                                    <li><a target="_blank" href="portfolio.html">Portfolio Filter</a></li>
                                    <li><a target="_blank" href="portfolio-2.html">Portfolio Page 2</a></li>
                                    <li><a target="_blank" href="project-single.html">Portfolio Details</a></li>
                                 </ul>
                           </li>
                           <li class="dropdown">
                                 <a href="#">Blog</a>
                                 <ul class="dropdown-menu clearfix">
                                    <li><a target="_blank" href="blog.html">Blog Page</a></li>
                                    <li><a target="_blank" href="blog-grid.html">Blog Page</a></li>
                                    <li><a target="_blank" href="blog-single.html">Blog Details</a></li>
                                 </ul>
                           </li> --}}
                        </ul>
                     </nav>
               </div>
            </div>
         </div>
      </div>
   </header>
</div>
