<div itemscope itemtype="http://schema.org/Product" class="product-list__item">
    <div class="img">
        <img src="{{ url('/images/mobile-widget/uploads/goods_img/'.$product->preview.'.jpg') }}" alt="">
    </div>
    <a itemprop="name" href="{{ url($product->url) }}" class="title">{{ $product->name }}</a>
    <div class="price">{{ $product->price }} <span class="rub">у</span></div>

    <link itemprop="url" href="{{ url($product->url) }}">
    <link itemprop="image" href="{{ $product->original_image }}">
    <meta itemprop="sku" content="{{ $product->kod }}">
    <meta itemprop="description" content="{{ e(strip_tags($product->short_description)) }}">

    <div itemscope itemprop="offers" itemtype="http://schema.org/Offer">
        <meta itemprop="price" content="{{ str_replace(' ', '', $product->price) }}">
        <meta itemprop="priceCurrency" content="RUB">
        <link itemprop="availability" href="http://schema.org/InStock">
        <link itemprop="itemCondition" href="http://schema.org/NewCondition">
    </div>
</div>