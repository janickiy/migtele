<div id="vendor-popular-product">

    <h2 class="heading-2">Самые популярные товары {{ $config['vendor']->name }}</h2>
    <div class="product-list horizontal-scroll" id="vendor-popular-product-list" data-next="{{ $url }}">

        @foreach($products as $product)
            @include('modules.product.item')
        @endforeach

    </div>

</div>