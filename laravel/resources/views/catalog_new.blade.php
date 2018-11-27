@extends('layouts.template')

@php($bodyAttr = ' itemscope itemtype="http://schema.org/WebPage"')

@section('content')

    @widget('breadcrumbs', ['type'=> 'catalog_new'])

    @include('modules.category.title', ['title' => 'Новинки'])

    @include('modules.category.products', ['products' => $products])

    @widget('advantages')

@endsection