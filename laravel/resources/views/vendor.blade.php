@extends('layouts.template')

@php($bodyAttr = ' itemscope itemtype="http://schema.org/WebPage"')

@section('content')


    @widget('breadcrumbs', ['type' => 'vendor', 'element' => $vendor])


    <h1 itemprop="name" class="vendor-title">{{ $vendor->name }}</h1>

    @include('modules.category.text', ['text' => $vendor->text])

    @foreach($vendor->categories->unique() as $category)
        <div class="categories">
            <div class="heading-2">{{ $category->name }}</div>

            <div class="categories-list">
                @foreach($vendor->sub_categories()->where('cattmr.id_cattype', $category->id)->get() as $sub_category)
                    <a href="{{ url($category->getUrlWithVendorAndSubcategory($vendor, $sub_category)) }}">{{ $sub_category->name }}</a>
                @endforeach
            </div>
        </div>
    @endforeach


    @widget('vendor_popular_products', ['vendor' => $vendor])

    @widget('related_vendors', ['vendor' => $vendor])

    @include('modules.common.accordion', [
        'title' => $vendor->name,
        'warranty_text' => $vendor->warranty_text,
        'delivery_text' => $vendor->delivery_text
    ])


    @widget('advantages')



@endsection