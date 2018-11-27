@extends('mobile.layouts.template')


@section('content')

    @include('mobile.components.back_link', [
            'return_back' => true
    ])

    <div class="container">

        <div class="product-list__block">
            <div class="heading-1">Просмотренный товар</div>

            @if(count($products))
                @include('mobile.components.products')
            @else
                <p style="margin: 20px">Вы еще не посещали страниц с товаром</p>
            @endif

        </div>

    </div>




@endsection