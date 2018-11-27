@extends('layouts.template')


@section('content')

    @widget('breadcrumbs', ['type' => 'feedback'])

    <h1 class="page-title">Обратная связь</h1>

    @include('components.feedback.index')

@endsection