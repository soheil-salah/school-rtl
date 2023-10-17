@isset($logo)
<img src="{{ asset($logo) }}" width="180" alt="">
@else
<h3>{{ config('app.name') }}</h3>
@endisset