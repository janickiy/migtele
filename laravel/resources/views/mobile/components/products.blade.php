<div class="sort-buttons">

    <a href="{{ url('/set-sort/popular_'.(isPopularDesc() ? 'asc' : 'desc')) }}"
       class="{{ isPopularAsc() || isPopularDesc() ? 'active '.(isPopularDesc() ? 'sort-down' : 'sort-up') : '' }}">по популярности
    </a>

    <a href="{{ url('/set-sort/price_'.(isPriceDesc() ? 'asc' : 'desc')) }}"
       class="{{ isPriceAsc() || isPriceDesc() ? 'active '.(isPriceDesc() ? 'sort-down' : 'sort-up') : '' }}"> по цене
    </a>

</div>

<ul>
    @foreach($products as $product)
        <li itemscope itemtype="http://schema.org/Product">
            <form action="{{ url(route('cart-add')) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div itemprop="name" class="title">{{ $product->name }}</div>
                <div class="info">
                    <div class="img"><img src="{{ url('/images/mobile-preview/uploads/goods_img/'.$product->preview.'.jpg') }}" alt=""></div>

                    <div class="count">
                        <div class="count-minus"></div>
                        <input type="text" name="quantity" value="1" placeholder="1">
                        <div class="count-plus"></div>
                    </div>
                    <div class="price-block">
                        <div class="old-price">{{ $product->old_price }} Р</div>
                        <div class="price">{{ $product->price }} Р</div>
                        <div class="discount">Скидка {{ $product->economy_price }} Р</div>
                    </div>

                    @include('mobile.components.product.stock-info')

                </div>
                <div itemprop="description" class="description">{{ $product->short_description }}</div>

                <div class="buttons">
                    <a href="{{ url($product->url) }}" class="btn-back">Подробнее</a>
                    <button class="btn">Корзина</button>
                </div>

            </form>

            <link itemprop="image" href="{{ $product->images[0] }}">
            <link itemprop="url" href="{{ url($product->url) }}">
            <span itemscope itemprop="offers" itemtype="http://schema.org/Offer">
                <meta itemprop="price" content="{{ str_replace(' ', '', $product->price) }}">
                <meta itemprop="priceCurrency" content="RUB">
                <link itemprop="itemCondition" href="http://schema.org/NewCondition">
                @if ($product->nalich)
                    <link itemprop="availability" href="http://schema.org/InStock">
                @else
                    <link itemprop="availability" href="http://schema.org/OutOfStock">
                @endif
            </span>
        </li>
    @endforeach


</ul>
{{ $products->links('mobile.components.pagination') }}
