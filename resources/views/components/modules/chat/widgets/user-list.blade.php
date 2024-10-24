@props(['className','id','chatId','userName','userProfileImg','status','lastMessage','userMessage','unreadMessage'])
{{-- @php
    session()->put('chatId', $chatId);
@endphp --}}
<li class="nav-item iq-chat-list {{$className  ?? ''}}">
    <a href="#user-content-{{$id}}" class="nav-link px-0 d-flex gap-3 {{$className  ?? ''}}" data-bs-toggle="tab" role="tab" aria-controls="user-content-{{$id}}" aria-selected="true" onclick=fetchChats({{$chatId}})>
        <div class="position-relative">
            @if(isset($userProfileImg) && $userProfileImg !== '')
                {{-- <img src="{{ asset('storage/images/user/userProfileandCovers/'.$id.'/'.$userProfileImg)}}" alt="status-{{$id}}" class="avatar-50 rounded" loading="lazy"> --}}
                <img src="{{asset('images/chat/avatar/06.png')}}" alt="chat-user" class="avatar-50 rounded" loading="lazy">
            @else
                <img src="{{asset('images/chat/avatar/06.png')}}" alt="chat-user" class="avatar-50 rounded" loading="lazy">
            @endif

            <div class="iq-profile-badge {{$status ?? '' == 'online' ?  'bg-success' : 'bg-danger'}}  "></div>
        </div>
        <div class="d-flex align-items-center w-100 iq-userlist-data">
            <div class="d-flex flex-grow-1 flex-column">
                <div class="d-flex align-items-center gap-1">
                    <p class="mb-0 text-ellipsis short-1 flex-grow-1 iq-userlist-name">{{$userName}}</p>
                    <small class="text-capitalize">{{$lastMessage  ?? ''}}</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <small class="text-ellipsis short-1 flex-grow-1">{{$userMessage  ?? ''}}</small>
                    @if($unreadMessage  ?? '')
                        <span class="badge rounded-pill bg-primary">{{$unreadMessage  ?? ''}}</span>
                    @endif
                </div>
            </div>
        </div>
    </a>
</li>
