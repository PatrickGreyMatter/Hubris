@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Mon espace') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success outline-black" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Bonjour') }} {{ Auth::user()->name }}{{ __(', bienvenu dans votre espace.') }}
                </div>
            </div>
        </div>
    </div>

    @if (Auth::user()->role == 'user' || Auth::user()->role == 'contributor')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Demande de promotion de rôle') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('role.request') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Rôle demandé') }}</label>
                            <div class="col-md-6">
                                <select id="role" class="form-control" name="role" required>
                                    <option value="contributor">{{ __('Contributeur') }}</option>
                                    <option value="admin">{{ __('Admin') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="reason" class="col-md-4 col-form-label text-md-end">{{ __('Raison de la demande') }}</label>
                            <div class="col-md-6">
                                <textarea id="reason" class="form-control" name="reason" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Envoyer la demande') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Auth::user()->role == 'contributor' || Auth::user()->role == 'admin')
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
                        <form method="POST" action="{{ route('films.store') }}" enctype="multipart/form-data" id="filmForm">
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
                                    <textarea id="description" class="form-control" name="description" required maxlength="1000"></textarea>
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
                                    <input id="new-director" type="text" class="form-control" name="new_director" oninput="toggleDirectorSelect()">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="length" class="col-md-4 col-form-label text-md-end">{{ __('Durée (HH:MM)') }}</label>
                                <div class="col-md-6">
                                    <input id="length" type="text" class="form-control" name="length" required pattern="\d{2}:\d{2}" placeholder="HH:MM">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="year" class="col-md-4 col-form-label text-md-end">{{ __('Année de sortie') }}</label>
                                <div class="col-md-6">
                                    <input id="year" type="number" class="form-control" name="year" required min="1800" max="{{ date('Y') }}">
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
    @endif

    @if (Auth::user()->role == 'admin')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Gérer les demandes de rôles et de films') }}
                </div>
                <div class="card-body">
                    <h4>Demandes de changement de rôle</h4>
                    <!-- Liste des demandes de rôle -->
                    @foreach($roleRequests as $request)
                        <div class="mb-3">
                            <p><strong>{{ $request->user->name }}</strong> demande de devenir <strong>{{ $request->role }}</strong></p>
                            <p>Raison : {{ $request->reason }}</p>
                            <form method="POST" action="{{ route('role.approve', $request->id) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="status" value="approved" class="btn btn-success">Approuver</button>
                                <button type="submit" name="status" value="rejected" class="btn btn-danger">Rejeter</button>
                            </form>
                        </div>
                    @endforeach

                    <h4>Demandes d'ajout de films</h4>
                    <!-- Liste des propositions de films -->
                    @foreach($filmSubmissions as $submission)
                        <div class="mb-3">
                            <p><strong>{{ $submission->title }}</strong> par <strong>{{ $submission->user->name }}</strong></p>
                            <p>Description : {{ $submission->description }}</p>
                            <form method="POST" action="{{ route('films.approve', $submission->id) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="status" value="approved" class="btn btn-success">Approuver</button>
                                <button type="submit" name="status" value="rejected" class="btn btn-danger">Rejeter</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    function toggleDirectorSelect() {
        var newDirectorInput = document.getElementById('new-director');
        var directorSelect = document.getElementById('director');
        directorSelect.disabled = newDirectorInput.value.length > 0;
    }
</script>
@endsection
