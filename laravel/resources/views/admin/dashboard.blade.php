@extends('layouts.admin')

@section('title', $title)

@section('css')

    <style>
        .exportExcel {
            padding: 5px;
            border: 1px solid grey;
            margin: 5px;
            cursor: pointer;
        }
    </style>

@endsection

@section('content')

    @if (isset($title))<h2>{!! $title !!}</h2>@endif

    @include('layouts.admin_common.notifications')

    <div class="row-fluid">

        <div class="col">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="false">

                <!-- widget div-->
                <div>

                    <div class="table-responsive">

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


    </script>


@endsection