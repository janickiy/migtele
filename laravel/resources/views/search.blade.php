@extends('layouts.template')

@section('content')


    @widget('breadcrumbs', ['type' => 'search'])

    <h1 class="main-title">Поиск</h1>

    @if(count($vendors))

        <div class="heading-2 second-title">Найденные производители</div>

        <div class="product-vendor__list product-vendor__list_disable-spoiler">
            @foreach($vendors as $vendor)
                <a href="{{ url($vendor->getUrl()) }}" class="product-vendor__item">
                    <div class="img"><img src="{{ $vendor->img }}" alt=""></div>
                    <div class="title">{{ $vendor->name }}</div>
                </a>
            @endforeach
        </div>

    @endif

    @if(count($categories) || count($sub_categories_list) || count($cattmrs))
        <div class="categories">
            <div class="heading-2">Найденные категории</div>
            <div class="categories-list search-categories">

                @foreach($categories as $category)
                    <a href="{{ url($category->url) }}">{{ $category->name }}</a>
                @endforeach

                @foreach($sub_categories_list as $sub_category)
                    @continue(!$sub_category->url)
                    <a href="{{ url($sub_category->url) }}">{{ $sub_category->name }}</a>
                @endforeach

                @foreach($cattmrs as $cattmr)
                    @continue(!$cattmr->content_title)
                    <a href="{{ url($cattmr->url) }}">{{ $cattmr->content_title }}</a>
                @endforeach

            </div>
        </div>
    @endif

    @if(count($sub_categories))
        <div class="heading-2 second-title">Найденный товар</div>

        @include('modules.category.products_with_sub_categories')

        {{ $products->links('modules.pagination') }}
    @endif


    @if(!count($sub_categories) && !count($vendors) && !count($categories) && !count($sub_categories_list))

        <p style="margin: 20px">По Вашему запросу ничего не найдено</p>

    @endif

    <div id="our-advantages__bookmarks">
        @widget('advantages')
    </div>


@endsection