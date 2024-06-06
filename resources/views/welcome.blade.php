@extends('layouts.app')

@section('content')
<!-- Main Content -->
<div class="container mt-5" style="margin-top: 60px; margin-bottom: 60px;">
    <main class="mt-6">
        <div class="wrapper">

            @if(session('success'))
            <div class="alert alert-primary">
                {{ session('success') }}
            </div>
        @endif

            @if(isset($query))
                <h3 class="search-result-heading" style="margin-top: 60px;">Résultats de recherche pour "{{ $query }}"</h3>
                <div class="row">
                    @foreach ($films as $film)
                        <div class="col-md-3 mb-4">
                            <a href="{{ route('film.show', ['slug' => $film->slug]) }}" class="d-block text-decoration-none text-dark">
                                <div class="card h-100">
                                    <img class="img-fluid" src="{{ $film->thumbnail }}" alt="{{ $film->title }}" style="width: 100%; height: 300px; object-fit: cover;">
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

            @elseif(isset($film))
            <div class="row">
                <div class="col-md-8">
                    <video controls class="video-player">
                        <source src="{{ asset($film->video_url) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="d-flex align-items-center mt-3">
                        <button id="favoriteButton" class="btn btn-primary" style="margin-right: 20px;">Ajouter a ma librairie</button>
                        <div class="rating-section">
                            <span class="rating-label">Votre note:</span>
                            <div class="rating-checkboxes">
                                <label>
                                    <input type="checkbox" name="rating" value="1" onclick="updateRating(1)"> <span>1</span>
                                </label>
                                <label>
                                    <input type="checkbox" name="rating" value="2" onclick="updateRating(2)"> <span>2</span>
                                </label>
                                <label>
                                    <input type="checkbox" name="rating" value="3" onclick="updateRating(3)"> <span>3</span>
                                </label>
                                <label>
                                    <input type="checkbox" name="rating" value="4" onclick="updateRating(4)"> <span>4</span>
                                </label>
                                <label>
                                    <input type="checkbox" name="rating" value="5" onclick="updateRating(5)"> <span>5</span>
                                </label>
                            </div>
                            <div class="average-rating">
                                Note: <span id="averageRating">{{ $film->average_rating ?? 'N/A' }}</span>/5
                            </div>
                        </div>                            
                    </div>
                </div>
                <div class="col-md-4">
                    <h2 class="film-title">{{ $film->title }}</h2>
                    <img src="{{ asset($film->thumbnail) }}" alt="{{ $film->title }}" class="film-thumbnail">
                    <p class="film-description">{{ $film->description }}</p>
                    <p class="film-info"><strong>Durée:</strong> {{ $film->length }}</p>
                    <p class="film-info"><strong>Année:</strong> {{ $film->year }}</p>
                    <p class="film-info"><strong>Réalisateur:</strong> {{ $film->director->name }}</p>
                </div>
            </div>
            
            
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var favoriteButton = document.getElementById('favoriteButton');
                    if (favoriteButton) {
                        favoriteButton.addEventListener('click', function() {
                            window.location.href = '{{ route('favorites', ['media_id' => $film->id]) }}';
                        });
                    }
                });
                function updateRating(rating) {
    // Uncheck all checkboxes
    document.querySelectorAll('.rating-checkboxes input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.checked = false;
    });

    // Check the clicked checkbox
    document.querySelector('.rating-checkboxes input[value="' + rating + '"]').checked = true;

    // Send the rating to the backend
    fetch('{{ route('rate.film') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            media_id: '{{ $film->id }}',
            rating: rating
        })
    })
    .then(response => {
        if (response.status === 401 || response.redirected) {
            // Redirect to the login page if the user is not authenticated
            window.location.href = '{{ route('login') }}';
        } else {
            return response.json();
        }
    })
    .then(data => {
        if (data && data.success) {
            alert('Votre note a été mise à jour.');
            document.getElementById('averageRating').textContent = data.average_rating;
        } else {
            alert('Connectez vous pour mettre une note.');
        }
    })
    .catch(error => console.error('Error:', error));
}


                </script>
                

            @else
                @include('partials._carousel', ['carouselId' => 8, 'carouselTitle' => 'Derniers ajouts', 'films' => $latestFilms])
                @include('partials._carousel', ['carouselId' => 1, 'carouselTitle' => 'Films americains', 'films' => $americanfilms])
                @include('partials._carousel', ['carouselId' => 2, 'carouselTitle' => 'Films Français', 'films' => $frenchFilms])
                @include('partials._carousel', ['carouselId' => 3, 'carouselTitle' => "Films d'horreur", 'films' => $horrorFilms])
                @include('partials._carousel', ['carouselId' => 4, 'carouselTitle' => 'Drames', 'films' => $dramaFilms])
                @include('partials._carousel', ['carouselId' => 5, 'carouselTitle' => 'Comedies', 'films' => $comedyFilms])
                @include('partials._carousel', ['carouselId' => 6, 'carouselTitle' => 'Films de science fiction', 'films' => $sfFilms])
                @include('partials._carousel', ['carouselId' => 7, 'carouselTitle' => 'Thrillers', 'films' => $thrillerFilms])
            @endif
        </div>
    </main>
