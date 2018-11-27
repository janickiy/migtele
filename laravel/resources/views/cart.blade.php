@extends('layouts.template')

@section('content')

    @php($min_order = (int)_setting('order_minimum_amount') > \CartProducts::getTotal() )

    @widget('breadcrumbs', ['type' => 'cart'])

    <div class="heading-2">Ваша корзина</div>

    @if(count($products))
        <div class="cart">
            <form action="{{ url('/cart/clear') }}" method="POST">
                {{ csrf_field() }}
                <button class="cart-remove__all" type="submit"><span class="icon icon-trash"></span>Удалить все товары</button>
            </form>

            <ul class="cart-products__list">

                @foreach($products as $product)
                    <li>
                        <div class="img"><img src="{{ url('/images/cart/uploads/goods_img/'.$product->preview.'.jpg') }}" alt=""></div>
                        <div class="info">
                            <a href="{{ url($product->url) }}" class="title">{{ $product->name }}</a>
                            <div class="description">{{ $product->short_description }}</div>
                        </div>
                        <div class="count">
                            @include('modules.product.count_input')
                            @include('modules.product.stock_status')
                        </div>
                        <div class="price">
                            <div class="cost">{{ $product->cart_price }}Р</div>
                            <div class="discount">Скидка {{_price($product->cart_discount)}}Р</div>
                            <form action="{{ url(route('cart-delete')) }}" method="POST">
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                {{ csrf_field() }}
                                <button class="trash" type="submit"><span class="icon icon-trash"></span>Удалить товар</button>
                            </form>
                        </div>
                    </li>
                @endforeach

            </ul>


            <div class="cart-promocode">
                @if(!$promocode)
                    <form action="{{ route('promocode.apply') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="cart-promocode__title">Ввести промо код</div>

                        <div class="cart-promocode__left">

                            @include('form.input', [
                               'required' => true,
                               'field_name' => 'promocode',
                               'field_id' => 'cart-promocode',
                               'placeholder' => 'Промо код',
                               'tabindex' => 1,
                               'errors' => $errors->promocode
                           ])

                        </div>

                        <div class="cart-promocode__right">
                            <button type="submit" class="btn btn-primary">Применить</button>
                        </div>

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


            <div class="cart-footer clr">
                <div class="cart-product__count">{{ \CartProducts::getTotalQuantity() }} товара в корзине</div>
                <div class="cart-product__discount">С учетом общей <b>скидки в {{ _price(\App\Model\Product::getAllCartDiscount()) }}Р</b></div>
                <div class="cart-product__amount">Итого: <span>{{ _price(\CartProducts::getTotal()) }}Р</span></div>
            </div>




            @if($min_order)
                @include('modules.minimum_order_text')
            @endif

            <div class="cart-buttons row cart-buttons-main">
                <a href="/" class="btn-back btn-back__main">Продолжить покупки</a>
                <a href="{{ url('/order') }}" class="btn btn-middle btn-primary btn-not-round {{ $min_order ? 'link-disable' : '' }}" >Оформить заказ</a>
                <a href="#quick-order" class="btn btn-primary btn-not-round {{ $min_order ? 'link-disable' : 'open-modal' }}">Купить в 1 клик</a>
            </div>

        </div>
    @else
        <p>В корзине ничего нет</p>

        <div class="cart-buttons row cart-buttons-main">
            <a href="/" class="btn-back btn-back__main">Продолжить покупки</a>
        </div>

    @endif

@endsection