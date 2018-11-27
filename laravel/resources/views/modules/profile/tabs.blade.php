<div class="tabs">
    <a href="{{ url('/profile/orders') }}" class="{{ $selected == 1 ? 'active' : '' }}">Заказы</a>
    <a href="{{ url('/wishlist') }}" class="{{ $selected == 3 ? 'active' : '' }}">Закладки</a>
    <a href="{{ url('/product-views') }}" class="{{ $selected == 4 ? 'active' : '' }}">Просмотрено</a>
    <a href="{{ url('/profile') }}" class="{{ $selected == 2 ? 'active' : '' }}">Настройки</a>
    <a href="{{ url('/feedback/pay-products') }}" class="{{ $selected == 5 ? 'active' : '' }}">Мои обращения</a>
</div>