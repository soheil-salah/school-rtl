<x-app-layout>

    @push('title')
        <title>معرض الصور - {{ config('app.name') }}</title>
    @endpush

    <div class="jumbotron text-center">
        <h1 class="display-3">معرض الصور</h1>
        <p class="lead">{{ config('app.name') }}</p>
    </div>

	@foreach($albums as $album)
    <div class="card-columns">
        <div class="card">
            @if($album->thumbnail == null)
			<a href="{{ route('gallery', [$album->slug]) }}"> <img src="{{ asset('assets/images/na.png') }}" alt="{{ $album->album_name }}" /></a>
			@else
			<a href="{{ route('gallery', [$album->slug]) }}"> <img src="{{ asset('uploads/gallery-album/'.$album->slug.'/thumbnail/'.$album->thumbnail) }}" alt="{{ $album->album_name }}" /></a>
			@endif
            <div class="card-body text-right">
				<h4 class="card-title">{{ $album->album_name }}</h4>
				<p class="card-text">{{ $album->photos->count().' صورة' }}</p>
            </div>
        </div>
    </div>
    @endforeach

</x-app-layout>