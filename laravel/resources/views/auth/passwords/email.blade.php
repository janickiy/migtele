@extends('layouts.template')

@section('content')

    <div class="main-side">

        <form action="{{ route('password.email') }}" method="POST" class="form-wrapper">

            {{ csrf_field() }}

            <div class="form-title">Запрос пароля</div>

            <div class="form-description">Для восстановления пароля необходимо указать E-mail, который вы указывали при регистрации.
                <br>После завершения формы, ссылка на востановления пароля будет выслана вам на почту.</div>

            <div class="row {{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="form-column__left">
                    <label for="forgot_password-email">E-mail <span class="required">*</span></label>
                </div>
                <div class="form-column__right">
                    <div class="form-valid-error">
                        <input tabindex="1" class="form-control" name="email" type="text" value="{{ old('email') }}" id="forgot_password-email">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row row-btn row-btn__forgot-password">
                <div class="form-column__left"></div>
                <div class="form-column__right">
                    <button tabindex="2" type="submit" class="btn">Отправить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
