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

                    {{ __('Bonjour') }} {{ Auth::user()->name }}{{ __(', bienvenue dans votre espace.') }}
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
                    <a class="btn btn-outline-dark border-0 rounded-0" data-toggle="collapse" href="#addFilmForm" role="button" aria-expanded="false" aria-controls="addFilmForm">
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
                                <label for="length" class="col-md-4 col-form-label text-md-end">{{ __('Durée (HHhMM)') }}</label>
                                <div class="col-md-6">
                                    <input id="length" type="text" class="form-control" name="length" required pattern="\d{2}h\d{2}" placeholder="HHhMM">
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
                    <a class="btn btn-outline-dark border-0 rounded-0" data-toggle="collapse" href="#roleRequests" role="button" aria-expanded="false" aria-controls="roleRequests">
                        {{ __('Demandes de changement de rôle') }}
                    </a>
                </div>
                <div class="collapse" id="roleRequests">
                    <div class="card-body">
                        @foreach($roleRequests as $request)
                            <div class="mb-3">
                                <p><strong>{{ $request->user->name }}</strong> demande le rôle : <strong>{{ $request->role }}</strong></p>
                                <p>Raison : {{ $request->reason }}</p>
                                <form method="POST" action="{{ route('role.approve', $request->id) }}">
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

            <div class="card mt-4">
                <div class="card-header">
                    <a class="btn btn-outline-dark border-0 rounded-0" data-toggle="collapse" href="#filmRequests" role="button" aria-expanded="false" aria-controls="filmRequests">
                        {{ __('Demandes d\'ajout de films') }}
                    </a>
                </div>
                <div class="collapse" id="filmRequests">
                    <div class="card-body">
                        @foreach($filmSubmissions as $submission)
                            <div class="mb-3">
                                <h4><strong>{{ $submission->title }}</strong> par <strong>{{ $submission->user->name }}</strong></h4>
                                <p><strong>Description :</strong> {{ $submission->description }}</p>
                                <p><strong>Tags :</strong>
                                    @if ($submission->tags)
                                        @foreach ($submission->tags as $tag)
                                            {{ $tag->name }}@if (!$loop->last), @endif
                                        @endforeach
                                    @else
                                        {{ __('No tags available') }}
                                    @endif
                                </p>
                                <p><strong>Réalisateur :</strong> {{ $submission->new_director ? $submission->new_director : $submission->director->name }}</p>
                                <p><strong>Durée :</strong> {{ $submission->length }}</p>
                                <p><strong>Année de sortie :</strong> {{ $submission->year }}</p>
                                <p><strong>Affiche :</strong><br> <img src="{{ asset($submission->thumbnail) }}" alt="{{ $submission->title }}" style="max-width: 100px;"></p>
                                <p><strong>Vidéo :</strong> <a href="{{ asset($submission->video_url) }}" target="_blank">{{ __('Voir la vidéo') }}</a></p>
                                
                                <form method="POST" action="{{ route('films.approve', $submission->id) }}" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="status" value="approved" class="btn btn-success">Approuver</button>
                                    <button type="submit" name="status" value="rejected" class="btn btn-danger">Rejeter</button>
                                </form>
                                
                                <button class="btn btn-outline-dark border-0 rounded-0 auto-hover d-inline" onclick="toggleEditForm({{ $submission->id }})">Modifier</button>
                                
                                <div id="editForm{{ $submission->id }}" style="display: none;">
                                    <form method="POST" action="{{ route('films.update', $submission->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="row mb-3">
                                            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Titre') }}</label>
                                            <div class="col-md-6">
                                                <input id="title" type="text" class="form-control" name="title" value="{{ $submission->title }}" required>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Synopsis') }}</label>
                                            <div class="col-md-6">
                                                <textarea id="description" class="form-control" name="description" required>{{ $submission->description }}</textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label for="tags" class="col-md-4 col-form-label text-md-end">{{ __('Tags') }}</label>
                                            <div class="col-md-6">
                                                <div id="tags" class="row">
                                                    @foreach($tags as $index => $tag)
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="tag{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}" {{ $submission->tags->contains($tag->id) ? 'checked' : '' }}>
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
                                                <select id="director" class="form-control" name="director_id">
                                                    <option value="">{{ __('Sélectionner un réalisateur') }}</option>
                                                    @foreach($directors as $director)
                                                        <option value="{{ $director->id }}" {{ $submission->director_id == $director->id ? 'selected' : '' }}>{{ $director->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label for="new-director" class="col-md-4 col-form-label text-md-end">{{ __('Ajouter un nouveau réalisateur ?')}}<br>{{ __('Coming soon')}}</label>
                                            <div class="col-md-6">
                                                <input id="new-director" type="text" class="form-control" name="new_director" value="{{ $submission->new_director }}">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label for="length" class="col-md-4 col-form-label text-md-end">{{ __('Durée (HHhMM)') }}</label>
                                            <div class="col-md-6">
                                                <input id="length" type="text" class="form-control" name="length" value="{{ $submission->length }}" required pattern="\d{2}h\d{2}" placeholder="HHhMM">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label for="year" class="col-md-4 col-form-label text-md-end">{{ __('Année de sortie') }}</label>
                                            <div class="col-md-6">
                                                <input id="year" type="number" class="form-control" name="year" value="{{ $submission->year }}" required min="1800" max="{{ date('Y') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label for="thumbnail" class="col-md-4 col-form-label text-md-end">{{ __('Affiche promotionnelle') }}</label>
                                            <div class="col-md-6">
                                                <input id="thumbnail" type="file" class="form-control" name="thumbnail">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label for="video_url" class="col-md-4 col-form-label text-md-end">{{ __('Film video (mp4, webm...)') }}</label>
                                            <div class="col-md-6">
                                                <input id="video_url" type="file" class="form-control" name="video_url">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Mettre à jour') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
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

    function toggleEditForm(submissionId) {
        var editForm = document.getElementById('editForm' + submissionId);
        if (editForm.style.display === 'none') {
            editForm.style.display = 'block';
        } else {
            editForm.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var collapses = document.querySelectorAll('.collapse');
        collapses.forEach(function(collapse) {
            collapse.addEventListener('show.bs.collapse', function() {
                collapses.forEach(function(otherCollapse) {
                    if (otherCollapse !== collapse) {
                        var bsCollapse = bootstrap.Collapse.getInstance(otherCollapse);
                        if (bsCollapse) {
                            bsCollapse.hide();
                        }
                    }
                });
            });
        });

        // Re-collapse functionality
        document.querySelectorAll('[data-toggle="collapse"]').forEach(function(button) {
            button.addEventListener('click', function(event) {
                var target = document.querySelector(button.getAttribute('href'));
                if (target.classList.contains('show')) {
                    var bsCollapse = bootstrap.Collapse.getInstance(target);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                } else {
                    var bsCollapse = new bootstrap.Collapse(target);
                    bsCollapse.show();
                }
            });
        });
    });
</script>
@endsection
