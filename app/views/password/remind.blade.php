@extends('layout')

@section('title')
Сброс пароля
@stop

@section('content')

<div class="container">
    @if (Session::get('status') || Session::get('error'))
        @if (Session::get('status'))
        <p>{{ Session::get('status') }}</p>
        @elseif (Session::get('error'))
        <p>{{ Session::get('error') }}</p>
        @endif
    @endif

    <h1>Восстановление пароля</h1>
    <form action="{{ action('RemindersController@postRemind') }}" method="POST">
        <fieldset>
            <p><input type="text" class="text"  placeholder="Ваш E-mail" name="email" /></p>
            <input class="enter" type="submit" value="Послать запрос" />
        </fieldset>
    </form>
</div>
@stop
