@component('mail::message')
# Добро пожаловать, {{ trim($user->name) }}.

Вы успешно зарегистрировались на сайте {{ config('app.name') }}

@if($password)
>Ваш пароль: **{{ $password }}**
@endif

С уважением,<br>
{{ config('app.name') }}
@endcomponent
