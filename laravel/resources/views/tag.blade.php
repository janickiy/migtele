@extends('layouts.template')

@php($bodyAttr = ' itemscope itemtype="http://schema.org/WebPage"')

@section('content')

    @widget('breadcrumbs', ['type'=>'tag'])

    {{--@widget('sliders', ['sliders' => $tag->sliders])--}}

    @include('modules.category.title', ['title' => $tag->name])

    @include('modules.category.text', ['text' => $tag->text])


    @include('modules.category.sub_categories', [
        'category' => $category,
        'selected_sub_category' => $sub_category,
        'selected_vendor' => ''
    ])


    @widget('vendors', [
            'category' => $category,
            'sub_category' => $sub_category,
            'vendors' => $vendors->unique(),
            'title' => 'Производители',
            'selected_vendor' => '',
            'class' => 'vendor-selected'
    ])



    @include('modules.category.products', ['products' => $products])


    @include('modules.common.accordion', [
       'title' => $tag->name,
       'warranty_text' => $tag->warranty_text,
       'delivery_text' => $tag->delivery_text
   ])

    @include('modules.common.interesting', ['products' => $sub_category ? $sub_category->interested_products : $category->interested_products])


@endsection