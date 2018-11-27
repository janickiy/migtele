@if(count($products))
    <div id="product-popular">
        <div class="container">
            <div class="heading-3">Популярные товары</div>
        </div>

        <div class="product-list owl-carousel" data-slideout-ignore>

            @foreach($products as $product)
                @include('widgets.mobile.components.product_list_item')
            @endforeach

        </div>

    </div>
@endif