<a href="{{ url('/cart') }}" class="toolbar-link-cart">
    <div class="icon icon-cart"></div>
    <div class="text">Корзина</div>
    <div class="counter">{{ $quantity }}</div>
    <div class="price">{!! $price ? $price.' Р' : 'Пока пусто' !!} </div>
</a>