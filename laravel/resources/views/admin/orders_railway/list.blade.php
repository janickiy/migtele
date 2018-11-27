@extends('admin.layout')

@section('title', $title)

@section('css')

@endsection

@section('content')

    @if (isset($title))<h2>{!! $title !!}</h2>@endif

    @include('admin.notifications')

    <div class="row-fluid">

        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>

                    {!! Form::open(['url' => URL::route('admin.ordersrailway.update'), 'method' => 'put']) !!}

                    <table id="ordersList" class="table table-striped table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th><span><input type="checkbox" title="Отметить все/Снять отметку у всех" id="checkAll"></span></th>
                            <th data-hide="phone">ID</th>
                            <th data-class="expand">Пользователь</th>
                            <th data-hide="phone">Статус</th>
                            <th data-hide="phone,tablet"> IP</th>
                            <th data-hide="phone,tablet"> Дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-sm-12 padding-bottom-10">
                            <div class="form-inline">
                                <div class="control-group">

                                    {!! Form::select('action', $status_list, null, ['class' => 'span3 form-control', 'placeholder' => 'выберите', 'id' => 'select_action']) !!}

                                    <span class="help-inline">

                                        {!! Form::submit( 'Применить', ['class' => 'btn btn-success']) !!}

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->

    </div>

@endsection

@section('js')
    <script>

        $(document).ready(function () {

            pageSetUp();

            /* // DOM Position key index //

            l - Length changing (dropdown)
            f - Filtering input (search)
            t - The Table! (datatable)
            i - Information (records)
            p - Pagination (paging)
            r - pRocessing
            < and > - div elements
            <"#id" and > - div with an id
            <"class" and > - div with a class
            <"#id.class" and > - div with an id and class

            Also see: http://legacy.datatables.net/usage/features
            */

            /* BASIC ;*/
            var responsiveHelper_dt_basic = undefined;
            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };

            $('#ordersList').dataTable({
                "sDom": "flrtip",
                "autoWidth": true,
                "oLanguage": {
                    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
                },
                "preDrawCallback": function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#ordersList'), breakpointDefinition);
                    }
                },
                "rowCallback": function (nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback": function (oSettings) {
                    responsiveHelper_dt_basic.respond();
                },
                'createdRow': function (row, data, dataIndex) {
                    $(row).attr('id', 'rowid_' + data['orderId']);
                },
                aaSorting : [[1, 'desc']],
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! URL::route('admin.datatable.ordersrailway') !!}'
                },
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'orderId', name: 'orderId'},
                    {data: 'user', name: 'user'},
                    {data: 'orderStatus', name: 'orderStatus'},
                    {data: 'fromIp', name: 'fromIp'},
                    {data: 'created_at', name: 'created_at'},
                   ],
            });

            /* END BASIC */

            // Apply the filter
            $("#datatable_fixed_column thead th input[type=text]").on('keyup change', function () {

                otable
                    .column($(this).parent().index() + ':visible')
                    .search(this.value)
                    .draw();

            });
            /* END COLUMN FILTER */

            $("#checkAll").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        })

    </script>
@endsection