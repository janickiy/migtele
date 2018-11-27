@extends('mobile.layouts.template')

@section('title', $product->title)
@section('description', $product->description)
@section('keywords', $product->keywords)

@section('content')


    @include('mobile.components.back_link', [
            'name' => $product->sub_category->name,
            'url' => $product->category->getUrlWithSubCategory($product->sub_category)
    ])

   <div itemscope itemtype="http://schema.org/Product" class="product">

        <div class="container">
            <div itemprop="name" class="product-title heading-1">{{ $product->name }}</div>
            <div class="product-code">Код товара: <b itemprop="sku">{{ $product->kod }}</b></div>
        </div>

        @if(count($product->images))
            <meta itemprop="image" content="{{ $product->images[0] }}">
            <div class="product-images owl-carousel" data-slideout-ignore>
                @foreach($product->images as $image)
                    <div class="product-images__img"><img src="{{ url($image) }}" alt=""></div>
                @endforeach
            </div>
        @endif

        <div class="container">

            <div class="category-list">
                <a href="{{ url($product->vendor->url) }}">{{ $product->vendor->name }}</a>
                <a href="{{ url($product->category->getUrlWithSubCategory($product->sub_category)) }}">{{ $product->sub_category->name }}</a>
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
        </div>

        <div class="product-info__list">
            <div class="container">

                <ul>
                    <li>
                        <div class="key"><span class="icon icon-tag"></span>Цена диллер:</div>
                        <div class="value"><a href="#dealer-form" class="open-modal" data-product_id="{{ $product->id }}">По запросу</a></div>
                    </li>
                    <li>
                        <div class="key"><span class="icon icon-method-delivery"></span>Способы доставки</div>
                        <div class="value"><a href="{{ url('/dostavka.htm') }}">Доставка РФ, Самовывоз</a></div>
                    </li>
                    <li>
                        <div class="key"><span class="icon icon-card"></span>Способы оплаты:</div>
                        <div class="value"><a href="{{ url('/payment.htm') }}">Любой вид платежа</a></div>
                    </li>
                    <li>
                        <div class="key"><span class="icon icon-garanty"></span>Гарантия:</div>
                        <div class="value"><a href="{{ url('/warranty.htm') }}">12 месяцев</a></div>
                    </li>
                </ul>
            </div>
        </div>


        <div class="container">
            <form action="{{ url(route('cart-add')) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="count">
                    <div class="count-minus"></div>
                    <input type="text" value="1" placeholder="1" name="quantity">
                    <div class="count-plus"></div>
                </div>

                <div class="product-info__price">
                    <div class="title">Цена:</div>
                    <div class="prices">
                        <div class="old_price">{{ $product->old_price }} <span class="rub">у</span></div>
                        <div class="price">{{ $product->price }} <span class="rub">у</span></div>
                    </div>
                    <div class="discount">Экономия <div>{{ $product->economy_price }} <span class="rub">у</span></div></div>
                </div>

                <button class="product-button btn">Купить</button>

            </form>


            @include('mobile.components.content', [
                'title' => 'Полное описание',
                'text' => $product->text2
            ])

        </div>

        <link itemprop="url" href="{{ url($product->url) }}">
        <meta itemprop="description" content="{{ $product->short_description }}">
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

    </div>

    @widget('related_products', ['product_id' => $product->id, 'is_mobile' => true])

@endsection

@include('modals.dealer')