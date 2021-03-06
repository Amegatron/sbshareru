@extends('admin.layout')

@section('title')
Добавление новости
@stop

@section('inner_content')
    <h2>Добавление новости</h2>
    {{ Form::open(array('url' => URL::route('admin.news.store'), 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form')) }}
        @include('admin.news.form')

        <div class="form-group">
            <div class="col-sm-2">&nbsp;</div>
            <div class="col-sm-5">
                <button type="submit" class="btn btn-primary" id="submit-button" data-submit-message="Добавление ...">Добавить</button>
                <a href="#" class="btn btn-primary preview-button" data-source-input="news">Предварительный просмотр</a>
            </div>
        </div>

    {{ Form::close() }}
@stop
