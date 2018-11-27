<footer>
    <div class="container footer-line">
        <div class="footer-search">
            @include('modules.search_form', ['button_text' => 'Найти'])
        </div>
        <a href="#" class="scroll-top"></a>
    </div>

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="left-side">
                    <a href="/" class="footer-logo"></a>
                    @include('modules.counters')
                </div>
                <div class="right-side">

                    <div class="footer-menu">
                        @widget('menu', ['position' => 'bot'])
                    </div>

                    <div class="footer-contact">
                        <div class="footer-contact__left">
                            <div>Телефон:</div>
                            <div>Почта:</div>
                        </div>
                        <div class="footer-contact__right">
                            <div>{{ _setting('phone') }} <span class="schedules">{{ _setting('work_time') }}</span></div>
                            <div><a href="mailto:{{ _setting('email_site') }}">{{ _setting('email_site') }}</a></div>
                        </div>
                    </div>

                    <div class="footer-social">
                        <div class="title">Присоединяйтесь к нам</div>
                        <div class="links">
                            <a href="{{ _setting('social-link-facebook') }}" target="_blank"  class="social-link-facebook"><span class="icon icon-facebook"></span></a>
                            <a href="{{ _setting('social-link-vk') }}" target="_blank" class="social-link-vk"><span class="icon icon-vk"></span></a>
                            <a href="{{ _setting('social-link-google-plus') }}" target="_blank" class="social-link-google-plus"><span class="icon icon-google-plus"></span></a>
                        </div>
                    </div>

                    <div class="footer-copyright">Вся информация на сайте - собственность интернет-магазина migtele.ru</div>

                    <div class="footer-payments">
                        <img src="/static/desktop/img/payments/visa.png" alt="Visa">
                        <img src="/static/desktop/img/payments/mastercard.png" alt="Mastercard">
                        <img src="/static/desktop/img/payments/qiwi.png" alt="Qiwi">
                        <img src="/static/desktop/img/payments/webmoney.png" alt="Webmoney">
                        <img src="/static/desktop/img/payments/yad.png" alt="Яндекс Деньги">

                    </div>

                </div>
            </div>

        </div>
    </div>

</footer>

<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <a href="#feedback-form" class="btn btn-primary open-modal" rel="modal:open"><span class="icon icon-mail"></span>Обратная связь</a>

            <div class="footer-toolbar">
                <a href="#feedback-form" class="toolbar-link-help open-modal">
                    <div class="icon icon-help"></div>
                    <div class="text">Помощь</div>
                </a>
                <a href="{{ url('/product-views') }}" class="toolbar-link-views">
                    <div class="icon icon-eye"></div>
                    <div class="text">Просмотрено</div>
                    <div class="counter">{{ViewProducts::count()}}</div>
                </a>
                <a href="{{ url('/wishlist') }}" class="toolbar-link-bookmarks">
                    <div class="icon icon-bookmark"></div>
                    <div class="text">Закладки</div>
                    <div class="counter">{{WishlistProducts::count()}}</div>
                </a>
                @widget('cart', ['theme' => 'footer'])
            </div>

            <a href="{{ url('/order') }}" class="btn btn-primary" style="float: right;">Оформить заказ</a>
        </div>
    </div>

</div>