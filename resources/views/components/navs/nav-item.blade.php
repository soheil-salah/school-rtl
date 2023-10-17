<li {{ $attributes->merge(['class' => 'nav-item']) }}>
    <a class="nav-link" href="{{ isset($route) ? route($route) : 'javascript:void(0);' }}">
        {{ $title }}
    </a>
</li>