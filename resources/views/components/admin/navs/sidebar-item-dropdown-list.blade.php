<li class="sidebar-item {{ isset($active) ? 'active' : null }}">
	<a href="{{ isset($route) ? route($route) : 'javascript:void(0);' }}" class="sidebar-link {{ isset($active) ? 'active' : null }}">
		<div class="round-16 d-flex align-items-center justify-content-center">
			<i class="ti ti-{{ isset($icon) ? $icon : null }}"></i>
		</div>
		<span class="hide-menu">{{ $title }}</span>
	</a>
</li>