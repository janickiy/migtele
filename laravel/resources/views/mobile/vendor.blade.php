@extends('mobile.layouts.template')

@section('title', $vendor->title)
@section('description', $vendor->description)
@section('keywords', $vendor->keywords)

@section('content')

    @include('mobile.components.back_link', [
            'name' => 'Каталог брендов',
            'url' => '/brands'
    ])

    <div class="container">

        <div class="heading-1">{{$vendor->name }}</div>


        @foreach($vendor->categories->unique() as $category)
            <div class="heading-3 category-list__title">{{ $category->name }}</div>

            <div class="category-list">
                {{-- @include('mobile.components.item_list', ['items' => $category->sub_categories->unique(), 'category' => $category, 'vendor' => $vendor]) --}}
                @include('mobile.components.item_list', ['items' => $vendor->sub_categories()->where('cattmr.id_cattype', $category->id)->get(), 'category' => $category, 'vendor' => $vendor])
            </div>
        @endforeach

    </div>

    @widget('popular_products', ['is_mobile' => true, 'product_category_ids' => $vendor->getProductCategoryIds()])


    @include('mobile.components.content', [
        'title' => $vendor->name,
        'text' => $vendor->text

    ])


@endsection