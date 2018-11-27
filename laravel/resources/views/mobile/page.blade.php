@extends('mobile.layouts.template')

@section('title', $page->title)
@section('description', $page->description)
@section('keywords', $page->keywords)

@section('content')

    @include('mobile.components.back_link', [
            'name' => 'Главная',
            'url' => '/'
    ])

    <div class="container">
        <div itemprop="name" class="heading-1">{{ $page->name }}</div>

        <div itemprop="text" class="page-content">
            {!! $page->text !!}
        </div>

    </div>

@endsection

@php ($itempropTitle = true)