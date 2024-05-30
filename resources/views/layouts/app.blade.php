<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Preload the background image -->
    <link rel="preload" href="/presentations/website_layout/default_background1.jpg" as="image">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hubris-streaming') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
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
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm background=#FF2D20">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Hubris-streaming') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <!-- Add your left side navbar items here -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __("Se connecter") }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __("S'inscrire") }}</a>
                                </li>
                            @endif
                        @else
                            <li class="outline-black">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                            </li>
                            
                            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @if(Route::is('login') || Route::is('register'))
        <div class="wrapper">
          <!-- Loop through the films, chunked by 5 items per section to create multiple sections if needed -->
          @foreach($films->chunk(5) as $index => $chunk)
          <section id="section{{ $index + 1 }}">
              <!-- Navigation arrows -->
              <a href="#section{{ $index == 0 ? $films->chunk(5)->count() : $index }}" class="arrow__btn">‹</a>
              @foreach($chunk as $film)
              <div class="item">
                  <!-- Link to the film's detailed page using the film's slug -->
                  <a href="{{ url('medias/' . $film->slug) }}">
                      <!-- Display the film's thumbnail -->
                      <img src="{{ $film->thumbnail }}" alt="{{ $film->title }}">
                      <!-- Film information -->
                      <div class="info">
                          <h3>{{ $film->title }}</h3>
                          <p>{{ $film->length }} mins | {{ $film->year }}</p>
                      </div>
                  </a>
              </div>
              @endforeach
              <!-- Navigation arrows -->
              <a href="#section{{ $index == $films->chunk(5)->count() - 1 ? 1 : $index + 2 }}" class="arrow__btn">›</a>
          </section>
          @endforeach
      </div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJX5BSx0PL7lpE6q2JjVXpQGH6MP6PP0lA1RQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl8A24j8B0RO8k0G4jUjFcAFokQopk95pLtb5nIQdVCAeXu4lCO3kIFwBQT" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyl2ik8v+0eReMJg5aOsZtC2FW2x5j5v5MMJsmXR0MEhLG7xvl13lN4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>

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
