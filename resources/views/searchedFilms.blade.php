@extends('layouts.app')

@section('content')
<div class="container">
    <div class="wrapper">
        <h3 class="search-result-heading" style="margin-top: 60px;">Résultats de recherche pour "{{$query}}"</h3>
        <div class="row">
            @foreach ($films as $film)
                <div class="col-md-3 mb-4">
                    <a href="{{ route('film.show', ['slug' => $film->slug]) }}" class="d-block text-decoration-none text-dark">
                        <div class="card h-100">
                            <img class="img-fluid" src="{{ asset($film->thumbnail) }}" alt="{{ $film->title }}" style="width: 100%; height: 300px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $film->title }}</h5>
                                <p class="card-text">Durée: {{ $film->length }}</p>
                                <p class="card-text">De {{ $film->director->name }}</p>
                                <p class="card-text">
                                    Tags: 
                                    @foreach ($film->tags as $tag)
                                        <span class="badge badge-primary">{{ $tag->name }}</span>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
  .search-result-heading {
    color: white;
  }
</style>
@endsection