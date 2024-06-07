<!-- resources/views/partials/filmCard.blade.php -->
<div class="col-md-3 mb-3">
    <div class="card h-100 d-flex flex-column">
        <a href="{{ route('film.show', ['slug' => $film->slug]) }}" class="d-block text-decoration-none text-dark">
            <img class="img-fluid" src="{{ asset($film->thumbnail) }}" alt="{{ $film->title }}" style="width: 100%; height: 300px; object-fit: cover;">
        </a>
        <div class="card-body d-flex flex-column flex-grow-1">
            <a href="{{ route('film.show', ['slug' => $film->slug]) }}" class="text-decoration-none text-dark flex-grow-1">
                <h5 class="card-title">{{ $film->title }}</h5>
                <p class="card-text">Durée: {{ $film->length }}</p>
                <p class="card-text">De {{ $film->director->name }}</p>
            </a>
            <p class="card-text"> 
                @foreach ($film->tags as $tag)
                    <a href="{{ route('films.tag', ['tag' => $tag->name]) }}" class="badge badge-primary">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </p>
            @if (isset($isLibrary) && $isLibrary)
                <form action="{{ route('library.remove', $film->id) }}" method="POST" class="mt-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">Supprimer</button>
                </form>
            @endif
        </div>
    </div>
</div>
