<a {!! isset($route) ? 'href="'.route($route).'"' : 'javascript:void(0);' !!} {{ $attributes->merge(['class' => 'd-flex align-items-center gap-2 dropdown-item']) }}>
    <i class="ti ti-{{ isset($icon) ? $icon : null }} fs-6"></i>
    <p class="mb-0 fs-3">{{ $title }}</p>
</a>