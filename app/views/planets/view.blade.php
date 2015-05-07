@extends('layout')

@section('title')
Планета {{ $planet->planet }}
@stop

@section('content')
<div class="jumbotron">
    <div class="container">
        @if ($errors->all())
            @foreach($errors->all() as $error)
                <p class="bg-danger">{{ $error }}</p>
            @endforeach
        @endif

        <h2>
            Планета {{ $planet->planet }}
            @if (Auth::check() && (Auth::user()->isAdmin || Auth::user()->id == $planet->user_id))
                <a href="/planets/edit/{{ $planet->id }}"><small>[редактировать]</small></a>
                <a href="/planets/delete/{{ $planet->id }}" id="delete-planet"><small>[удалить]</small></a>
            @endif
        </h2>
    </div>
</div>
<div class="container">
    <table class="table table-striped">
        <tr>
            <td>Сектор:</td>
            <td>{{ Planet::$sectors[$planet->sector] }}</td>
        </tr>
        <tr>
            <td>Уровень:</td>
            <td>{{ $planet->level }}</td>
        </tr>
        <tr>
            <td>Звезда:</td>
            <td>{{{ $planet->star }}}</td>
        </tr>
        <tr>
            <td>Система:</td>
            <td>{{{ $planet->system }}}</td>
        </tr>
        <tr>
            <td>Планета:</td>
            <td>{{{ $planet->planet }}}</td>
        </tr>
        <tr>
            <td>Биом:</td>
            <td>{{ Planet::$bioms[$planet->biome] }}</td>
        </tr>
        <tr>
            <td>Координаты:</td>
            <td>
                <table>
                    <tr>
                        <td>X:</td>
                        <td>{{ $planet->x }}</td>
                    </tr>
                    <tr>
                        <td>Y:</td>
                        <td>{{ $planet->y }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>Версия игры:</td>
            <td>{{ Planet::$versions[$planet->version] }}</td>
        </tr>
        <tr>
            <td>OS (операционная система):</td>
            <td>{{ Planet::$oses[$planet->os] }}</td>
        </tr>
        <tr>
            <td>Добавил:</td>
            <td>
                <b>
                    {{ $planet->author }}
                </b>
            </td>
        </tr>
        <tr>
            <td>Просмотров:</td>
            <td>{{ $planet->views }}</td>
        </tr>
        @if (count($planet->tags))
            <tr>
                <td>Тэги:</td>
                <td>
                    @foreach($planet->tags as $tag)
                        {{ $tag->tag }}
                    @endforeach
                </td>
            </tr>
        @endif
    </table>
    <p>&nbsp;</p>
    <p>{{ $planet->comment }}</p>
    <p>&nbsp</p>

    @if (count($relatedPlanets))
        <h3>Планеты рядом:</h3>
        <ul>
            @foreach($relatedPlanets as $relatedPlanet)
                <li><a href="/planets/view/{{ $relatedPlanet->id }}">{{ $relatedPlanet->planet }}</a>, уровень {{ $relatedPlanet->level }}, OS {{ Planet::$oses[$relatedPlanet->os] }}</li>
            @endforeach
        </ul>
    @endif

    <a name="comments"></a>
    @if (count($planet->comments))
        <h3>Комментарии:</h3>
        @foreach($planet->comments as $comment)
            @include('planets/comment')
        @endforeach
    @endif

    {{ Form::open(array('url' => 'comments/add', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}

        <div class="form-group">
            {{ Form::label('comment', 'Комментарий*', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-5">
                {{ Form::textarea('comment', null, array('class' => 'form-control bbeditor')) }}<br />
                <sup>*</sup> Поддерживаются <a href="http://ru.wikipedia.org/wiki/BbCode" target="_blank">BB-коды</a>,
                <a href="http://www.emoji-cheat-sheet.com/" target="_blank">смайлы</a>, и упоминания других пользователей (например, <strong>@Amegatron</strong>).
            </div>
        </div>
        @include('partials.preview')

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
                {{ Form::hidden('planet_id', $planet->id) }}
                <button type="submit" class="btn btn-primary" id="submit-button" data-submit-message="Отправка ...">Отправить комментарий</button>
                <a href="#" class="btn btn-primary preview-button" data-source-input="comment">Предварительный просмотр</a>
            </div>
        </div>
    {{ Form::close() }}
</div>
@stop
