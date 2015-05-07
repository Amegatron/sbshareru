@extends('admin/layout')

@section('title')
Новости
@stop

@section('inner_content')
    <h2>Новости</h2>

    @if (!count($news))
        <p class="bg-warning text-muted">Нет новостей</p>
    @else
        @foreach($news as $newsSingle)
            <div class="row news">
                <p>Дата: {{ $newsSingle->created_at }}, автор: <b>{{ $newsSingle->author }}</b></p>
                <p>{{ $newsSingle->news }}</p>
                {{ link_to_route('admin.news.edit', 'Редактировать', $newsSingle->id ) }}&nbsp;
                <a href="#" class="delete-news-link" data-news-id="{{ $newsSingle->id }}" onclick="return false;">Удалить</a>
            </div>
        @endforeach
    @endif
@stop
