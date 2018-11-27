@extends('modals.template', [
    'id' => 'login-form',
    'title' => 'Вход',
    'description' => 'Введите свой логин(email) и пароль для входа в личный кабинет:'
])

@section('modal-content')
    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <input type="text" name="email" class="form-control" placeholder="Логин" value="{{ old('email') }}" required>

        <input type="password" name="password" class="form-control" placeholder="Пароль" required>

        <div class="form-checkbox">
            <input class="checkbox" id="login-remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-checkbox" for="login-remember">Запомнить меня</label>
        </div>

        @if ($errors->has('email'))
            <span class="help-block login-error" style="margin-top: 20px">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
        @endif
        @if ($errors->has('password'))
            <span class="help-block login-error" style="margin-top: 20px">>
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
        @endif

        <div class="center login-button">
            <button type="submit" class="btn">Войти</button>
        </div>

    </form>

    <div class="login-helper_links">
        <a href="{{ route('register') }}">Зарегистрироваться</a>
        <a href="{{ route('password.request') }}">Забыли пароль?</a>
    </div>
@endsection