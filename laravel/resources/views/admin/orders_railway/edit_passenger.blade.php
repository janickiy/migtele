@extends('admin.layout')

@section('title', $title)

@section('css')


@endsection

@section('content')

    <h2>{{ $title }}</h2>
    <div class="row-fluid">

        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>

                    {!! Form::open(['url' => URL::route('admin.orders-railway.update_passenger'), 'method' => 'put', 'class' => 'form-horizontal']) !!}

                    {!! Form::hidden('id', $id) !!}

                    <div class="box-body">

                        @foreach($passengers as $passenger)

                            <p>#{{ $passenger['Index'] }}</p>

                            {!! Form::hidden('passengersData[Index][]', $passenger['Index']) !!}

                            {!! Form::hidden('passengersData[OrderCustomerId][]', $passenger['OrderCustomerId']) !!}

                            <div class="form-group">

                                {!! Form::label('passengersData[FirstName]', 'Имя', ['class' => 'col-sm-3 control-label']) !!}

                                <div class="col-sm-6">

                                    {!! Form::text('passengersData[FirstName][]', old('passengersData[FirstName][]', $passenger['FirstName']), ['placeholder' => 'Имя','class' => 'form-control']) !!}

                                </div>
                            </div>

                            <div class="form-group">

                                {!! Form::label('passengersData[MiddleName]', 'Отчество', ['class' => 'col-sm-3 control-label']) !!}

                                <div class="col-sm-6">

                                    {!! Form::text('passengersData[MiddleName][]', old('passengersData[MiddleName][]', $passenger['MiddleName']), ['placeholder' => 'Отчество', 'class' => 'form-control']) !!}

                                </div>
                            </div>

                            <div class="form-group">

                                {!! Form::label('passengersData[LastName]', 'Фамиля', ['class' => 'col-sm-3 control-label']) !!}

                                <div class="col-sm-6">

                                    {!! Form::text('passengersData[LastName][]', old('passengersData[LastName][]', $passenger['LastName']), ['placeholder' => 'Фамиля', 'class' => 'form-control']) !!}

                                </div>
                            </div>

                            <div class="form-group">

                                {!! Form::label('passengersData[Birthday]', 'Дата рождения', ['class' => 'col-sm-3 control-label']) !!}

                                <div class="col-sm-6">

                                    {!! Form::text('passengersData[Birthday][]', old('passengersData[Birthday][]', isset($passenger['Birthday']) ? App\Helpers\DateTimeHelpers::convertDate($passenger['Birthday']) : '' ), ['placeholder' => 'ГГГГ-ММ-ДД', 'data-dateformat' => 'yy-mm-dd', 'id' => 'dateselect_filter1','class' => 'form-control datepicker']) !!}

                                </div>
                            </div>

                            <div class="form-group">

                                {!! Form::label('passengersData[BirthPlace]', 'Место рождения', ['class' => 'col-sm-3 control-label']) !!}

                                <div class="col-sm-6">

                                    {!! Form::text('passengersData[BirthPlace][]', old('passengersData[BirthPlace][]', isset($passenger['BirthPlace']) ? $passenger['BirthPlace'] : '' ), ['placeholder' => 'Место рождения', 'class' => 'form-control']) !!}

                                </div>
                            </div>

                            <div class="form-group">

                                {!! Form::label('passengersData[CitizenshipCode]', 'Граждансво', ['class' => 'col-sm-3 control-label']) !!}

                                <div class="col-sm-6">

                                    {!! Form::text('passengersData[CitizenshipCode][]', old('passengersData[CitizenshipCode][]', isset($passenger['CitizenshipCode']) ? $passenger['CitizenshipCode'] : '' ), ['placeholder' => 'Граждансво', 'class' => 'form-control']) !!}

                                </div>
                            </div>

                            <div class="form-group">

                                {!! Form::label('passengersData[DocumentType]', 'Тип документа', ['class' => 'col-sm-3 control-label']) !!}

                                <div class="col-sm-6">

                                    {!! Form::select('passengersData[DocumentType][]', $document_options, isset($passenger['DocumentType']) ? $passenger['DocumentType'] : null, ['class' => 'form-control', 'placeholder' => 'Выберите']) !!}

                                </div>
                            </div>

                            <div class="form-group">

                                {!! Form::label('passengersData[DocumentNumber]', '№ документа', ['class' => 'col-sm-3 control-label']) !!}

                                <div class="col-sm-6">

                                    {!! Form::text('passengersData[DocumentNumber][]', old('passengersData[DocumentNumber][]', isset($passenger['DocumentNumber']) ? $passenger['DocumentNumber'] : '' ), ['placeholder' => '№ документа', 'class' => 'form-control']) !!}

                                </div>
                            </div>

                            <div class="form-group">

                                {!! Form::label('passengersData[DocumentValidTill]', 'Срок действия документа', ['placeholder' => '', 'class' => 'col-sm-3 control-label']) !!}

                                <div class="col-sm-6">

                                    {!! Form::text('passengersData[DocumentValidTill][]', old('passengersData[DocumentValidTill][]', App\Helpers\DateTimeHelpers::convertDate($passenger['DocumentValidTill'])), ['placeholder' => 'ГГГГ-ММ-ДД', 'data-dateformat' => 'yy-mm-dd', 'id' => 'dateselect_filter2', 'class' => 'form-control datepicker']) !!}

                                </div>
                            </div>

                            <div class="form-group">

                                {!! Form::label('passengersData[Sex]', 'Пол', ['class' => 'col-sm-3 control-label']) !!}

                                <div class="col-sm-6">

                                    <div class="radio">
                                        <label>{!! Form::radio('passengersData[Sex][]', $passenger['Sex'], $passenger['Sex'] == 'Male' ? true : false) !!} Муж</label>
                                    </div>
                                    <div class="radio">
                                        <label>{!! Form::radio('passengersData[Sex][]', $passenger['Sex'],  $passenger['Sex'] == 'Female' ? true : false) !!} Жен</label>
                                    </div>

                                </div>
                            </div>

                        @endforeach

                        <div class="box-footer">
                            <div class="col-sm-4">
                                <a href="{{ URL::route('admin.ordersrailway.info',['id'=> $id]) }}"  class="btn btn-danger btn-flat pull-right">Отменить</a>
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
    </div>

@endsection

@section('js')

    <script>

        $(document).ready(function() {

            pageSetUp();

        });

    </script>

@endsection