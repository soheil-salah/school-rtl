<x-app-layout>

    @push('title')
        <title>{{ $album->album_name }} - {{ config('app.name') }}</title>
    @endpush

    <div class="jumbotron text-center mb-5">
        <h3 class="display-4">معرض الصور - {{ $album->album_name }}</h3>
        <p class="lead">{{ config('app.name') }}</p>
    </div>

    <div class="row mt-5">
        @foreach($album->photos as $photo)
        <div class="col-lg-4 col-md-6">
            <a href="{{ asset('uploads/gallery-album/'.$album->slug.'/'.$photo->image_name) }}" class="image-pop">
                <img src="{{ asset('uploads/gallery-album/'.$album->slug.'/'.$photo->image_name) }}" alt="gallery" />
            </a>
        </div>
        @endforeach
    </div>

</x-app-layout>