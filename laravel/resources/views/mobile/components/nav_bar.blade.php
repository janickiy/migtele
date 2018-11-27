<div class="container">
    <button class="toggle-button"></button>
    <a href="/" class="logo"></a>
    <a href="{{ url('/cart') }}" class="cart">
        <div class="icon icon-cart"></div>
        <div class="count">{{ \CartProducts::getTotalQuantity() }}</div>
    </a>
</div>