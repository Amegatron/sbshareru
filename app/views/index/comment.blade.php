<div class="comment bg-info">
    <p>Автор: <b>{{ $comment->author }}</b>,
        планета <a href="/planets/view/{{ $comment->planet->id }}">{{ $comment->planet->planet }}</a>, {{ $comment->created_at }}</p>
    <p>{{ $comment->comment }}</p>
</div>
