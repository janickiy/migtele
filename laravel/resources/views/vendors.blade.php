@extends('layouts.template')

@php($bodyAttr = ' itemscope itemtype="http://schema.org/WebPage"')

@section('content')


    @widget('breadcrumbs', ['type' => 'vendors'])

    <h1 itemprop="name" class="heading-2 heading-2__manufacture">Производители</h1>

    <div class="vendor-alphabet">
        @foreach(range('A', 'Z') as $char)
            <a class="{{ request('char') == $char ? 'selected' : '' }}" href="{{ request()->fullUrlWithQuery(["char"=>$char]) }}">{{ $char }}</a>
        @endforeach
    </div>

    @if(count($vendors))
        <div class="product-vendor__list product-vendor__list_disable-spoiler">
            @foreach($vendors as $vendor)
                <a href="{{ $vendor->getUrl() }}" class="product-vendor__item">
                    <div class="img"><img src="{{ $vendor->img }}" alt=""></div>
                    <div class="title">{{ $vendor->name }}</div>
                </a>
            @endforeach
        </div>
    @else
        <br>
        <br>
        <p>Производители не найдены</p>
        <br>
        <br>
    @endif

    @widget('advantages')



@endsection