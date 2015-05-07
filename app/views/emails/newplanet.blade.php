<?php
    if ($user) {
        $userName = $user->username;
    } else {
        $userName = "Аноним";
    }
?>
Пользователь {{ $userName }} добавил новую планету!<br />
<br />
<b>{{ $planet->planet }}</b><br />
Уровень {{ $planet->level }}<br />
<br />
{{ prepare_text($planet->comment) }}<br />
<a href="{{ action('PlanetsController@getView', array($planet->id)) }}">Детали планеты &raquo;</a>
