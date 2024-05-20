@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header outline-black">{{ __('Mon espace') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Bonjour') }} {{ Auth::user()->name }}{{ __(', bienvenu dans votre espace.') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add New Film Form -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-outline-dark border-0 rounded-0" data-bs-toggle="collapse" href="#addFilmForm" role="button" aria-expanded="false" aria-controls="addFilmForm">
                        {{ __('Proposez nous un film !') }}
                    </a>
                </div>
                <div class="collapse" id="addFilmForm">
                    <div class="card-body">
                        <form method="POST" action="{{ route('films.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Titre') }}</label>
                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control" name="title" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Synopsis') }}</label>
                                <div class="col-md-6">
                                    <textarea id="description" class="form-control" name="description" required></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="tags" class="col-md-4 col-form-label text-md-end">{{ __('Tags') }}</label>
                                <div class="col-md-6">
                                    <div id="tags" class="row">
                                        @foreach($tags as $index => $tag)
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="tag{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}">
                                                    <label class="form-check-label" for="tag{{ $tag->id }}">{{ $tag->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="director" class="col-md-4 col-form-label text-md-end">{{ __('Réalisateur') }}</label>
                                <div class="col-md-6">
                                    <select id="director" class="form-control" name="director_id" required>
                                        @foreach($directors as $director)
                                            <option value="{{ $director->id }}">{{ $director->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="new-director" class="col-md-4 col-form-label text-md-end">{{ __('Ajouter un nouveau réalisateur ?')}}<br>{{ __('Coming soon')}}</label>
                                <div class="col-md-6">
                                    <input id="new-director" type="text" class="form-control" name="new_director">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="length" class="col-md-4 col-form-label text-md-end">{{ __('Durée (minutes)') }}</label>
                                <div class="col-md-6">
                                    <input id="length" type="text" class="form-control" name="length" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="year" class="col-md-4 col-form-label text-md-end">{{ __('Année de sortie') }}</label>
                                <div class="col-md-6">
                                    <input id="year" type="text" class="form-control" name="year" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="thumbnail" class="col-md-4 col-form-label text-md-end">{{ __('Affiche promotionnelle') }}</label>
                                <div class="col-md-6">
                                    <input id="thumbnail" type="file" class="form-control" name="thumbnail" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="video_url" class="col-md-4 col-form-label text-md-end">{{ __('Film video (mp4, webm...)') }}</label>
                                <div class="col-md-6">
                                    <input id="video_url" type="file" class="form-control" name="video_url" required>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn-outline-dark border-0 rounded-0 auto-hover">
                                        {{ __('Proposer un film') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Form -->
</div>
@endsection
