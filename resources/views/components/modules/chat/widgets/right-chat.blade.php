<div class="iq-message-body iq-current-user">
    <div class="chat-profile">
        <img src="{{asset('images/chat')}}/{{$userImg}}" alt="chat-user" class="avatar-40 rounded-pill" loading="lazy">
    </div>
    <div class="iq-chat-text">
        <small class="iq-chating p-0">{{$username}}, {{$messageTime}}</small>
        <div class="d-flex align-items-center justify-content-end">
            <div class="iq-chating-content d-flex align-items-center $Image == 'true' ??  iq-image : '' ">
                <p class="mr-2 mb-0">{{$message  ?? ''}}</p>

                <span class="badge rounded-pill bg-warning">{{$unreadMessage ?? ''}}</span>
            </div>
        </div>
    </div>
</div>
