<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Preload the background image -->
    <link rel="preload" href="/presentations/website_layout/default_background1.jpg" as="image">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Favicon for standard browsers -->
    <link rel="icon" href="/presentations//website_layout/favicons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/presentations/website_layout/favicons/favicon.ico" type="image/x-icon">
    <!-- Favicon for specific devices and situations -->
    <link rel="apple-touch-icon" sizes="180x180" href="/presentations//website_layout/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/presentations/website_layout/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/presentations/website_layout/favicons/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/presentations/website_layout/favicons/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/presentations/website_layout/favicons/android-chrome-512x512.png">
    <!-- Web app manifest -->
    <link rel="manifest" href="/presentations/website_layout/favicons/site.webmanifest">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hubris-streaming') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .alert-primary {
            margin-top: 20px;
        }

        .custom-modal-content {
            background-color: #fffbe8 !important;
        }
        .badge-primary {
            background-color: #3d1987;
            font-size: 0.8rem;
            margin-right: 2px;
        }
        .card {
            background-color: #fffbe8; /* Changez cette valeur pour la couleur de fond souhaitée */
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

        body {
            background: #0a0b5b56; /* Use a light grey color or similar to your image */
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
        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #343a40; /* Dark background color */
            padding: 0.5rem 1rem;
        }
        header a {
            color: #ffffff; /* White text color */
        }
        header a:hover {
            color: #cccccc; /* Light gray on hover */
        }
        .info {
            text-align: center;
            color: white;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px;
        }

        main {
            flex: 1;
        }

        footer {
            background-color: #41566b;
            color: white;
            padding: 0.09rem 0;
        }

        footer a {
            color: white;
        }

        footer a:hover {
            color: lightgray;
        }

        @media only screen and (max-width: 600px) {
            .arrow__btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <header class="sticky-top">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container d-flex justify-content-between align-items-center">
                    <a class="navbar-brand" href="/">Hubris
                        <img src="{{ asset('/presentations/website_layout/logohubris.png') }}" alt="Your Company Logo" width="30" height="30">  
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <form class="form-inline my-2 my-lg-0" action="{{ route('search') }}" method="GET">
                                    <div class="input-group">
                                        <input class="h-auto form-control mr-2" type="search" name="query" placeholder="Rechercher un film..." aria-label="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-light" type="submit">Rechercher</button>
                                        </div>
                                    </div>
                                </form>
                            </li>
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
        </header>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="mt-auto">
            <nav class="footer navbar navbar-expand-lg navbar-dark bg-dark ">
                <div class="container-fluid">
                
                        <a class="navbar-brand" href="/">
                            <img src="{{ asset('/presentations/website_layout/logohubris.png') }}" alt="Your Company Logo" width="30" height="30">
                        </a>
                    <!--    
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="#" data-toggle="modal" data-target="#conditionsModal" class="nav-link">Conditions Générales d'Utilisation</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="modal" data-target="#infosModal" class="nav-link">A propos de nous</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://patrickgreymatter.github.io/#contact" class="nav-link" target="_blank" rel="noopener noreferrer">Contacter le créateur</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </footer>
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
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
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
        $(document).ready(function() {
            $('.selectpicker').selectpicker();
        });
    </script>
</body>
</html>
