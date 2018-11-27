@widget('category_menu')

<div class="sidebar-link">
    <a href="{{ url('/brands') }}" class="link"><span class="icon"></span><span class="text">Каталог по брендам</span></a>
</div>

<div class="sidebar-link sidebar-link__break-line">
    <a href="{{ url('/catalog_new') }}" class="link"><span class="icon icon-catalog_new"></span><span class="text">Новинки</span></a>
</div>

<div class="sidebar-link sidebar-link__break-line">
    <a href="{{ url('/sales') }}" class="link"><span class="icon icon-sale"></span><span class="text">Распродажа</span></a>
</div>

<div class="user-help">
    <div class="user-help__title">Пользователям</div>
    <ul class="user-help__links">
        <li><span class="icon icon-list-board"></span><a href="{{ url('/payment.htm') }}">Как купить товар?</a></li>
        <li><span class="icon icon-check"></span><a href="{{ url('/feedback/pay-products') }}">Обратная связь</a></li>
        <li><span class="icon icon-delivery"></span><a href="{{ url('/dostavka.htm') }}">Доставка</a></li>
        <li><span class="icon icon-payment"></span><a href="{{ url('/payment.htm#pay') }}">Оплатить заказ</a></li>
    </ul>

    <div class="user-help__info">
        <div class="user-help__info_label">Контактный телефон</div>
        <div class="user-help__info_value">
            <span class="icon icon-phone-cloud"></span>
            <span class="value">{{ _setting('phone') }}</span>
        </div>
        <div class="user-help__info_label user-help__info_label_mail">Почта</div>
        <div class="user-help__info_value">
            <span class="icon icon-mail"></span>
            <span class="value"><a href="mailto:{{ _setting('email_site') }}">{{ _setting('email_site') }}</a></span>
        </div>
    </div>
</div>

@widget('last_news')