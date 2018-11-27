<div class="main-menu">
    <ul>

        @foreach($categories as $category)
            <li>
                <a href="{{ url($category->url) }}">{{ $category->name }}</a>

                @php($sub_categories = $category->sub_categories->unique())

                @if( count($sub_categories) )


                    @php($chunk_sub_categories = $sub_categories->chunk(ceil(count($sub_categories)/3)))

                    <div class="main-menu__sub {{ count($chunk_sub_categories) >= 3 ? "three-column" : (count($chunk_sub_categories) == 2 ? "two-column" : "")  }}">
                        <div class="title">{{ $category->name }}</div>
                        <div class="main-menu__sub_row">
                            @foreach($chunk_sub_categories as $sub_categories)
                                <ul>
                                    @foreach($sub_categories as $sub_category)
                                        <li><a href="{{ url($category->getUrlWithSubcategory($sub_category)) }}">{{ $sub_category->name }}</a></li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </div>
                        @if($category->banner_img)
                            <div class="banner">
                                <div class="img" style="background-image: url({{ url($category->banner_img) }})"></div>
                                <a href="{{ $category->banner_url }}" class="more">Подробнее...</a>
                            </div>
                        @endif
                    </div>

                @endif

            </li>
        @endforeach

    </ul>
</div>