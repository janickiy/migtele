@extends('layouts.template')

@php($bodyAttr = ' itemscope itemtype="http://schema.org/WebPage"')

@section('content')

    @widget('breadcrumbs', ['type' => 'page', 'element' => $page])

    <h1 itemprop="name" class="page-title">{{ $page->name }}</h1>

    <div class="page-select">
        @foreach(\App\Model\Pages::specials()->get() as $special_page)
            <a href="{{ $special_page->link }}" class="btn btn-primary {{ $special_page->link != $page->link ? 'active' : '' }}">{{ $special_page->name }}</a>
        @endforeach
    </div>


    <div itemprop="text" class="page-content text-content">
        {!! $page->text !!}
    </div>

@endsection