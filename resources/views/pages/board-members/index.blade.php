<x-app-layout>

    @push('title')
        <title>اعضاء هئية التدريس - {{ config('app.name') }}</title>
    @endpush

    <div class="jumbotron text-center">
        <h1 class="display-3">اعضاء هئية التدريس</h1>
        <p class="lead">{{ config('app.name') }}</p>
    </div>

    @foreach($boardMembers as $boardMember)
    <div class="card-columns">
        <div class="card">
            @if($boardMember->image != null)
            <a href="{{ route('board-member.show', [$boardMember->slug]) }}"> <img class="card-img-top" src="{{ asset('uploads/board-members/teachers/'.$boardMember->slug.'/'.$boardMember->image) }}" alt="{{ $boardMember->name }}" /></a>
            @else
            <a href="{{ route('board-member.show', [$boardMember->slug]) }}"> <img class="card-img-top" src="{{ asset('assets/images/na.png') }}" alt="{{ $boardMember->name }}" /></a>
            @endif
            <div class="card-body text-right">
                <h4 class="card-title">{{ $boardMember->name }}</h4>
                <p class="card-text">{{ $boardMember->title }}</p>
            </div>
        </div>
    </div>
    @endforeach

</x-app-layout>