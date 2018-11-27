@extends('layouts.template')


@section('content')

    @widget('breadcrumbs', ['type'=> 'sales'])

    @include('modules.category.title', ['title' => 'Распродажа'])

    @include('modules.category.products', ['products' => $products])

    @widget('advantages')

@endsection