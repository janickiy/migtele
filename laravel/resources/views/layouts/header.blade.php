<header>

    <div class="container">

        <div class="row">

            <div class="left-side">
                <a href="/" class="logo"></a>
            </div>

            <div class="right-side">

                <div class="header-menu">
                    @widget('menu', ['position' => 'top'])
                </div>

                <div class="header-info">
                    <div class="header-info__left">
                        <div class="header-info__phone">
                            {{ _setting('phone') }}
                            <a href="{{ url('/feedback/pay-products') }}">Обратная связь</a>
                        </div>
                        <div class="header-info__schedules">
                            <span class="icon icon-time"></span>{{ _setting('work_time') }}</div>
                    </div>
                    <div class="header-info__right header-info__links">
                        <a href="#callback-form" class="open-modal" rel="modal:open" ><div class="icon icon-phone"></div><div class="text">Заказать звонок</div></a>
                        <a href="mailto:{{ _setting('email_site') }}"><div class="icon icon-mail"></div><div class="text">{{ _setting('email_site') }}</div></a>
                        <a href="skype:{{ _setting('skype') }}"><div class="icon icon-skype"></div><div class="text">Звонок онлайн</div></a>
                        <a><div class="icon icon-icq"></div><div class="text">{{ _setting('icq') }}</div></a>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="header-line">
        <div class="container">
            <div class="row">
                <div class="left-side">
                    <div class="sidebar-menu__title"><span class="icon icon-hamburger"></span>Каталог товаров</div>
                </div>
                <div class="right-side">
                    @include('modules.search_form', ['class' => 'header-line__search'])
                    <div class="header-line__menu">
                        @include('modules.profile.header_button')
                        @widget('cart')
                    </div>
                </div>
            </div>
        </div>
    </div>


</header>