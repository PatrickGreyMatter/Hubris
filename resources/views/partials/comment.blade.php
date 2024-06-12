<div class="card mb-3" style="background-color: transparent; border: none; color: #fffbe8;">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div>
                @php
                    $user = Auth::user();
                    $commentUser = $comment->user;
                    $name = $user && $user->id == $commentUser->id ? 'Vous' : $commentUser->name;
                    $profileRoute = $user && $user->id == $commentUser->id ? route('profil') : route('watch-profil', $commentUser->id);
                @endphp
                <strong><a href="{{ $profileRoute }}" style="color: #fffbe8;">{{ $name }}</a> :</strong>
                <div id="edit-comment-{{ $comment->id }}" style="display: none;">
                    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <textarea name="content" class="form-control" rows="3">{{ $comment->content }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>
                </div>
                <div id="comment-content-{{ $comment->id }}">{{ $comment->content }}</div>
            </div>
            @if(Auth::check() && (Auth::user()->id == $comment->user_id || Auth::user()->role == 'admin'))
            <div>
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary text-danger font-weight-bold">Supprimer</button>
                </form>
            </div>
            @endif
        </div>

        @auth
        <div class="reply-section mt-2" id="reply-section-{{ $comment->id }}" style="display: none;">
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="media_id" value="{{ $film->id }}">
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <div class="form-group">
                    <textarea name="content" class="form-control" rows="2" placeholder="Ajouter une réponse..."></textarea>
                </div>
            </form>
        </div>
        <div class="reply-button-container">
            <button class="btn btn-secondary" id="reply-button-{{ $comment->id }}" onclick="toggleReplySection({{ $comment->id }})">Répondre</button>
        </div>
        @endauth

        @if($comment->children && $comment->children->isNotEmpty())
            <div class="ml-4">
                @foreach($comment->children as $childComment)
                    @include('partials.comment', ['comment' => $childComment])
                @endforeach
            </div>
        @endif
    </div>
</div>
