@extends('mobile.layouts.template')

@section('content')

    @include('mobile.components.back_link', [
            'name' => 'Главная',
            'url' => '/'
    ])

    <div class="container">

        <div class="heading-1">Сменить пароль</div>

        <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            @include('form.row', [
                'label' => 'E-mail',
                'required' => true,
                'field_name' => 'email',
                'field_id' => 'reset-email',
                'tabindex' => 1
            ])

            @include('form.row', [
                'label' => 'Пароль',
                'required' => true,
                'field_name' => 'password',
                'field_id' => 'reset-password',
                'tabindex' => 2
            ])

            @include('form.row', [
                'label' => 'Повторить пароль',
                'required' => true,
                'field_name' => 'password_confirmation',
                'field_id' => 'reset-password_confirmation',
                'tabindex' => 3
            ])

            <div class="center login-button">
                <button type="submit" class="btn">Отправить</button>
            </div>


        </form>



    </div>




@endsection