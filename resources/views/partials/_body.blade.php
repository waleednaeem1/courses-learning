@include('partials._body_header')
<div class="main-content">
    <div class="position-relative">
       {{$pageheader ?? ''}}
    </div>
    <div id="content-page" class="content-page">
        <div class="container">

        </div>
        {{ $slot }}
    </div>
    {{-- @include('partials.modal') --}}
</div>

@include('partials._body_footer') 
@include('partials._scripts')
@include('partials._app_toast')
