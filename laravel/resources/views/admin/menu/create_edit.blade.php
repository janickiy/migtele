@extends('admin.layout')

@section('title', isset($menu) ? 'Редактирование меню' : 'Добавление меню' )

@section('content')

    <h2>{!! isset($menu) ? 'Редактирование' : 'Добавление' !!} категории</h2>

    <div class="row-fluid">
        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>

                    <p>*-обязательные поля</p>

                    {!! Form::open(['url' => isset($menu) ? URL::route('admin.menu.update') : URL::route('admin.menu.store'), 'method' => isset($menu) ? 'put' : 'post', 'class' => 'form-horizontal']) !!}

                    {!! isset($menu) ? Form::hidden('id', $menu->id) : '' !!}

                    {!!  Form::hidden('parent_id', isset($parent_id) ? $parent_id : 0) !!}

                    <div class="box-body">

                        <div class="form-group">

                            {!! Form::label('title', 'Название*', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::text('title', old('title', isset($menu->title) ? $menu->title : null), ['class' => 'form-control', 'placeholder'=>'Название']) !!}

                                @if ($errors->has('title'))
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('item_order', 'Порядок *', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">

                                {!! Form::text('item_order', old('item_order',  $item_order), ['class' => 'form-control', 'placeholder'=>'Порядок']) !!}

                            </div>

                            @if ($errors->has('item_order'))
                                <span class="text-danger">{{ $errors->first('item_order') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            {!! Form::label('url', 'URL', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('url', old('url', isset($menu) ? $menu->url : null), ['class' => 'form-control', 'placeholder'=>'URL']) !!}
                            </div>

                            @if ($errors->has('url'))
                                <span class="text-danger">{{ $errors->first('url') }}</span>
                            @endif
                        </div>

                        <div class="form-group">

                            {!! Form::label('parent_id', 'Раздел', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                @if ($parent_id > 0)

                                    {!! Form::select('parent_id', $options, $parent_id, ['class' => 'form-control']) !!}

                                @else

                                    {!! Form::select('parent_id', $options, isset($menu) ? $menu->parent_id : 0, ['class' => 'form-control']) !!}

                                @endif

                                @if ($errors->has('parent_id'))
                                    <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">

                            {!! Form::label('status', 'Отображать', ['class' => 'col-sm-3 control-label']) !!}

                            <div class="col-sm-6">

                                {!! Form::checkbox('status', 1, isset($menu) ? ($menu->status == 1 ? true : false): true) !!}

                                @if ($errors->has('status'))
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                @endif

                            </div>
                        </div>

                    </div>

                    <div class="box-footer">
                        <div class="col-sm-4">
                            <a href="{{ URL::route('admin.menu.list') }}" class="btn btn-danger btn-flat pull-right">Отменить</a>
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


@endsection