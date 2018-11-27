@extends('layouts.template')

@section('content')


    @widget('breadcrumbs', ['type' => 'sitemap'])

    <h1 class="main-title">Карта сайта</h1>

    <ul class="sitemap">
        @foreach($pages as $page)
            @continue(!$page->link)
            <li><a href="{{ url($page->link) }}">{{ $page->name }}</a></li>
        @endforeach

        <li class="title">Товары</li>
        
        @foreach($categories as $category)
            <li>
                <a href="{{ url($category->url) }}">{{ $category->name }}</a>
                @if(count($category->vendors))
                <ul>
                    @foreach($category->vendors->unique() as $vendor)
                        <li>
                            <a href="{{ url($category->getUrlWithVendor($vendor)) }}">{{ $vendor->name }}</a>
                            <ul>
                                @foreach($vendor->sub_categories->unique() as $sub_category)
                                    <li>
                                        <a href="{{ url($category->getUrlWithVendorAndSubcategory($vendor, $sub_category)) }}">{{ $sub_category->name }}</a>

                                        <ul>
                                            @foreach($sub_category->sub_categories2($category->id)->get() as $sub_category2)
                                                <li><a href="{{ url($category->getUrlSubcategory2($sub_category, $sub_category2, $vendor)) }}">{{ $sub_category2->name }}</a></li>
                                            @endforeach
                                        </ul>

                                    </li>



                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
                @endif
            </li>
        @endforeach
    </ul>

    <div id="our-advantages__bookmarks">
        @widget('advantages')
    </div>


@endsection