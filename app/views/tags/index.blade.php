@extends('layout')

@section('title')
Тэги
@stop

@section('content')
<div class="jumbotron">
    <div class="container">
        <h2>Тэги</h2>
    </div>
</div>

<div class="container">
    <p>&nbsp;</p>
    <p class="tag-list">
    @foreach($tags as $tag)
        {{ $tag->tag }}
    @endforeach
    </p>
    <p>&nbsp;</p>
</div>
@stop
