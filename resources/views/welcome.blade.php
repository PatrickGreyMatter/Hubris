@extends('layouts.app')

@section('content')
<div class="container">
    <div class="wrapper">

        @if(session('success'))
        <div class="alert alert-primary">
            {{ session('success') }}
        </div>
        @endif

        @include('partials._carousel', ['carouselId' => 8, 'carouselTitle' => 'Derniers ajouts', 'films' => $latestFilms])
        @include('partials._carousel', ['carouselId' => 1, 'carouselTitle' => 'Films americains', 'films' => $americanfilms])
        @include('partials._carousel', ['carouselId' => 2, 'carouselTitle' => 'Films Français', 'films' => $frenchFilms])
        @include('partials._carousel', ['carouselId' => 3, 'carouselTitle' => "Films d'horreur", 'films' => $horrorFilms])
        @include('partials._carousel', ['carouselId' => 4, 'carouselTitle' => 'Drames', 'films' => $dramaFilms])
        @include('partials._carousel', ['carouselId' => 5, 'carouselTitle' => 'Comedies', 'films' => $comedyFilms])
        @include('partials._carousel', ['carouselId' => 6, 'carouselTitle' => 'Films de science fiction', 'films' => $sfFilms])
        @include('partials._carousel', ['carouselId' => 7, 'carouselTitle' => 'Thrillers', 'films' => $thrillerFilms])
    </div>
</div>
@endsection