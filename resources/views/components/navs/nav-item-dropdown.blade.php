<li {{ $attributes->merge(['class' => 'nav-item dropdown']) }}>
    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $title }}</a>
    <div class="dropdown-menu" aria-labelledby="dropdownId">
        {{ $slot }}
    </div>
</li>