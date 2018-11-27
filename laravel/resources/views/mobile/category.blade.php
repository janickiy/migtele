@extends('mobile.layouts.template')

@section('title', $category->title)
@section('description', $category->description)
@section('keywords', $category->keywords)

@section('content')

    @include('mobile.components.back_link', [
            'name' => 'Главная',
            'url' => '/'
    ])

    <div class="container">
        <div class="heading-3 category-list__title">{{ $category->name }}</div>

        <div class="category-list">
            @include('mobile.components.item_list', ['items' => $category->sub_categories->unique(), 'category' => $category])
        </div>

    </div>



    <div class="container">
        <div class="heading-3 category-list__title">Производители</div>
        <div class="category-list">

            @include('mobile.components.item_list', ['items' => $category->vendors->unique(), 'category' => $category, 'is_vendor' => true])

        </div>
    </div>

    @widget('popular_products', ['is_mobile' => true, 'category_id' => $category->id])




@endsection