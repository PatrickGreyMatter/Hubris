<!-- resources/views/partials/comment.blade.php -->
<div class="card mt-3">
    <div class="card-body">
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

        @auth
        <form action="{{ route('comments.store') }}" method="POST" class="reply-section mt-2">
            @csrf
            <input type="hidden" name="media_id" value="{{ $film->id }}">
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <div class="form-group">
                <textarea name="content" class="form-control" rows="2" placeholder="Répondre..."></textarea>
            </div>
            <button type="submit" class="btn btn-secondary btn-sm">Répondre</button>
        </form>
        @endauth

        @foreach($comment->replies as $childComment)
            @include('partials.comment', ['comment' => $childComment])
        @endforeach
    </div>
</div>
