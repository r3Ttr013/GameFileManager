@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Game Library</h1>
    <div class="row">
        @forelse($games as $game)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <a href="{{ route('game.show', $game->id) }}">
                        <img src="{{ $game->image_url ?? 'default-image.jpg' }}" class="card-img-top" alt="{{ $game->name }}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('game.show', $game->id) }}">{{ $game->name }}</a>
                        </h5>
                        <p class="card-text">{{ Str::limit($game->description, 100) }}</p>
                        <p class="card-text">Rating: {{ $game->rating }}</p>
                        <p class="card-text">Released: {{ $game->released }}</p>
                        <p class="card-text">
                            Platforms: 
                            @foreach ($game->platformIcons as $icon)
                                <i class="{{ $icon }} mr-2"></i>
                            @endforeach
                        </p>
                        <p class="card-text">Genres: {{ $game->genres }}</p>
                        <p class="card-text">Path: {{ $game->path }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p>No games found in the library.</p>
        @endforelse
    </div>
</div>
@endsection
