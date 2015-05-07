@extends('layout')

@section('title')
Добавить планету
@stop

@section('content')
<div class="jumbotron">
    <div class="container">
        @if($errors->all())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <h2>Добавление планеты</h2>

        @if (!Auth::check())
            <p>Вы собираетесь добавить планету как незарегистрированный пользователь. В этом случае вы не сможете впоследтвии внести изменения. Кроме того, ваша планета будет добавлена от имени "Аноним".</p>
        @endif

        {{ Form::open(array('url' => 'planets/add', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
            @include('planets/form')

            <div class="form-group">
                <label for="tags" class="col-sm-2 control-label">Тэги</label>
                <div class="col-sm-5">
                    <small>Используйте клавишу TAB для добавления тэга<br /></small>
                    <ul id="planet-tags"></ul>
                </div>
            </div>


            @if (!Auth::check())
            <div class="form-group">
                {{ Form::label('captcha_img', 'Проверка**', array('class' => 'col-sm-2 control-label')) }}
                <div class="col-sm-5">
                    {{ HTML::image(Captcha::img(), 'Captcha') }}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">&nbsp;</div>
                <div class="col-sm-5">
                    {{ Form::text('captcha', null, array('class' => 'form-control')) }}
                    <p><sup>**</sup><small><a href="/users/register">Зарегистрированным</a> пользователям не требуется вводить проверочный код</small></p>
                </div>
            </div>
            @endif

            <div class="form-group">
                <div class="col-sm-2">&nbsp;</div>
                <div class="col-sm-5">
                    <button type="submit" class="btn btn-primary" id="submit-button" data-submit-message="Добавление ...">Добавить</button>
                    <a href="#" class="btn btn-primary preview-button" data-source-input="comment">Предварительный просмотр</a>
                </div>
            </div>

        {{ Form::close() }}
    </div>
</div>
@stop
