@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <img src="{{ $game->image_url ?? 'default-image.jpg' }}" class="img-fluid mb-3" alt="{{ $game->name }}">
            <h1>{{ $game->name }}</h1>
            <p class="lead">{{ $game->description }}</p>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-dark text-light"><strong>Rating:</strong> {{ $game->rating }}</li>
                        <li class="list-group-item bg-dark text-light"><strong>Released:</strong> {{ $game->released }}</li>
                        <li class="list-group-item bg-dark text-light">
                            <strong>Platforms:</strong>
                            @foreach ($platformIcons as $icon)
                                <i class="{{ $icon }} mr-2"></i>
                            @endforeach
                        </li>
                        <li class="list-group-item bg-dark text-light"><strong>Genres:</strong> {{ $game->genres }}</li>
                        <li class="list-group-item bg-dark text-light"><strong>Path:</strong> {{ $game->path }}</li>
                    </ul>
                </div>
            </div>
            <a href="{{ route('directories.index') }}" class="btn btn-secondary btn-block">Back to Library</a>
        </div>
    </div>
</div>
@endsection
