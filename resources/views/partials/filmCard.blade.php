<div class="col-md-3 mb-3">
    <div class="card h-100">
        <a href="{{ route('film.show', ['slug' => $film->slug]) }}" class="d-block text-decoration-none text-dark">

            <img class="img-fluid" src="{{ asset($film->thumbnail) }}" alt="{{ $film->title }}" style="width: 100%; height: 300px; object-fit: cover;">
        </a>
        <div class="card-body">
            <a href="{{ route('film.show', ['slug' => $film->slug]) }}" class="text-decoration-none text-dark">

                <h5 class="card-title">{{ $film->title }}</h5>
                <p class="card-text">Durée: {{ $film->length }}</p>
                <p class="card-text">De {{ $film->director->name }}</p>
            </a>
            <p class="card-text inline">
                Tags: 
                @foreach ($film->tags as $tag)
                <a href="{{ route('films.tag', ['tag' => $tag->name]) }}" class="badge badge-primary">
                    {{ $tag->name }}
                </a>
                @endforeach
            </p>
        </div>
    </div>
</div>