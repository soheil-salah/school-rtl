<li class="sidebar-item">
    <a {{ $attributes->merge(['class' => 'sidebar-link' ]) }} {!! isset($route) ? 'href="'.route($route).'"' : 'javascript:void(0);' !!} aria-expanded="false">
        <span>
            <i class="ti ti-{{ isset($icon) ? $icon : null }}"></i>
        </span>
        <span class="hide-menu">{{ $title }}</span>
    </a>
</li>