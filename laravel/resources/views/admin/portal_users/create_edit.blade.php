@extends('admin.layout')

@section('title', isset($userData) ? 'Редактирование пользователя' : 'Добавление пользователя')

@section('css')

@endsection

@section('content')

    <h2>{!! isset($userData) ? 'Редактирование' : 'Добавление' !!} пользователя</h2>
    <div class="row-fluid">

        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>

                    <p>*-обязательные поля</p>

                    {!! Form::open(['url' => isset($userData) ? URL::route('admin.portalusers.update') : URL::route('admin.portalusers.store'), 'method' => isset($userData) ? 'put' : 'post', 'class' => 'form-horizontal', 'id' => "admin"]) !!}

                    <div class="box-body">

                        {!! isset($userData) ? Form::hidden('userId', $userData->userId) : '' !!}


                        <div class="form-group">

                            {!! Form::label('email', 'Email*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::email('email', old('email', isset($userData) ? $userData->email : null), ['class' => 'form-control', 'id'=>'email']) !!}

                                @if ($errors->has('email'))
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('mobile', 'Телефон', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::text('mobile', old('mobile', isset($userData) ? $userData->mobile : null), ['class' => 'form-control', 'id'=>'mobile']) !!}

                                @if ($errors->has('mobile'))
                                    <p class="text-danger">{{ $errors->first('mobile') }}</p>
                                @endif

                            </div>
                        </div>


                        <div class="form-group">

                            {!! Form::label('password', isset($userData) ? 'Пароль' : 'Пароль*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::password('password', null, ['class' => 'form-control', 'id'=>'password']) !!}

                                @if ($errors->has('password'))
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('confirm_password', isset($userData) ? 'Подтвердите пароль' : 'Подтвердите пароль*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::password('confirm_password', null, ['class' => 'form-control', 'id'=>'confirm_password']) !!}

                                @if ($errors->has('confirm_password'))
                                    <p class="text-danger">{{ $errors->first('confirm_password') }}</p>
                                @endif

                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <div class="col-sm-4">
                            <a href="{{ URL::route('admin.portalusers.list') }}" class="btn btn-danger btn-flat pull-right">Отменить</a>
                        </div>
                        <div class="col-sm-5 margin-bottom-10">

                            {!! Form::submit( 'Отправить', ['class'=>'btn btn-success']) !!}

                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script>


    </script>

@endsection