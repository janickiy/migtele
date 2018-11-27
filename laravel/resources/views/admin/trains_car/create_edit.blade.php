@extends('admin.layout')

@section('title', isset($trainsCar) ? 'Редактирование типа вагона' : 'Добавление типа вагона')

@section('css')

    <style type="text/css">

        #image-preview {
            height: 350px;
            position: relative;
            overflow: hidden;
            background-color: #ffffff;
            color: #ecf0f1;
        }

        #image-preview input {
            line-height: 200px;
            font-size: 200px;
            position: absolute;
            opacity: 0;
            z-index: 10;
        }

        #image-preview label {
            position: absolute;
            z-index: 5;
            opacity: 0.8;
            cursor: pointer;
            background-color: #bdc3c7;
            width: 200px;
            height: 50px;
            font-size: 20px;
            line-height: 50px;
            text-transform: uppercase;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            text-align: center;
        }

    </style>

@endsection

@section('content')

    <h2>{!! isset($trainsCar) ? 'Редактирование' : 'Добавление' !!} типа вагона</h2>

    <div class="row-fluid">

        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>

                    <p>*-обязательные поля</p>

                    {!! Form::open(['url' => isset($trainsCar) ? URL::route('admin.trainscar.update') : URL::route('admin.trainscar.store'), 'files' => true, 'method' => isset($trainsCar) ? 'put' : 'post', 'class' => 'form-horizontal']) !!}

                    <div class="box-body">

                        {!! isset($trainsCar) ? Form::hidden('id', $trainsCar->id) : '' !!}

                        <div class="form-group">

                            {!! Form::label('typeRu', 'Тип вагона*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::text('typeRu', old('typeRu', isset($trainsCar) ? $trainsCar->typeRu : null), ['class' => 'form-control', 'id'=>'typeRu', isset($trainsCar) && $trainsCar->isAddedManually == 0 ? 'readonly' : '']) !!}

                                @if ($errors->has('typeRu'))
                                    <p class="text-danger">{{ $errors->first('typeRu') }}</p>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('typeEn', 'Тип вагона для отображения пассажиру*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::text('typeEn', old('typeEn', isset($trainsCar) ? $trainsCar->typeEn : null), ['class' => 'form-control', 'id'=>'typeEn', isset($trainsCar) && $trainsCar->isAddedManually == 0 ? 'readonly' : '']) !!}

                                @if ($errors->has('typeEn'))
                                    <p class="text-danger">{{ $errors->first('typeEn') }}</p>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('typeScheme', 'Тип схемы*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::text('typeScheme', old('typeScheme', isset($trainsCar) ? $trainsCar->typeScheme : null), ['class' => 'form-control', 'id' => 'typeScheme', isset($trainsCar) && $trainsCar->isAddedManually == 0 ? 'readonly' : '']) !!}

                                @if ($errors->has('typeScheme'))
                                    <p class="text-danger">{{ $errors->first('typeScheme') }}</p>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('description', 'Дополнительное описание вагона', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::textarea('description', old('description', isset($trainsCar) ? $trainsCar->description : null), ['class' => 'form-control', 'rows' => 3]) !!}

                                @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('train_id', 'Поезд*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                @if(isset($trainsCar) && $trainsCar->isAddedManually == 0)
                                    {!! Form::select('train_id', $options, isset($trainsCar) ? $trainsCar->train_id : null, ['placeholder' => 'Выберите', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                @else
                                    {!! Form::select('train_id', $options, isset($trainsCar) ? $trainsCar->train_id : null, ['placeholder' => 'Выберите', 'class' => 'form-control']) !!}
                                @endif

                                @if ($errors->has('train_id'))
                                    <p class="text-danger">{{ $errors->first('train_id') }}</p>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 control-label"></div>
                            <div class="col-sm-6">
                                @if(isset($trainsCar) && $trainsCar->scheme) <div style="right:-20px;z-index:999; position:absolute; top:0;"><a href="#" class="btn btn-xs btn-danger deleteIm pull-right" data-id="{{ $trainsCar->id }}" id="im_{{ $trainsCar->id }}"><span data-id="{{ $trainsCar->id }}" style="left: 170px;" class="fa fa-remove"></span></a></div> @endif
                                <div id="image-preview" style="{{ isset($trainsCar) && $trainsCar->scheme ? 'background-image: url("' . Storage::url($trainsCar->scheme) . '"); background-size: contain; background-position: top left; background-repeat: no-repeat' : ''}}">

                                    {!! Form::label('image-upload', 'Выберите файл', ['id' => 'image-label']) !!}

                                    {!! Form::file('scheme',  ['id' => 'image-upload']) !!}

                                </div>

                                @if ($errors->has('scheme'))
                                    <p class="text-danger">{{ $errors->first('scheme') }}</p>
                                @endif

                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <div class="col-sm-4">

                            <a href="{{ URL::route('admin.trainscar.list') }}"  class="btn btn-danger btn-flat pull-right">Отменить</a>

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

    <script type="text/javascript">
        $(document).ready(function () {

            var idTrainsCar = $('.deleteIm').attr('data-id');

            $("#image-label").click(function () {
                $("#im_" + idTrainsCar).show();
            });

            $.uploadPreview({
                input_field: "#image-upload",
                preview_box: "#image-preview",
                label_field: "#image-label",
                label_default: "Выберите файл",
                label_selected: "Выберите файл",
                no_label: false
            });

            $(".deleteIm").click(function () {
                swal({
                        title: "Вы уверены?",
                        text: "Вы не сможете восстановить эту информацию!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Да, удалить!",
                        closeOnConfirm: false
                    },
                    function (isConfirm) {
                        if (!isConfirm) return;

                        $.ajax({
                            url: SITE_URL + "/cp/orders-railway/trains-car/del-image/" + idTrainsCar,
                            type: "DELETE",
                            dataType: "html",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success: function () {
                                $("#im_" + idTrainsCar).hide();
                                $("#image-preview").removeAttr('style');
                                swal("Сделано!", "Данные успешно удалены!", "success");
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                swal("Ошибка при удалении!", "Попробуйте еще раз", "error");
                            }
                        });
                    });
            });
        });
    </script>

@endsection