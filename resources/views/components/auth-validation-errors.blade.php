@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="alert alert-danger p-2" role="alert">
            {!! $errors->first() !!}
        </div>
    </div>
@endif
