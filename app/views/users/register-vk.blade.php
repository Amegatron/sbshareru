@extends('layout')

@section('title')
Завершение регистрации
@stop

@section('content')
<div class="container">
    @if ($errors->all())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <h1>Завершение регистрации</h1>

    <p>
        Вы вошли как <strong>{{ $userData['first_name'] }} {{ $userData['last_name'] }}</strong>.
    </p>
    <p>
        Для завершения процедуры необходимо указать желаемое имя пользователя,
        и желательно (но не обязательно) свой электронный адрес.
    </p>

    {{ Form::open(array('url' => 'users/register-vk', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
    <div class="form-group">
        {{ Form::label('username', 'Никнейм', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-5">
            {{ Form::text('username', null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('email', 'E-Mail', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-5">
            {{ Form::email('email', null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2">&nbsp;</div>
        <div class="col-sm-5">
            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
            <a href="/social-auth/cancel" class="btn btn-danger">Отмена</a>
        </div>
    </div>
    {{ Form::close() }}
</div>
@stop
