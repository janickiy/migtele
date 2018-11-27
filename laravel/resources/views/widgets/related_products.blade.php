@if(count($products))
    <div id="product-relative">
        <div class="heading-2">Похожие товары</div>

        <div class="product-list horizontal-scroll" id="product-relative__{{ str_random(10) }}" data-next="{{ url('/related-products/'.$config['product_id'].'?page=2') }}">

            @foreach($products as $product)
                @include('modules.product.item')
            @endforeach

        </div>
    </div>
@endif