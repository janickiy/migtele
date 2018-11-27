@extends('mobile.layouts.template')


@section('content')

    @include('mobile.components.back_link', [
            'name' => 'Каталог товаров',
            'url' => '/'
    ])

    <div class="container">

        <div class="vendor-list">
            @foreach($vendors as $vendor)
                <a href="{{ url($vendor->url) }}">
                    <div class="img"><img src="{{ $vendor->img }}" alt=""></div>
                    <div class="title">{{ $vendor->name }}</div>
                </a>
            @endforeach
        </div>

    </div>

@endsection