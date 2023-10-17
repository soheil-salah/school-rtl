<x-app-layout>

    @push('title')
        <title>من نحن - {{ config('app.name') }}</title>
    @endpush

    <div class="jumbotron text-center">
        <h1 class="display-3">من نحن</h1>
        <p class="lead">{{ config('app.name') }}</p>
    </div>

</x-app-layout>