@extends('layouts.admin')

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

                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-12 padding-bottom-10">
                                <button type="button" class="btn btn-info btn-sm pull-left" onclick="window.history.back();">
                                    назад
                                </button>
                            </div>
                        </div>
                    </div>
                    <br>

                    <p>*-обязательные поля</p>

                    {!! Form::open(['url' => isset($userData) ? URL::route('admin.user.update') : URL::route('admin.user.store'), 'files' => true, 'method' => isset($userData) ? 'put' : 'post', 'class' => 'form-horizontal', 'id' => "admin"]) !!}

                    <div class="box-body">

                        {!! isset($userData) ? Form::hidden('id', $userData->id) : '' !!}

                        <div class="form-group">

                            {!! Form::label('name', 'Имя*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::text('name', old('name', isset($userData) ? $userData->name : null), ['class' => 'form-control', 'id' => 'login']) !!}

                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif

                            </div>
                        </div>

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

                            {!! Form::label('phone', 'Телефон', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::text('phone', old('phone', isset($userData) ? $userData->phone : null), ['class' => 'form-control', 'id'=>'phone']) !!}

                                @if ($errors->has('phone'))
                                    <p class="text-danger">{{ $errors->first('phone') }}</p>
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

                        <div class="form-group">

                            {!! Form::label('role_id', 'Роль*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::select('role_id', $role_options, isset($userData->role->id) ? $userData->role->id : null, ['placeholder' => 'выберите', 'class' => 'assessment form-control', 'id' => 'role_id']) !!}

                                @if ($errors->has('role_id'))
                                    <p class="text-danger">{{ $errors->first('role_id') }}</p>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('avatar', 'Аватар', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::file('avatar',  ['class' => 'form-control input-file-field']) !!}

                                {!! Form::hidden('pic', isset($userData) && $userData->avatar ? $userData->avatar : 'NULL') !!}

                                <br>
                                @if (isset($userData) && !empty($userData->avatar))
                                    <img src='{{ url("uploads/users/$userData->avatar") }}' alt="No Avatar" width="80"  height="80">
                                @endif

                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('area_id', 'Производственный участок', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::select('area_id', $options, isset($userData) ? $userData->area_id : null, ['placeholder' => 'Выберите', 'class' => 'form-control']) !!}

                                @if ($errors->has('area_id'))
                                    <span class="text-danger">{{ $errors->first('area_id') }}</span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('notifyDetectedFault', 'Уведомлять об обнаруженной неисправности', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">
                               {!! Form::checkbox('notifyDetectedFault', 1, isset($userData) ? ($userData->notifyDetectedFault ? true : false) : false, ['class'=>'minimal']) !!}
                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('notifyFaultFix', 'Уведомлять об исправлении неисправности', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">
                                {!! Form::checkbox('notifyFaultFix', 1, isset($userData) ? ($userData->notifyFaultFix ? true : false) : false, ['class'=>'minimal']) !!}
                            </div>
                        </div>



                    <div class="form-group">
                        <div class="col-sm-3 control-label"></div>
                        <div class="col-sm-6">

                            {!! Form::submit( 'Отправить', ['class'=>'btn btn-success']) !!}

                        </div>
                    </div>

                </div>

                    {!! Form::close() !!}

                </div>
            </div>

        </div>
    </div>

@endsection

@section('js')


@endsection