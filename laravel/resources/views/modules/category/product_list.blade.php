<ul class="products-list">
    @foreach($products as $product)
        <li itemscope itemtype="http://schema.org/Product">

            @include('modules.product.is_sale')
            @include('modules.product.is_new')

            @include('modules.product.wishlist_button')

            <div class="stock-status-wr">
                @include('modules.product.stock_status')
            </div>

            <div class="img">
                <a itemprop="url" href="{{ url($product->url) }}">
                    <img itemprop="image" src="{{ url('/images/preview/uploads/goods_img/'.$product->preview.'.jpg') }}" alt="">
                </a>
            </div>
            <div class="title"><a itemprop="name" href="{{ url($product->url) }}">{{ $product->name }}</a></div>
            <div itemprop="description" class="description">{{ $product->short_description }}</div>
            <div class="old-price">{{ $product->old_price }} Р</div>
            <div class="price">{{ $product->price }} Р</div>
            <div class="discount">Сэкономь <b>{{ $product->economy_price }} Р</b></div>
            <button class="add-cart" data-id="{{ $product->id }}"><span class="icon icon-cart"></span>В корзину</button>

            <meta itemprop="sku" content="{{ $product->kod }}">
            <span itemscope itemprop="offers" itemtype="http://schema.org/Offer">
                <meta itemprop="price" content="{{ str_replace(' ', '', $product->price) }}">
                <meta itemprop="priceCurrency" content="RUB">
                <link itemprop="availability" href="http://schema.org/InStock">
                <link itemprop="itemCondition" href="http://schema.org/NewCondition">
            </span>

        </li>
    @endforeach
</ul>