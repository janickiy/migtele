@extends('layouts.admin')

@section('title', isset($worktypes) ? 'Редактирование типа выполненных работ' : 'Добавление типа выполненных работ' )

@section('content')

    <h2>{!! isset($worktypes) ? 'Редактирование' : 'Добавление' !!} типа выполненных работ</h2>

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

                    {!! Form::open(['url' => isset($worktypes) ? URL::route('admin.worktypes.update') : URL::route('admin.worktypes.store'), 'method' => isset($worktypes) ? 'put' : 'post', 'class' => 'form-horizontal']) !!}

                    {!! isset($worktypes) ? Form::hidden('id', $worktypes->id) : '' !!}

                    <div class="box-body">
                        <div class="form-group">

                            {!! Form::label('name', 'Название*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::text('name', old('name', isset($worktypes->name) ? $worktypes->name : null), ['class' => 'form-control', 'placeholder'=>'Название', 'id' => 'name']) !!}

                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="form-group">

                            {!! Form::label('code', 'Код*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::text('code', old('code', isset($worktypes->code) ? $worktypes->code : null), ['class' => 'form-control', 'placeholder'=>'Код', 'id' => 'code']) !!}

                                @if ($errors->has('code'))
                                    <span class="text-danger">{{ $errors->first('code') }}</span>
                                @endif
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
    <script type="text/javascript">


    </script>
@endsection