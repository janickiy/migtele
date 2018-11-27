@extends('mobile.layouts.template')

@section('title', $product_category->title)
@section('description', $product_category->description)
@section('keywords', $product_category->keywords)

@section('content')

    @include('mobile.components.back_link', [
            'name' => $product_category->vendor->name,
            'url' => $product_category->vendor->url
    ])

    <div class="container">

        <div class="product-list__block">
            <div class="heading-1">{{ $product_category->sub_category->name }} {{ $product_category->vendor->name }}</div>


            @include('mobile.components.products')


        </div>

    </div>




@endsection