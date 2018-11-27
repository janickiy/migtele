<nav id="menu" class="slideout-menu slideout-menu-left">
    <ul>
        <li>
            <a href="{{ url('/') }}"><span class="img-icon img-icon-list"></span>Каталог товаров</a>
        </li>
        <li>
            <a href="{{ url('/brands') }}"><span class="img-icon img-icon-block"></span>Каталог брендов</a>
        </li>

        <li>
            <a href="{{ url('/cart') }}"><span class="img-icon img-icon-cart"></span>Корзина<span class="badge">{{ \CartProducts::getTotalQuantity() }}</span></a>
        </li>

        <li>
            <a href="{{ url('/product-views') }}"><span class="img-icon img-icon-visit"></span>Просмотрено товаров<span class="badge">{{\ViewProducts::count()}}</span></a>
        </li>

        <li>
            @if(Auth::check())
                <a href="{{ url('/profile') }}"><span class="img-icon img-icon-login"></span>Личный кабинет</a>
            @else
                <a href="{{ url('/login') }}"><span class="img-icon img-icon-login"></span>Вход/Регистрация</a>
            @endif
        </li>

        <li>
            <a href="/warranty.htm"><span class="img-icon img-icon-garanty"></span>Гарантия</a>
        </li>

        <li>
            <a href="/dostavka.htm"><span class="img-icon img-icon-delivery"></span>Доставка</a>
        </li>

        <li>
            <a href="/contacty.htm"><span class="img-icon img-icon-contact"></span>Контакты</a>
        </li>

        <li>
            <a href="tel:{{ _setting('phone') }}"><span class="img-icon img-icon-phone"></span>{{ _setting('phone') }}</a>
        </li>

        <li>
            <a href="mailto:{{ _setting('email_site') }}"><span class="img-icon img-icon-email"></span>{{ _setting('email_site') }}</a>
        </li>

        <li>
            <a href="/goToDesktopVersion"><span class="img-icon img-icon-full"></span>Полная версия сайта</a>
        </li>

    </ul>
</nav>