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
        section {
            width: 100%;
            position: relative;
            display: grid;
            grid-template-columns: repeat(5, auto);
            margin: 20px 0;
        }
        .item {
            padding: 0 2px;
            transition: all 250ms;
        }
        .arrow__btn {
            position: absolute;
            color: #fff;
            text-decoration: none;
            font-size: 6em;
            background: rgb(0, 0, 0);
            width: 80px;
            padding: 20px;
            text-align: center;
            z-index: 1;
        }
        .arrow__btn:nth-of-type(1) {
            top: 0;
            bottom: 0;
            left: 0;
            background: linear-gradient(-90deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 1) 100%);
        }
        .arrow__btn:nth-of-type(2) {
            top: 0;
            bottom: 0;
            right: 0;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 1) 100%);
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
                    <img src="{{ asset('/presentations/website_layout/logohubris.png') }}" alt="Your Company Logo" width="30" height="30">  </a>
                </div>
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
                <!-- Loop through the films, chunked by 5 items per section to create multiple sections if needed -->
                @foreach($films->chunk(5) as $index => $chunk)
                <section id="section{{ $index + 1 }}">
                    <!-- Navigation arrows -->
                    <a href="#section{{ $index == 0 ? $films->chunk(5)->count() : $index }}" class="arrow__btn left-arrow">‹</a>
                    @foreach($chunk as $film)
                    <div class="item">
                        <!-- Link to the film's detailed page using the film's slug -->
                        <a href="{{ url('medias/' . $film->slug) }}">
                            <!-- Display the film's thumbnail -->
                            <img src="{{ $film->thumbnail }}" alt="{{ $film->title }}">
                            <!-- Film information -->
                            <div class="info">
                                <h3>{{ $film->title }}</h3>
                                <p>Durée {{ $film->length }} | {{ $film->year }}</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                    <!-- Navigation arrows -->
                    <a href="#section{{ $index == $films->chunk(5)->count() - 1 ? 1 : $index + 2 }}" class="arrow__btn right-arrow">›</a>
                </section>
                @endforeach
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
</body>
</html>
