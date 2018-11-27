@extends('layouts.template')

@section('before-header')
    @include('widgets.toolbar_promocode')
@endsection

@php($bodyAttr = ' itemscope itemtype="http://schema.org/WebPage"')

@section('content')

    @widget('sliders', ['is_homepage' => true])

    @widget('new_products', ['microdata' => true])

    @widget('popular_products', ['microdata' => true])

    @widget('advantages')

    @widget('vendors')

    @if($page)
        <div class="content">
            <div itemprop="name" class="heading-1">{{ $page->name }}</div>
            <div itemprop="text" class="text text-content">
                {!! $page->text !!}
            </div>
        </div>
    @endif
@endsection