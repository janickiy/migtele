@extends('layouts.template')

@section('content')


    <div class="main-side">
        <div class="heading-2">Сменить пароль</div>

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

            <div class="row row-btn">
                <div class="form-column__left"></div>
                <div class="form-column__right">
                    <button type="submit" class="btn btn-primary">
                        Сменить
                    </button>
                </div>
            </div>


        </form>

    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"></div>

                    <div class="panel-body">



                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection


