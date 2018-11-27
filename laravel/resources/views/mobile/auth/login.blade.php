@extends('mobile.layouts.template')

@section('content')

    @include('mobile.components.back_link', [
            'name' => 'Главная',
            'url' => '/'
    ])

    <div class="container">

        <div class="heading-1">Вход</div>

        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group">
                <label class="label">Логин<span>*</span></label>
                <input type="text" name="email" class="form-control" placeholder="Логин" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label class="label">Пароль<span>*</span></label>
                <input type="password" name="password" class="form-control" placeholder="Пароль" required>
            </div>



            <div class="form-group__checkboxes">
                <div class="form-checkbox">
                    <input class="checkbox" id="login-remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-checkbox" for="login-remember">Запомнить меня</label>
                </div>
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

    </div>




@endsection