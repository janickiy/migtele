@extends('admin.layout')

@section('title', isset($role) ? 'Редактирование страницы' : 'Добавление страницы')

@section('css')

@endsection

@section('content')

    <h2>{!! isset($role) ? 'Редактирование' : 'Добавление' !!} страницы</h2>
    <div class="row-fluid">

        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>

                    <p>*-обязательные поля</p>

                    {!! Form::open(['url' => isset($role) ? URL::route('admin.pages.update') : URL::route('admin.pages.store'), 'method' => isset($role) ? 'put' : 'post', 'class' => 'form-horizontal']) !!}



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