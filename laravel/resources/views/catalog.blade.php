@extends('layouts.template')

@php($bodyAttr = ' itemscope itemtype="http://schema.org/WebPage"')

@section('content')

    @widget('breadcrumbs', $breadcrumbs_setting)

    @widget('sliders', ['sliders' => $sliders])

    @include('modules.category.title', ['title' => $site_title])

    @include('modules.category.text', ['text' => $text])

    @include('modules.category.sub_categories', [
        'category' => $category,
        'selected_sub_category' => $sub_category,
        'selected_vendor' => $vendor
    ])

    @include('modules.category.sub_categories2', [
        'category' => $category,
        'sub_category' => $sub_category,
        'sub_categories2' => $sub_categories2,
        'selected_sub_category2' => $sub_category2,
        'selected_vendor' => $vendor
    ])

    @widget('vendors', [
            'category' => $category,
            'sub_category' => $sub_category,
            'sub_category2' => $sub_category2,
            'vendors' => $vendors->unique(),
            'title' => 'Производители',
            'selected_vendor' => $vendor,
            'class' => 'vendor-selected'
    ])

    @include('modules.category.products', ['products' => $products])

    @include('modules.common.accordion', [
        'title' => $accordion_name,
        'warranty_text' => $warranty_text,
        'delivery_text' => $delivery_text
    ])

    @if($tags)
        @include('modules.common.tags', ['tags' => $tags])
    @elseif($interested_products)
        @include('modules.common.interesting', ['products' => $interested_products])
    @endif



@endsection