</div>

    <!-- Modals -->
<!-- Conditions Modal -->
<div class="modal fade" id="conditionsModal" tabindex="-1" role="dialog" aria-labelledby="conditionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="conditionsModalLabel">Conditions Générales d'Utilisation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('conditions')
            </div>
        </div>
    </div>
</div>

<!-- Infos Modal -->
<div class="modal fade" id="infosModal" tabindex="-1" role="dialog" aria-labelledby="infosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infosModalLabel">A propos de nous</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('infos')
            </div>
        </div>
    </div>
</div>

<style>

.rating-section {
    display: flex;
    align-items: center;
    margin-top: 15px;
}
.rating-checkboxes {
    display: flex;
    margin-left: 10px;
}
.rating-checkboxes label {
    margin-right: 10px;
}
.average-rating {
    margin-left: 20px;
    color: #fff7d1;
}

.card-title {
    font-size: 1.1rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.card-text {
    font-size: 0.9rem;
}
.badge-primary {
    background-color: #3d1987;
    font-size: 0.8rem;
    margin-right: 2px;
}
.card {
    background-color: #fffbe8; /* Changez cette valeur pour la couleur de fond souhaitée */
  }
  .search-result-heading {
    color: white;
  }
  .video-player {
      width: 100%;
      max-width: 800px;
      margin-bottom: 20px;
      margin-top: 100px;
  }
  .film-title {
      color: #fffbe8;
      font-size: 2rem;
      margin-bottom: 50px;
      margin-top: 50px;
  }
  .film-thumbnail {
      width: 100%;
      height: auto;
      margin-bottom: 20px;
  }
  .film-description, .film-info {
      color: #fff7d1;
      font-size: 1.1rem;
      margin-bottom: 10px;
  }
  .alert-primary {
      margin-top: 20px;
  }

  .custom-modal-content {
    background-color: #fffbe8 !important;
}

.rating-section {
    display: flex;
    align-items: center;
    font-size: 1.2rem;
    color: #fffbe8;
}

.rating-checkboxes {
    display: flex;
    align-items: center;
    margin-left: 10px;
}

.rating-checkboxes label {
    margin-right: 10px;
    font-size: 1.2rem;
    color: #fffbe8;
    display: flex;
    align-items: center;
}

.rating-checkboxes input[type="checkbox"] {
    width: 20px;
    height: 20px;
    margin-right: 5px;
    vertical-align: middle;
    position: relative;
    top: 6px;
}

.rating-checkboxes span {
    position: relative;
    top: 4px;
}

.average-rating {
    margin-left: 20px;
    color: #fffbe8;
    font-size: 1.2rem;
}

.rating-label {
    color: #fffbe8;
    font-size: 1.2rem;
}

</style>