@extends('admin.layout')

@section('title', 'Подробности лога')

@section('css')


@endsection

@section('content')

    @if (isset($title))<h2>{!! $title !!}</h2>@endif

    <div class="row-fluid">

        <div class="col">

            <p><a href="{{ URL::route('admin.logs.list') }}">назад</a></p>
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false">

                <div>
                <p>
                    <strong>ID сессии:</strong> {{ $log->session_id }} <br>
                    <strong>Пользователь:</strong> {{ isset($userLog->login) ? $userLog->login : '-' }} <br>
                    <strong>Реферер:</strong> {{ $log->referer ? $log->referer : '-' }} <br>
                    <strong>Путь:</strong> {{ $log->path ? $log->path : '-' }} <br>
                    <strong>Маршрут:</strong> {{ $log->route ? $log->route : '-'  }} <br>
                    <strong>Запрос:</strong>
                    @if ($log->request)

                        {!! \App\Helpers\StringHelpers::tree($log->request) !!}

                    @endif
                    <br>
                    <strong>Ответ:</strong>
                    @if ($log->response)

                        {!! \App\Helpers\StringHelpers::tree($log->response) !!}

                    @endif
                    <br>
                    <strong>External:</strong>
                    @if ($log->external)

                        {!! \App\Helpers\StringHelpers::tree($log->external) !!}

                    @endif
                    <br>
                    <strong>Запросы:</strong>
                    @if ($log->queries)

                        {!! \App\Helpers\StringHelpers::tree($log->queries) !!}

                    @endif
                </p>
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

        $(document).ready(function(){
            $('.tree-checkbox').treeview({
                collapsed: true,
                animated: 'medium',
                unique: false
            });
        });

    </script>

@endsection