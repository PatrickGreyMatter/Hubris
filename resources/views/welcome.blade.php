<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hubris-streaming</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="preload" href="/presentations/website_layout/default_background1.jpg" as="image">
    <!-- Favicon for standard browsers -->
    <link rel="icon" href="/presentations/website_layout/favicons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/presentations/website_layout/favicons/favicon.ico" type="image/x-icon">
    <!-- Favicon for specific devices and situations -->
    <link rel="apple-touch-icon" sizes="180x180" href="/presentations/website_layout/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/presentations/website_layout/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/presentations/website_layout/favicons/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/presentations/website_layout/favicons/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/presentations/website_layout/favicons/android-chrome-512x512.png">
    <!-- Web app manifest -->
    <link rel="manifest" href="/presentations/website_layout/favicons/site.webmanifest">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #0a0b5b56; /* Adjust this color to match your image's tone */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            transition: background 0.3s ease-in-out; /* Smooth transition for the background */
        }
        body.loaded {
            background-image: url('/presentations/website_layout/default_background1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .fixed-top {
            background-color: #343a40; /* Dark background color */
            padding: 0.5rem 1rem;
        }
        .fixed-top a {
            color: #ffffff; /* White text color */
        }
        .fixed-top a:hover {
            color: #cccccc; /* Light gray on hover */
        }
        .info {
            text-align: center;
            color: white;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px;
        }

        @media only screen and (max-width: 600px) {
            .arrow__btn {
                display: none;
            }
        }
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
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Fixed Header -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="/">Hubris
                <img src="{{ asset('/presentations/website_layout/logohubris.png') }}" alt="Your Company Logo" width="30" height="30">  
            </a>
            <form class="form-inline my-2 my-lg-0" action="{{ route('search') }}" method="GET">
                <div class="input-group">
                    <input class="form-control mr-sm-2" type="search" name="query" placeholder="Rechercher un film..." aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Rechercher</button>
                    </div>
                </div>
            </form>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/profil') }}">Profil</a>
                            </li>
                            <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                             {{ __('Déconnexion') }}
                         </a>
                         <!-- Logout form -->
                         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                             @csrf
                         </form>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">S'inscrire</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

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
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Votre note a été mise à jour.');
            document.getElementById('averageRating').textContent = data.average_rating;
        } else {
            alert('Une erreur s\'est produite.');
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
<!-- Existing Footer Code -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-bottom">
        <div class="container">
            <footer class="footer text-center p-0 fixed-bottom">
                <div class="container">
                    <a class="navbar-brand" href="/">
                        <img src="{{ asset('/presentations/website_layout/logohubris.png') }}" alt="Your Company Logo" width="30" height="30">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a href="#" data-toggle="modal" data-target="#conditionsModal" class="nav-link">Conditions Générales d'Utilisation</a>
                    <a href="#" data-toggle="modal" data-target="#infosModal" class="nav-link">A propos de nous</a>
                    <a href="https://patrickgreymatter.github.io/#contact" class="nav-link" target="_blank" rel="noopener noreferrer">Contacter le créateur</a>
                </div>
            </footer>
        </div>
    </nav>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var img = new Image();
                img.src = "/presentations/website_layout/default_background1.jpg";
                img.onload = function() {
                    document.body.classList.add('loaded');
                }
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var successAlert = document.querySelector('.alert-primary');
                if (successAlert) {
                    setTimeout(function() {
                        successAlert.style.display = 'none';
                    }, 5000); // 5000 milliseconds = 5 seconds
                }
            });
        </script>
</body>
</html>

<style>
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
