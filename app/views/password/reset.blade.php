@extends('layout')

@section('title')
Сброс пароля
@stop

@section('content')
<form action="{{ action('RemindersController@postReset') }}" method="POST">
    <fieldset>
        <table>
            <tr>
                <td>Ваш E-Mail:</td>
                <td><input type="email" name="email" /></td>
            </tr>
            <tr>
                <td>Новый пароль:</td>
                <td><input type="password" name="password" /></td>
            </tr>
            <tr>
                <td>Повтор пароля:</td>
                <td><input type="password" name="password_confirmation"></td>
            </tr>
            <tr><td colspan="2">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="submit" value="Установить пароль">
                </td></tr>
        </table>
    </fieldset>
</form>
@stop
