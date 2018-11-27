@extends('layouts.template')

@php($bodyAttr = ' itemscope itemtype="http://schema.org/WebPage"')

@section('content')

    @widget('breadcrumbs', ['type'=>'category', 'element' => $category])

    @widget('sliders', ['sliders' => $category->sliders])

    @include('modules.category.title', ['title' => $category->name])

    @include('modules.category.text', ['text' => $category->text])


    @if($category->sub_categories)
        <div class="categories">
            <div class="heading-2">Категории</div>

            <div class="categories-list">
                @foreach($category->sub_categories->unique() as $sub_category)
                    <a href="{{ url($category->getUrlWithSubcategory($sub_category)) }}">{{ $sub_category->name }}</a>
                @endforeach
            </div>

        </div>
    @endif


    @widget('vendors', [
            'category' => $category,
            'vendors' => $category->vendors()->orderBy('name')->get()->unique(),
            'title' => 'Производители',
            'filtered' => true,
            'class' => 'vendor-selected'
    ])


    @include('modules.category.products', ['products' => $products])

    @include('modules.common.accordion', [
        'title' => $category->name,
        'warranty_text' => $category->warranty_text,
        'delivery_text' => $category->delivery_text
    ])

    @include('modules.common.tags', ['tags' => $category->tags])


@endsection