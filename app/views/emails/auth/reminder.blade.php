<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Восстановление пароля</h2>

<div>
    Чтобы сбросить пароль, заполните форму: {{ URL::to('password/reset', array($token)) }}.
</div>
</body>
</html>
