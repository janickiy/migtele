<div class="product-toolbar">
    <div class="product-toolbar__count">Найдено {{ $products->total() }} товаров в наличии</div>
    <div class="product-toolbar__price">
        <div class="title">Сортировать:</div>
        <form action="" method="GET" class="product-toolbar__price_input">
            <input type="text" name="from" placeholder="" value="{{ app('request')->input('from', $price_range['from']) }}">
            <div class="separator">–</div>
            <input type="text" name="to" placeholder="" value="{{ app('request')->input('to', $price_range['to']) }}">
            <div class="product-toolbar__slider" id="product-price-slider" data-start="{{ app('request')->input('from', $price_range['from']) }}" data-end="{{ app('request')->input('to', $price_range['to']) }}" data-min="{{ $price_range['from'] }}" data-max="{{ $price_range['to'] }}"></div>
        </form>
        <div class="prefix">Р</div>

    </div>
    <div class="product-toolbar__sorting">
        <a href="{{ url('/set-sort/popular_'.(isPopularDesc() ? 'asc' : 'desc')) }}"
           class="{{ isPopularAsc() || isPopularDesc() ? 'active' : '' }}">по популярности
            <span class="icon icon-sort-{{isPopularDesc() ? 'down' : 'up' }}"></span>
        </a>

        <a href="{{ url('/set-sort/price_'.(isPriceDesc() ? 'asc' : 'desc')) }}"
           class="{{ isPriceAsc() || isPriceDesc() ? 'active' : '' }}">по цене
            <span class="icon icon-sort-{{isPriceDesc() ? 'down' : 'up' }}"></span>
        </a>

    </div>
</div>