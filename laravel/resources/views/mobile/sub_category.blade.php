@extends('mobile.layouts.template')

@section('title', $sub_category ? $sub_category->title : $vendor->title)
@section('description', $sub_category ? $sub_category->description : $vendor->description)
@section('keywords', $sub_category ? $sub_category->keywords : $vendor->keywords)

@section('content')

    @include('mobile.components.back_link', [
            'name' => $category->name,
            'url' => $category->url
    ])

    <div class="container">

        <div class="product-list__block product-list__block_subcategory">
            <div class="heading-1">{{ $sub_category ? $sub_category->name : $vendor->name }}</div>

            @include('mobile.components.sub_categories', [
                'category' => $category,
                'selected_sub_category' => $sub_category,
                'selected_vendor' => $vendor
            ])


            @include('mobile.components.products')


        </div>

    </div>




@endsection