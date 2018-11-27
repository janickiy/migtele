<div>
    <div class="modal-header">
        <div class="modal-title">@if(count($products)) Товар добавлен в корзину @else Товара нет @endif</div>
        <div class="modal-description">В вашей корзине {{ \CartProducts::getTotalQuantity() }} товара на сумму {{_price(\CartProducts::getTotal()) }}<span class="rub">у</span></div>
    </div>
    <div class="modal-cart">
        <ul class="cart-products__list">
            @foreach($products as $product)
                <li>
                    <div class="img"><img src="{{ url('/images/modal-cart/uploads/goods_img/'.$product->preview.'.jpg') }}" alt=""></div>
                    <div class="info">
                        <a href="{{ url($product->url) }}" class="title">{{ $product->name }}</a>
                        <div class="description">{{ $product->short_description }}</div>
                    </div>
                    <div class="control">
                        <div class="price">{{ $product->cart_price }} Р</div>
                        <div class="discount">Скидка {{$product->economy_price}} Р</div>
                        <div class="count">
                            @include('modules.product.count_input', ['is_modal' => true])
                        </div>
                        <form action="{{ url('/cart/delete') }}" method="POST">
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="is_modal" value="1">
                            <button class="trash" type="submit"><span class="icon icon-trash"></span>Удалить товар</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="cart-buttons row">
            <a href="#" rel="modal:close" class="btn-back">Продолжить покупки</a>
            @if(count($products))
                <a href="{{ url('/cart') }}" class="btn btn-primary btn-not-round">Перейти в корзину</a>
                <a href="{{ url('/order') }}" class="btn btn-primary btn-not-round">Оформить заказ</a>
            @endif
        </div>
    </div>
</div>