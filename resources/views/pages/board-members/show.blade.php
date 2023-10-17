<x-app-layout>

    @push('title')
        <title>{{ $boardMember->name }} - {{ config('app.name') }}</title>
    @endpush

    <div class="jumbotron text-center">
        <h3 class="display-5">اعضاء هئية التدريس - {{ $boardMember->name }}</h3>
        <p class="lead">{{ config('app.name') }}</p>
    </div>

    <div class="row text-right">
        <div class="col-lg-4 col-sm-12">
            @if($boardMember->image != null)
            <img src="{{ asset('uploads/board-members/teachers/'.$boardMember->slug.'/'.$boardMember->image) }}" alt="{{ $boardMember->name }}" />
            @else
            <img src="{{ asset('assets/images/na.png') }}" alt="{{ $boardMember->name }}" />
            @endif
            <hr>
            <h4>{{ $boardMember->name }}</h4>
            <small><b>{{ $boardMember->title }}</b></small>
        </div>
        <div class="col-lg-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>نبذة عن - {{ $boardMember->name }}</h4>
                </div>
                <div class="card-body">
                    {!! $boardMember->about !!}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>