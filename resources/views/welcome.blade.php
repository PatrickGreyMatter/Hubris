<!-- welcome.blade.php -->

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
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Fixed Header -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <div class="container">
                <a class="navbar-brand" href="/">Hubris
                    <img src="{{ asset('/presentations/website_layout/logohubris.png') }}" alt="Your Company Logo" width="30" height="30">  
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <form class="form-inline my-2 my-lg-0" action="{{ route('search') }}" method="GET">
                            <input class="form-control mr-sm-2" type="search" name="query" placeholder="Rechercher un film..." aria-label="Search">
                            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </li>
                </ul>
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
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

<!-- Main Content -->
<div class="container mt-5">
    <main class="mt-6">
        <div class="wrapper">
            @include('partials._carousel', ['carouselId' => 8, 'carouselTitle' => 'Derniers ajouts', 'films' => $latestFilms])
            @include('partials._carousel', ['carouselId' => 1, 'carouselTitle' => 'Films americains', 'films' => $americanfilms])
            @include('partials._carousel', ['carouselId' => 2, 'carouselTitle' => 'Films Français', 'films' => $frenchFilms])
            @include('partials._carousel', ['carouselId' => 3, 'carouselTitle' => "Films d'horreur", 'films' => $horrorFilms])
            @include('partials._carousel', ['carouselId' => 4, 'carouselTitle' => 'Drames', 'films' => $dramaFilms])
            @include('partials._carousel', ['carouselId' => 5, 'carouselTitle' => 'Comedies', 'films' => $comedyFilms])
            @include('partials._carousel', ['carouselId' => 6, 'carouselTitle' => 'Films de science fiction', 'films' => $sfFilms])
            @include('partials._carousel', ['carouselId' => 7, 'carouselTitle' => 'Thrillers', 'films' => $thrillerFilms])

        </div>
    </main>
</div>













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

    <nav class="navbar navbar-expand-lg navbar-dark fixed-bottom">
        <div class="container">
            <footer class="footer text-center p-2 fixed-bottom">
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

    <!-- Modal pour les Conditions Générales d'Utilisation -->
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
                    @include('conditions')  <!-- Inclure le contenu des CGU à partir d'une vue Blade séparée -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour les information d'a propos -->
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
                    @include('infos')  <!-- Inclure le contenu des CGU à partir d'une vue Blade séparée -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>
