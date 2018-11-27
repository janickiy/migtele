@extends('layouts.template')

@php($bodyAttr = ' itemscope itemtype="http://schema.org/WebPage"')

@section('content')

    @widget('breadcrumbs', ['type' => 'page', 'element' => $page])

    <h1 itemprop="name" class="page-title">{{ $page->name }}</h1>

    @if($page->banner)
        <div class="second-slider">
            <div><img src="{{ url($page->banner) }}" alt=""></div>
        </div>
    @endif

    @widget('page_list', ['active_page_id' => $page->id])

    <div itemprop="text" class="page-content text-content">
        {!! $page->text !!}
    </div>

@endsection