@if(count($vendors))
    <div id="product-vendor">

        <div class="heading-1">{{ $config['title'] }}</div>

        <div class="product-vendor__list {{ $config['class'] }}">
            @foreach($vendors as $vendor)
                @if($config['selected_vendor'] && $config['selected_vendor']->id == $vendor->id)
                    <div class="product-vendor__item">
                        <a href="{{ $config['sub_category'] ?
                        ($config['sub_category2'] ?
                        url($config['category']->getUrlSubcategory2($config['sub_category'], $config['sub_category2']))
                        :
                        url($config['category']->getUrlWithSubcategory($config['sub_category']))
                        )
                           :
                          url($config['category']->url)
                          }}" class="delete"></a>
                @else
                    <a href="{{ url($vendor->getUrl($config['category'], $config['sub_category'], $config['sub_category2'])) }}" class="product-vendor__item">
                @endif

                    <div class="img"><img src="{{ url($vendor->img) }}" alt=""></div>
                    <div class="title">{{ $vendor->name }}</div>

                @if($config['selected_vendor'] && $config['selected_vendor']->id == $vendor->id)
                    </div>
                @else
                    </a>
                @endif
            @endforeach
        </div>

        <div class="show-more" id="vendor-list-show-more"><a href="#">Показать все<span class="icon icon-arrow-down"></span></a></div>

    </div>
@endif