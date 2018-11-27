@if(count($products))
    <div id="product-new">
        <div class="heading-1">Новинки</div>
        <div class="product-list horizontal-scroll" id="new-product__{{ str_random(10) }}" data-next="{{ url('/new-products?page=2') }}">
            @foreach($products as $product)
                @include('modules.product.item', ['microdata' => $config['microdata']])
            @endforeach
        </div>
    </div>
@endif