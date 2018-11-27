@extends('emails.layouts.template')

@section('title')
    Запрос на сброс пароля
@endsection

@section('description', 'Чтобы сбросить пароль перейдите по ссылке:')

@section('content')

    <div class="body-title" style="border: 0; font: inherit; font-size: 20px; line-height: 20px; margin: 0; margin-top: 30px; padding: 0; text-align: center; vertical-align: baseline;">Востановление пароля</div>
    <div class="body-description" style="border: 0; font: inherit; font-size: 18px; line-height: 18px; margin: 0; margin-top: 16px; padding: 0; text-align: center; vertical-align: baseline;">
        Перейдите по ссылке для востановления пароля на сайте Migtele
        <br>
        <a href="{{ url(route('password.reset', $token, false)) }}">{{ url(route('password.reset', $token, false)) }}</a>
    </div>

@endsection