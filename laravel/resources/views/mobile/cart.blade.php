@extends('mobile.layouts.template')

@section('content')

    @include('mobile.components.back_link', [
            'return_back' => true
    ])

    <div class="container">


        <div class="product-list__block">
            <div class="heading-3">Ваша корзина</div>

            @if(count($products))
                <ul>

                    @foreach($products as $product)
                        <li>
                            <div class="title">{{ $product->name }}</div>
                            <div class="info">

                                <div class="img"><img src="{{ url('/images/mobile-preview/uploads/goods_img/'.$product->preview.'.jpg') }}" alt=""></div>

                                <div class="count submit-form">
                                    <form action="{{ url(route('cart-change')) }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="count-minus"></div>
                                        <input type="text" name="quantity" placeholder="1" value="{{ $product->quantity }}">
                                        <div class="count-plus"></div>
                                    </form>
                                </div>

                                <div class="price-block">
                                    <div class="old-price">{{ $product->old_price }} Р</div>
                                    <div class="price">{{ $product->price }} Р</div>
                                    <div class="discount">Скидка {{ $product->cart_discount }} Р</div>
                                </div>

                                @include('mobile.components.product.stock-info')

                            </div>

                            <div class="description">{{ $product->short_description }}</div>

                            <div class="buttons">
                                <form action="{{ url('/cart/delete') }}" method="POST">
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    {{ csrf_field() }}
                                    <button class="trash"><span class="icon"></span>Удалить товар</button>
                                </form>
                                <a href="{{ url($product->url) }}" class="btn-back">Подробнее</a>
                            </div>

                        </li>
                    @endforeach

                </ul>
            @else
                <p>В корзине ничего нет</p>
            @endif

        </div>

        <div class="cart-promocode">
            @if(!$promocode)
                <form action="{{ route('promocode.apply') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="cart-promocode__title">Ввести промо код</div>

                    @include('form.input', [
                           'required' => true,
                           'field_name' => 'promocode',
                           'field_id' => 'cart-promocode',
                           'placeholder' => 'Промо код',
                           'tabindex' => 1,
                           'errors' => $errors->promocode
                       ])

                    <button type="submit" class="btn btn-primary cart-promocode__button">Применить</button>

                </form>
            @else

                <div>
                    Промокод <b>{{ $promocode->code }}</b> дает скидку в <b>{{ $promocode->reward }}%</b>
                    <form action="{{ route('promocode.remove') }}" method="POST" class="promocode-delete">
                        {{ csrf_field() }}
                        <button class="trash" type="submit"><span class="icon icon-trash"></span>Удалить промокод</button>
                    </form>
                </div>

            @endif

        </div>

        @if(count($products))
            <div class="cart-amount">
                <div class="heading-3">{{ \CartProducts::getTotalQuantity() }} товара в корзине</div>

                <div class="cart-amount__block">
                    <div class="discount">С учетом общей <span>скидки в {{ _price(\App\Model\Product::getAllCartDiscount()) }} <span class="rub">у</span></span></div>
                    <div class="total">Итого: <span class="value">{{ _price(\CartProducts::getTotal()) }} <span class="rub">у</span></span></div>
                </div>

            </div>
        @endif

        <div class="cart-buttons">
            <a href="/" class="btn-back">Продолжить покупки</a>

            @if(count($products))
                <a href="{{ url('/order') }}" class="btn">Оформить заказ</a>
            @endif

        </div>


    </div>




@endsection