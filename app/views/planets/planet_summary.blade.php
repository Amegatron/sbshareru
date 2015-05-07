<div class="col-md-4 planet-summary">
    <h3>{{ $planet->planet }}</h3>
    <p>
        {{ $planet->created_at }}<br />
        OS: {{ Planet::$oses[$planet->os] }}, Уровень: {{ $planet->level }}<br />
        Координаты: X {{ $planet->x }}, Y {{ $planet->y }}
    </p>
    <p>{{ $planet->comment }}</p>

    @if (count($planet->tags))
    <p>
        Тэги:
        @foreach($planet->tags as $tag)
            {{ $tag->tag }}
        @endforeach
    </p>
    @endif
    <p>Добавил:
        <b>
            {{ $planet->author }}
        </b><br />
        Просмотров: {{ $planet->views }}<br />
        @if ($planet->comments_count > 0)
        Комментариев: {{ $planet->comments_count }}
        @endif
    </p>
    <p><a class="btn btn-default" href="/planets/view/{{ $planet->id }}" role="button">Детали планеты &raquo;</a></p>
</div>
