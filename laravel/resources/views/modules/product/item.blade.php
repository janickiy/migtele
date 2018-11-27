@php($microdata = isset($microdata) ? $microdata : false)

<div {!! $microdata ? 'itemscope itemtype="http://schema.org/Product" ' : '' !!}class="product-list__item item">
    @include('modules.product.is_sale')
    @include('modules.product.is_new')

    <div class="img"><img src="/images/widget/uploads/goods_img/{{ $product->preview }}.jpg" alt=""></div>
    <div class="title"{!! $microdata ? ' itemprop="name"' : '' !!}>{{ $product->name }}</div>
    <div class="price">{{ $product->price }} Р</div>
    <a {!! $microdata ? 'itemprop="url"' : '' !!} href="{{ url($product->url) }}" class="more">Подробнее</a>

    @if($microdata)    
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
    @endif
</div>