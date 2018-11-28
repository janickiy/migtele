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



@endsection

@section('js')

    <script type="text/javascript">




    </script>


@endsection