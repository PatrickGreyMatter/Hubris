@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- Profile Information Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Informations de profil') }}</div>
                <div class="card-body text-center">
                    @if ($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="rounded-circle mb-3" style="max-width: 150px;">
                    @else
                        <img src="{{ asset('images/default-profile.jpg') }}" alt="Default Profile Picture" class="rounded-circle mb-3" style="max-width: 150px;">
                    @endif
                    <h4>{{ $user->name }}</h4>
                    <p>{{ $user->public_description }}</p>
                    @if(Auth::check() && Auth::user()->role == 'admin')
                        <form action="{{ route('user.ban', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir bannir cet utilisateur ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Bannir</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Collapsible Forms Section -->
        <div class="col-md-8">
            <!-- Bibliothèque Section -->
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-outline-dark border-0 rounded-0" data-toggle="collapse" href="#favoriteFilms" role="button" aria-expanded="false" aria-controls="favoriteFilms">
                        {{ __('Bibliothèque') }}
                    </a>
                </div>
                <div class="collapse" id="favoriteFilms">
                    <div class="card-body">
                        @include('partials._carousel', ['carouselId' => 9, 'carouselTitle' => 'Mes films favoris', 'films' => $favoriteFilms, 'isLibrary' => true])
                    </div>
                </div>
            </div>

            <!-- User Comments Section -->
            <div class="card mt-4">
                <div class="card-header">
                    <a class="btn btn-outline-dark border-0 rounded-0" data-toggle="collapse" href="#userComments" role="button" aria-expanded="false" aria-controls="userComments">
                        {{ __('Commentaires de l\'utilisateur') }}
                    </a>
                </div>
                <div class="collapse" id="userComments">
                    <div class="card-body">
                        @foreach ($userComments as $comment)
                            <div class="mb-3">
                                <strong>Film: {{ $comment->media->title }}</strong> <br>
                                <strong>Date: {{ $comment->created_at->format('d/m/Y H:i') }}</strong> <br>
                                <p>{{ $comment->content }}</p>
                                <hr>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
