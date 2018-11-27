<div class="product-list" style="border: 0; border-bottom: 1px solid #b2b2b2; font: inherit; font-size: 0; margin: 0; margin-top: 4px; padding: 0; padding-bottom: 19px; vertical-align: baseline;">

    @php($k = 1)
    @foreach($products as $product)
        @php($k++)
        <div class="product-list__item" style="border: 0; display: inline-block; font: inherit; font-size: 100%; margin: 0; margin-right: {{ $k == 4 ? '0' : '19px' }}; padding: 0; vertical-align: baseline; width: 200px;">
            <div class="title" style="border: 0; color: #2072b5; font: inherit; font-size: 18px; margin: 0; margin-bottom: 2px; padding: 0; vertical-align: baseline;">{{ $product->code }}</div>
            @if($product->preview)
                <div class="image" style="-webkit-background-size: cover; background-image: url({{ url('/images/email-product/uploads/goods_img/'.$product->preview.'.jpg') }}); background-position: center; background-size: cover; border: 0; font: inherit; font-size: 100%; height: 200px; margin: 0; padding: 0; vertical-align: baseline;"></div>
            @endif
            <div class="description" style="border: 0; color: #232323; font: inherit; font-size: 12px; line-height: 18px; margin: 0; margin-top: 12px; padding: 0; vertical-align: baseline;">{{ $product->name }}</div>
            <div class="price" style="border: 0; color: #232323; font: inherit; font-size: 14px; line-height: 14px; margin: 0; margin-top: 9px; padding: 0; vertical-align: baseline; white-space: nowrap;">Цена: {{ $product->price }} руб.</div>
            <a href="{{ url($product->url) }}" class="more" style="border: 0; color: #2072b5; display: block; font: inherit; font-size: 14px; line-height: 14px; margin: 0; margin-top: 12px; padding: 0; text-decoration: none; vertical-align: baseline;">Посмотреть на сайте</a>
        </div>
        <?php if($k == 4) { $k = 1; } ?>
    @endforeach

</div>