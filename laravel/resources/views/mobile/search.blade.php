@extends('mobile.layouts.template')

@section('content')

    @include('mobile.components.back_link', [
            'name' => 'Главная',
            'url' => '/'
    ])

    <div class="container">

        <div class="product-list__block">
            <div class="heading-1">Поиск</div>

            @include('mobile.components.products')


        </div>

    </div>




@endsection