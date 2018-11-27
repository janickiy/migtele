@extends('layouts.admin')

@section('title', isset($equipment) ? 'Редактирование оборудования' : 'Добавление оборудования' )

@section('content')

    <h2>{!! isset($equipment) ? 'Редактирование' : 'Добавление' !!} оборудования</h2>

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

                    {!! Form::open(['url' => isset($equipment) ? URL::route('admin.equipment.update') : URL::route('admin.equipment.store'), 'method' => isset($equipment) ? 'put' : 'post', 'class' => 'form-horizontal']) !!}

                    {!! isset($equipment) ? Form::hidden('id', $equipment->id) : '' !!}

                    <div class="box-body">
                        <div class="form-group">

                            {!! Form::label('name', 'Название*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::text('name', old('name', isset($equipment->name) ? $equipment->name : null), ['class' => 'form-control', 'placeholder'=>'Название', 'id' => 'name']) !!}

                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('description', 'Описание', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::textarea('description', old('description', isset($equipment) ? $equipment->description : null), ['placeholder' =>'Описание','class' => 'form-control', 'rows' => 3]) !!}

                                @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('area_id', 'Производственный участок*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::select('area_id', $options, isset($equipment) ? $equipment->area_id : null, ['placeholder' => 'Выберите', 'class' => 'form-control']) !!}

                                @if ($errors->has('area_id'))
                                    <span class="text-danger">{{ $errors->first('area_id') }}</span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('time_weight', 'Врменной вес*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::selectRange('time_weight', 1, 20, isset($equipment) ? $equipment->time_weight : 1, ['class' => 'form-control', 'placeholder' => 'Выберите']) !!}

                                @if ($errors->has('time_weight'))
                                    <span class="text-danger">{{ $errors->first('time_weight') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('status', 'Активна', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::checkbox('status', 1, isset($equipment) ? ($equipment->status ? true : false) : true, ['class'=>'minimal']) !!}

                            </div>
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