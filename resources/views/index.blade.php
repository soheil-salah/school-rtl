<x-app-layout>

    @push('title')
        <title>الرئيسية - {{ config('app.name') }}</title>
    @endpush

    <div class="jumbotron text-center">
        <h1 class="display-3">الرئيسية</h1>
        <p class="lead">{{ config('app.name') }}</p>
    </div>

</x-app-layout>