@extends('layouts.admin')

@section('title', $title)

@section('css')

@endsection


@section('content')


    <h2>{{ $title }}</h2>

    @include('layouts.admin_common.notifications')

    <div class="row-fluid">

        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>

                    @if(Helpers::has_permission(Auth::user()->id, 'add_area'))
                        <div class="box-header">
                            <div class="row">
                                <div class="col-md-12 padding-bottom-10">
                                    <a href="{{ URL::route('admin.area.create') }}"
                                       class="btn btn-info btn-sm pull-left"><span class="fa fa-plus"> &nbsp;</span>Добавить
                                        участок</a>
                                </div>
                            </div>
                        </div>
                        <br>
                    @endif
                    <div class="table-responsive">
                        <table id="itemList" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th data-hide="phone"> Название</th>
                                <th data-hide="phone"> Код</th>
                                <th data-hide="phone"> ФИО мастера производства</th>
                                <th data-hide="phone,tablet"> Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
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
                "sDom": 'lfrtip',
                "autoWidth": true,
                "oLanguage": {
                    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
                },
                'createdRow': function (row, data, dataIndex) {
                    $(row).attr('id', 'rowid_' + data['id']);
                },
                processing: true,
                serverSide: true,
                ajax: '{!! URL::route('admin.datatable.area') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'code', name: 'code'},
                    {data: 'master', name: 'master'},
                    {data: "actions", name: 'actions', orderable: false, searchable: false}
                ],
            });
        });

        // Delete start
        $(document).ready(function () {

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
                            url: SITE_URL + "/admin/area/delete/" + rowid,
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
        });
        // Delete End
    </script>
@endsection