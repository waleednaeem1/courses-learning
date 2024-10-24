@php
    $user = auth()->user();
@endphp
<style>
    .modal {
    --bs-modal-width: 800px !important;
}
</style>
<x-app-layout>
    <div class="container">
        <div class="card" style="margin-top:2rem">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 style="padding-top: 5px;">Events</h4>
                </div>
            </div>
        </div>
        @if(isset($data['events']) && count($data['events']) > 0)
            <div class="row">
                @foreach($data['events'] as $event)
                    {{-- <a href="{{route('webinar.webinardetail',  ['slug' => $event->slug])}}"> --}}
                    <div class="col-lg-4 col-md-6">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body profile-page p-0">
                                <a href="https://www.vetandtech.com/webinars/{{$event->slug}}" target="_blank">
                                    <div class="profile-header-image">
                                        <div class="cover-container">
                                            @if(isset($event->thumbnail) && $event->thumbnail !== '')
                                                <img src="https://web.dvmcentral.com/up_data/events/images/{{$event->thumbnail}}" style="object-fit: cover"  alt="cover-bg" class="rounded w-100">
                                                {{-- <img src="https://web.dvmcentral.com/up_data/webiners/images/202303275616.jpg"  style="object-fit: cover"  alt="cover-bg" class="rounded w-100"> --}}
                                            @else
                                                <img src="{{asset('images/page-img/profile-bg2.jpg')}}" alt="profile-bg" class="rounded img-fluid w-100">
                                            @endif
                                        </div>
                                        <div class="profile-info p-4">
                                            <div class="user-detail">
                                            <div class="d-flex flex-wrap justify-content-between align-items-start">
                                                <div class="profile-detail d-flex">
                                                    <div class="user-data-block">
                                                        <h6>{{$event->name}}</h6>
                                                        <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($event->start_date)->isoFormat('MMM D, YYYY h:mm A')}}</p>
                                                    </div>
                                                </div>
                                                {{-- <a class="btn btn-primary d-block join-group" id="registerForWebinar" data-bs-toggle="modal" data-bs-target="#post-modal" action="javascript:void();">Register</a> --}}
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="margin-top:2rem">
                <h4 style="margin-bottom: 2rem; color: #8C68CD;margin-left:4rem">Events Coming soon....</h4>
            </div>
        @endif
    </div>
</x-app-layout>
