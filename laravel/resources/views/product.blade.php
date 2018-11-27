@extends('layouts.template')

@section('content')

    @widget('breadcrumbs', ['type' => 'product', 'element' => $product])

<span itemscope itemtype="http://schema.org/Product">

    <h1 itemprop="name" class="product-title">{{ $product->name }}</h1>
    <div class="product-code">Код товара: <b itemprop="sku">{{ $product->kod }}</b></div>
    <div class="product-description__short text-content">{!! $product->text1 !!}</div>

    <div class="product clr">
        @if(count($product->images))
            <div class="product-images">
                <a href="#" data-iziModal-open="#gallery-modal-0" class="product-images__single border-shadow">
                    @include('modules.product.is_sale')
                    @include('modules.product.is_new')
                    <img itemprop="image" src="{{ $product->images[0] }}" alt="">
                </a>
                <div class="product-images__previews horizontal-scroll">
                    @foreach($product->images as $i=>$image)
                        <a href="#" data-img="{{ $image }}" data-id="{{ $i }}" class="product-images__preview">
                            <img src="{{ $image }}" alt="">
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <div style="display: none">
            @foreach($product->images as $i=>$image)
                <div id="gallery-modal-{{ $i }}" class="gallery-modal">
                    <div class="gallery-modal__item">
                        <img src="{{ $image }}" alt="">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="product-info border-shadow">

            @include('modules.product.wishlist_button')

            <div class="product-info__price clr">
                <div class="title">Цена:</div>
                <div class="prices">
                    <div class="old_price">{{ $product->old_price }} Р</div>
                    <div class="price">{{ $product->price }} Р</div>

                    <div class="view-discount">
                        <a href="#">Ваша скидка {{ $product->price_markup }}%</a>
                        <div class="view-discount__list">
                            <ul>
                                <li>От 1 штуки — &nbsp;<span>{{ $product->price_markup }}%</span></li>
                                @foreach($product->vendor->discounts as $discount)
                                    <li>От {{ $discount->quantity }} штук — &nbsp;<span>{{ $product->price_markup + $discount->value }}%</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="discount">Экономия <div>{{ $product->economy_price }} Р</div></div>
            </div>

            <div class="product-info__stock clr">
                <div class="stock">
                    <div class="title"><span class="icon icon-pin"></span>Наличие:</div>
                    <div class="value">Москва
                        <ul class="stock-count">
                            @if($product->nalich)
                                <li></li>
                                <li></li>
                                <li></li>
                            @else
                                <li class="empty"></li>
                                <li class="empty"></li>
                                <li class="empty"></li>
                            @endif
                            <li class="empty"></li>
                            <li class="empty"></li>
                        </ul>
                    </div>
                </div>
                <div class="stock">
                    <div class="title">Срок поставки:</div>
                    <div class="value">{{ $product->nalich ? '1-3 рабочих дня' : 'под заказ' }}</div>
                </div>
            </div>

            <dl class="product-info__list">
                <dt><span class="icon icon-tag"></span>Цена диллер:</dt>
                <dd><a href="#dealer-form" class="open-modal" data-product_id="{{ $product->id }}">По запросу</a></dd>
                <dt><span class="icon icon-method-delivery"></span>Способы доставки:</dt>
                <dd><a href="{{ url('/dostavka.htm') }}">Доставка РФ, Самовывоз</a></dd>
                <dt><span class="icon icon-card"></span>Способы оплаты:</dt>
                <dd><a href="{{ url('/payment.htm') }}">Любой вид платежа</a></dd>
                <dt><span class="icon icon-garanty"></span>Гарантия:</dt>
                <dd><a href="{{ url('/warranty.htm') }}">12 месяцев</a></dd>
            </dl>

            <div class="product-categories">
                @if($product->vendor)
                    <a href="{{ url($product->vendor_url) }}">{{ $product->vendor->name }}</a>
                @endif
                @if($product->sub_category2)
                    <a href="{{ url($product->sub_category2_url) }}">{{ $product->sub_category2->name }}</a>
                @elseif($product->sub_category)
                    <a href="{{ url($product->sub_category_url) }}">{{ $product->sub_category->name }}</a>
                @endif
            </div>

            <div class="product-buttons">
                <a href="#" data-id="{{ $product->id }}" class="add-cart btn btn-primary btn-not-round">Купить</a>
                <a href="#" data-id="{{ $product->id }}" class="quick-order btn btn-primary btn-not-round">Купить в 1 клик</a>
            </div>

        </div>

    </div>

    <div class="product-description">
        <h2 class="heading-2">Описание  {{ $product->name }}</h2>
        <div itemprop="description" class="content text-content">
            {!! $product->text2 !!}
        </div>
    </div>

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
</span>

    @include('modules.common.accordion', [
        'title' => $product->name,
        'warranty_text' => $product->warranty_text,
        'delivery_text' => $product->delivery_text
    ])

    @widget('related_products', ['product_id' => $product->id])

    @include('modules.common.interesting', ['products' => $product->interested_products])



@endsection