@php
    $user = auth()->user();
@endphp

<aside class="sidebar sidebar-chat sidebar-default border-end shadow-none" data-sidebar="responsive">
    <div class="chat-search pt-3 px-3">
        <div class="d-flex align-items-center">
            <div class="chat-profile me-3 avatar-60 rounded-pill text-primary btn-icon bg-body">
                @if(isset($user->avatar_location) && $user->avatar_location !== '')
                    <img src="{{ asset('storage/images/user/userProfileandCovers/'.$user->id.'/'.$user->avatar_location)}}" alt="101" class="avatar-60  rounded" loading="lazy">
                @else
                    <img src="{{asset('images/chat/avatar/01.png')}}" alt="101" class="avatar-60  rounded" loading="lazy">
                @endif
            </div>
            <div class="chat-caption">
                <h5 class="mb-0">{{$user->first_name}} {{$user->last_name}}</h5>
                {{-- <p class="m-0">Web Designer</p> --}}
            </div>
            <button type="submit" class="close-btn-res p-3"><i class="material-symbols-outlined md-18">close</i></button>
        </div>
        <div id="user-detail-popup" class="scroller">
            <div class="user-profile">
                <button type="submit" class="close-popup p-3"><i class="material-symbols-outlined md-18">close</i></button>
                <div class="user text-center mb-4">
                <a class="avatar m-0">
                    {{-- <img src="{{asset('images/user/1.jpg')}}" alt="avatar" loading="lazy"> --}}
                    @if(isset($user->avatar_location) && $user->avatar_location !== '')
                        <img src="{{ asset('storage/images/user/userProfileandCovers/'.$user->id.'/'.$user->avatar_location)}}" width="100px" height="100px" alt="avatar" loading="lazy">
                        {{-- <img src="{{asset('images/user/1.jpg')}}" alt="avatar" loading="lazy"> --}}
                    @else
                        <img src="{{asset('images/user/1.jpg')}}" alt="avatar" loading="lazy">
                    @endif

                </a>
                <div class="user-name mt-4">
                    <h4 class="text-center">{{$user->first_name}} {{$user->last_name}}</h4>
                </div>
                <div class="user-desc">
                    {{-- <p class="text-center">Web Designer</p> --}}
                </div>
                </div>
                <hr>
                <div class="user-detail text-left mt-4 ps-4 pe-4">
                <h5 class="mt-4 mb-4">About</h5>
                <p>It is long established fact that a reader will be distracted bt the reddable.</p>
                <h5 class="mt-3 mb-3">Status</h5>
                <ul class="user-status p-0">
                    <li class="mb-1 d-flex align-items-center">
                        <i class="material-symbols-outlined filled text-success pe-1 md-14">
                            circle
                        </i>
                        <span>Online</span>
                    </li>
                    <li class="mb-1 d-flex align-items-center">
                        <i class="material-symbols-outlined filled text-warning pe-1 md-14">
                            circle
                        </i>
                        <span>Away</span>
                    </li>
                    <li class="mb-1 d-flex align-items-center">
                        <i class="material-symbols-outlined filled text-danger pe-1 md-14">
                            circle
                        </i>
                        <span>Do Not Disturb</span>
                    </li>
                    <li class="mb-1 d-flex align-items-center">
                        <i class="material-symbols-outlined filled text-light pe-1 md-14">
                            circle
                        </i>
                        <span>Offline</span>
                    </li>
                </ul>
                </div>
            </div>
        </div>
         <div class="sidebar-toggle d-block d-xl-none" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg class="icon-20" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
        <div class="chat-searchbar mt-4 mb-3">
            <div class="form-group chat-search-data m-0">
                <input type="text" class="form-control round" id="chat-search" placeholder="Search">
                <i class="material-symbols-outlined">
                search
                </i>
            </div>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar mb-5 pb-5">
      <x-modules.chat.partials.vertical-nav />
    </div>
    <div class="sidebar-footer"></div>
</aside>

