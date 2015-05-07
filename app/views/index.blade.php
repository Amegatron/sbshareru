@extends('layout')

@section('title')
Русская база координат Starbound
@stop

@section('content')
<div class="jumbotron">
    <div class="container">
        <h1>Русская база координат Starbound</h1>
        <p>
            Планет в базе: {{ $counter }}.
            <?php
                $lastUpdateStr = $lastUpdate->format('d.m.Y');
                $lastUpdateWithoutTime = new Carbon($lastUpdateStr);

                if (Carbon::today() == $lastUpdateWithoutTime) {
                    $lastUpdateStr = "сегодня";
                } elseif (Carbon::yesterday() == $lastUpdateWithoutTime) {
                    $lastUpdateStr = "вчера";
                }
            ?>
            Последнее обновление: {{ $lastUpdateStr }}.
        </p>
        <p>Полный список с поиском доступен в разделе <a href="/planets">Планеты</a>.</p>
        <p>Поиск по тэгам доступен в разделе <a href="/tags">Тэги</a>.</p>
        <p>Список новостей сайта <a href="#news">внизу страницы</a>.</p>
    </div>
</div>

<div class="container">
    <?php $counter = 0; ?>
    @foreach($planets as $planet)
        <?php $counter++ ?>
        @if ($counter % 3 == 0)
            <div class="row">
        @endif
        @include('planets/planet_summary')
        @if ($counter % 3 == 0)
            </div>
        @endif

    @endforeach
</div>

@if (count($comments))
<div class="jumbotron">
    <div class="container">
        <p>Последние комментарии</p>
        @foreach($comments as $comment)
            @include('index/comment')
        @endforeach
    </div>
</div>
@endif

<a name="news"></a>
@if (count($news))
<div class="container">
    <h2>Новости</h2>
    @foreach($news as $newsSingle)
    <div class="row news">
        <p>Дата: {{ $newsSingle->created_at }}, автор: <b>{{ $newsSingle->author }}</b></p>
        <p>{{ $newsSingle->news }}</p>
    </div>
    @endforeach
</div>
@endif
@stop
