@extends('admin.layout')

@section('title', $title)

@section('css')

@endsection

@section('content')

    <h2>{!! $title !!}</h2>

    @include('admin.notifications')

    <div class="row-fluid">

        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>

                    @if($user->hasAccess('admin.trainscar.create'))
                        <div class="box-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ URL::route('admin.trainscar.create') }}"
                                       class="btn btn-info btn-sm pull-left"><span class="fa fa-plus"> &nbsp;</span>Добавить тип вагона</a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <br>

                    <table id="itemList" class="table table-striped table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th data-hide="phone">Тип вагона</th>
                            <th data-class="expand">Тип вагона<br>для отображения пассажиру</th>
                            <th data-hide="phone">№ поезда</th>
                            <th data-hide="phone">Поезд</th>
                            <th data-hide="phone">Описание</th>
                            <th data-hide="phone">Тип схемы</th>
                            <th data-hide="phone">Схема</th>
                            <th data-hide="phone,tablet"> Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->

    </div>

@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $("#itemList").DataTable({
                'createdRow': function (row, data, dataIndex) {
                    $(row).attr('id', 'rowid_' + data['id']);
                },
                processing: true,
                serverSide: true,
                ajax: '{!! URL::route('admin.datatable.trainscar') !!}',
                columns: [
                    {data: 'typeRu', name: 'typeRu'},
                    {data: 'typeEn', name: 'typeEn'},
                    {data: 'trains.trainNumber', name: 'trains.trainNumber'},
                    {data: 'trains.trainName', name: 'trains.trainName'},
                    {data: 'description', name: 'description'},
                    {data: 'typeScheme', name: 'typeScheme'},
                    {data: 'scheme', name: 'scheme'},
                    {data: "actions", name: 'actions', orderable: false, searchable: false}
                ],
            });
        });

        $('#itemList').on('click', 'a.deleteRow', function () {

            var btn = this;
            var rowid = $(this).attr('id');
            swal({
                    title: "Вы уверены?",
                    text: "Вы не сможете восстановить эту информацию!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Да, удалить!",
                    cancelButtonText: "Отмена",
                    closeOnConfirm: false
                },
                function (isConfirm) {
                    if (!isConfirm) return;
                    $.ajax({
                        url: SITE_URL + "/cp/orders-railway/trains-car/destroy/" + rowid,
                        type: "DELETE",
                        dataType: "html",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function () {
                            $("#rowid_" + rowid).remove();
                            swal("Сделано!", "Данные успешно удаленны!", "success");
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            swal("Ошибка при удалении!", "Попробуйте еще раз", "error");
                        }
                    });
                });
        });

    </script>
@endsection