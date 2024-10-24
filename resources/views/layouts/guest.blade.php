<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Colorful CE</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        @include('partials._head')

    </head>
    <body class=" " >
        {{-- <div id="loading">
            @include('partials._body_loader')
        </div> --}}
        <div class="wrapper">
            {{ $slot }}
        </div>
        {{-- @include('partials._body_footer')  --}}
         @include('partials._scripts')
    </body>
</html>
