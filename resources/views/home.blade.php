@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Recently Added Games</h1>
    <div class="row">
        @foreach($games as $game)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ $game['background_image'] ?? 'default-image.jpg' }}" class="card-img-top" alt="{{ $game['name'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $game['name'] }}</h5>
                        <p class="card-text">{{ $game['description_raw'] ?? 'No description available' }}</p>
                        <p class="card-text">Rating: {{ $game['rating'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
