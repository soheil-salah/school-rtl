<li class="sidebar-item {{ isset($active) ? 'selected' : null }}">
	<a class="sidebar-link has-arrow {{ isset($active) ? 'active' : null }}" href="#" aria-expanded="false">
		<span class="d-flex">
			<i class="ti ti-{{ isset($icon) ? $icon : null }}"></i>
		</span>
		<span class="hide-menu">{{ $title }}</span>
	</a>
	<ul aria-expanded="false" class="collapse first-level {{ isset($active) ? 'in' : null }}">
		{{ $slot }}
	</ul>
</li>