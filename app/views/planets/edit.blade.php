@extends('layout')

@section('title')
Редактирование планеты {{ $planet->planet }}
@stop

@section('content')
<div class="jumbotron">
    <div class="container">

    <h2>Редактирование планеты {{ $planet->planet }}</h2>

    @if($errors->all())
        @foreach($errors->all() as $error)
            <p class="error">{{ $error }}</p>
        @endforeach
    @endif
    {{ Form::model($planet, array('url' => 'planets/edit/' . $planet->id, 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
        @include('planets/form')

        <div class="form-group">
            <label for="tags" class="col-sm-2 control-label">Тэги</label>
            <div class="col-sm-5">
                <small>Используйте клавишу TAB для добавления тэга<br /></small>
                <ul id="planet-tags">
                    @foreach($planet->tags as $tag)
                        <li>{{ $tag->tag }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2">&nbsp;</div>
            <div class="col-sm-5">
                <button type="submit" class="btn btn-primary" id="submit-button" data-submit-message="Сохранение ...">Сохранить</button>
                <a href="#" class="btn btn-primary preview-button" data-source-input="comment">Предварительный просмотр</a>
            </div>
        </div>
    {{ Form::close() }}

@stop
