@extends('layouts.app')

@section('content')
<div class="container">
    <div class="wrapper">
        <div class="row">
            <div class="col-md-8">
                <video controls class="video-player">
                    <source src="{{ asset($film->video_url) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="d-flex align-items-center mt-3">
                    <button id="favoriteButton" class="btn btn-primary" style="margin-right: 20px;">Ajouter à ma librairie</button>
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

                <!-- Comment Section -->
                <div class="mt-5">
                    <h4 style="color: #fffbe8;">Commentaires</h4>
                    @guest
                        <p style="color: #c58686; font-weight: bold;">Connectez vous ou confirmez votre email pour accéder aux commentaires.</p>
                    @else
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="media_id" value="{{ $film->id }}">
                            <div class="form-group">
                                <textarea name="content" class="form-control" rows="3" placeholder="Ajoutez un commentaire..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Commenter</button>
                        </form>
                        @if($film->comments->isNotEmpty())
                            @foreach($film->comments as $comment)
                                @include('partials.comment', ['comment' => $comment])
                            @endforeach
                        @else
                            <p style="color: #fffbe8;">Aucun commentaire pour l'instant.</p>
                        @endif
                    @endguest
                </div>
            </div>
            <div class="col-md-4">
                @if (Auth::check() && Auth::user()->role == 'admin')
                <form id="deleteFilmForm" action="{{ route('film.destroy', $film->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce film ?')">Supprimer le film</button>
                </form>
                @endif
                <h2 class="film-title">{{ $film->title }}</h2>
                <img src="{{ asset($film->thumbnail) }}" alt="{{ $film->title }}" class="film-thumbnail">
                <p class="film-description">{{ $film->description }}</p>
                <p class="film-info"><strong>Durée:</strong> {{ $film->length }}</p>
                <p class="film-info"><strong>Année:</strong> {{ $film->year }}</p>
                <p class="film-info"><strong>Réalisateur:</strong> {{ $film->director->name }}</p>
            </div>
        </div>
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

    function toggleReplySection(commentId) {
        var replySection = document.getElementById('reply-section-' + commentId);
        var replyButton = document.getElementById('reply-button-' + commentId);

        if (replySection.style.display === 'none') {
            replySection.style.display = 'block';
            replyButton.textContent = 'Envoyer la réponse';
        } else {
            var form = replySection.querySelector('form');
            form.submit();
        }
    }

    document.addEventListener('click', function(event) {
        var isClickInsideReplyButton = event.target.closest('.btn.btn-secondary');
        var isClickInsideReplySection = event.target.closest('.reply-section');
        if (!isClickInsideReplyButton && !isClickInsideReplySection) {
            document.querySelectorAll('.reply-section').forEach(function(section) {
                section.style.display = 'none';
            });
            document.querySelectorAll('.btn-secondary').forEach(function(button) {
                button.textContent = 'Répondre';
            });
        }
    });
</script>


<style>
    .rating-section {
        display: flex;
        align-items: center;
        font-size: 1.2rem;
        color: #fffbe8;
        margin-top: 15px;
        margin-bottom: 20px; /* Added margin-bottom for spacing */
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
        font-size: 1.2rem;
        color: #fff7d1;
    }

    .rating-label {
        color: #fffbe8;
        font-size: 1.2rem;
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

    .card {
        background-color: transparent;
        border: none;
        color: #fffbe8;
    }

    .btn-secondary, .btn-primary {
        color: #fffbe8;
        background-color: transparent;
        border: 1px solid #fffbe8;
        padding: 5px 10px;
        font-size: 1rem;
    }

    .btn-secondary:hover, .btn-primary:hover {
        background-color: #fffbe8;
        color: #333;
    }

    textarea.form-control {
        background-color: transparent;
        color: #fffbe8;
        border: 1px solid #fffbe8;
    }

    textarea.form-control::placeholder {
        color: #fffbe8;
    }

    /* New styles for comment section */
    h4 {
        color: #fff;
        font-weight: bold;
    }

    .card-body {
        font-size: 1.2rem;
    }

    .reply-button-container {
        margin-top: 10px; /* Added margin-top for spacing */
    }

    .text-danger.font-weight-bold {
        color: red;
        font-weight: bold;
    }

    .d-flex.justify-content-between > div:last-child {
        margin-left: auto;
    }

</style>
@endsection
