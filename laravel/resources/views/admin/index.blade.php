@extends('admin.layout')

@section('title', 'Dashboard')

@section('css')


@endsection

@section('content')

    <h2>Dashboard</h2>

    @include('admin.notifications')


    <div class="row-fluid">

        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>


                        @if($user->hasAccess('admin.pages.create'))
                            <div class="box-header">
                                <div class="row">
                                    <div class="col-md-12 padding-bottom-10">
                                        <a href="{{ URL::route('admin.pages.create') }}"  class="btn btn-info btn-sm pull-left"><span class="fa fa-plus"> &nbsp;</span>Добавить</a>
                                    </div>
                                </div>
                            </div>
                            <br>
                        @endif

                        <div class="table-responsive">
                            <table id="itemList" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                <tr>
                                    <th data-hide="phone,tablet"> Название</th>
                                    <th data-hide="phone,tablet"> Ссылка</th>
                                    <th data-hide="phone,tablet"> В верхнем меню</th>
                                    <th data-hide="phone,tablet"> В нижнем меню</th>
                                    <th data-hide="phone,tablet"> Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->



    </div>

@endsection

@section('js')

    <script>

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
                ajax: '{!! URL::route('admin.datatable.pages') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'link', name: 'link'},
                    {data: 'top', name: 'top'},
                    {data: 'bot', name: 'bot'},
                    {data: "actions", name: 'actions', orderable: false, searchable: false}
                ],
            });
        });

    </script>

@endsection