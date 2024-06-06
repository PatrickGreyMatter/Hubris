@extends('layouts.app')

@section('content')
<div class="container">
    <div class="wrapper">
        <h3 class="search-result-heading" style="margin-top: 60px;">Résultats de recherche pour "{{$query}}"</h3>
        <div class="row">
            @foreach ($films as $film)
                @include('partials.filmCard', ['film' => $film])
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