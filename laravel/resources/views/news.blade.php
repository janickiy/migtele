@extends('layouts.template')

@section('content')


    @widget('breadcrumbs', ['type' => 'news'])

    <h1 class="main-title">{{ $news->name }}</h1>
    <div class="news-date">Дата: <strong>{{ $news->date }}</strong></div>

    <div class="main-content text-content">
        {!! $news->text2 !!}
    </div>


@endsection