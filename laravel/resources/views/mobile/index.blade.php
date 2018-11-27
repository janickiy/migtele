@extends('mobile.layouts.template')

@section('before-header')
    @include('widgets.toolbar_promocode')
@endsection

@section('content')

    <div class="container">
        <div class="heading-1">Главная</div>
    </div>

    @widget('new_products', ['is_mobile' => true])

    @widget('category_list', ['is_mobile' => true])

    @widget('vendors', ['is_mobile' => true])

    @widget('advantages', ['is_mobile' => true])

@endsection