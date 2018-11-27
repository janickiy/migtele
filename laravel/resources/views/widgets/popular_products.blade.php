@if(count($products))
    <div id="product-popular">
        <div class="heading-1">Самые популярные</div>
        <div class="product-list horizontal-scroll"  id="product-popular__{{ str_random(10) }}" data-next="{{ url('/popular-products?page=2') }}">
            @foreach($products as $product)
                @include('modules.product.item', ['microdata' => $config['microdata']])
            @endforeach
        </div>
    </div>
@endif