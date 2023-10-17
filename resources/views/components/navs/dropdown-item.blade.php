<a {{ $attributes->merge(['class' => 'dropdown-item']) }} href="{{ isset($route) ? route($route) : 'javascript:void(0);' }}">
    {{ $title }}
</a>