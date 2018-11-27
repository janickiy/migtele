<a href="{{ url('/cart') }}" class="header-line__menu_cart">
    <div class="icon icon-cart"></div>
    <div class="info">
        <div class="title">Корзина</div>
        <div class="description"><span class="total">{{ $price }}</span> Р</div>
    </div>
    <div class="badge-count">{{ $quantity }}</div>
</a>