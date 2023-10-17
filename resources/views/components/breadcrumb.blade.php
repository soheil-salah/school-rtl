<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">
                    {{ $title }}
                </h4>
                @isset($breadcrumbs)
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    @foreach ($breadcrumbs as $breadcrumb => $route)
                        <li class="breadcrumb-item"><a class="text-muted" {!! $route != null && $route !== 'active' ? 'href="'.route($route).'"' : 'aria-current="page"' !!}>{{ $breadcrumb }}</a></li>
                    @endforeach
                    </ol>
                </nav>
                @endisset
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <img {!! isset($image) ? 'src="'.asset($image).'"'  : null !!} class="img-fluid mb-n4">
                </div>
            </div>
        </div>
    </div>
</div>