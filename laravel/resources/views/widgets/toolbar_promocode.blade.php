@if($promocode)
    <div class="toolbar-promocode__wr">
        <div class="toolbar-promocode">
            <div class="container">
                <div class="row">
                    <div class="toolbar-cell toolbar-reward">

                        <div class="toolbar-cell__front">
                            <div class="title"><img src="/static/desktop/img/icons/giftbox.png" alt="" height="14"></div>
                            <div class="amount">скидка {{ $promocode->reward }}%</div>
                            <div class="cell__footer">
                                <a href="#" class="toolbar-cell__link toolbar-cell__link__toggle"><img src="/static/desktop/img/icons/info.png" alt="" height="10"> Условия акции</a>
                            </div>
                        </div>

                        <div class="toolbar-cell__back">
                            <a href="#" class="toolbar-cell__close toolbar-cell__link__toggle"></a>
                            <div class="toolbar-cell__content">
                                - Действие купона распространяется заказы, оформленные через корзину интернет-магазина migtele.ru<br>
                                - Размер скидки по купону составляет  {{ $promocode->reward }}%<br>

                                Условия акции могут быть изменены по инициативе migtele.ru без предварительного уведомления.<br>
                            </div>
                        </div>
                    </div>

                    <div class="toolbar-cell toolbar-coupon">
                        <div class="toolbar-cell__front">
                            <div class="title">Купон на покупку</div>
                            <div class="toolbar-buttons">
                                <div class="toolbar-buttons__coupon">{{ $promocode->code }}</div>
                                <button class="toolbar-buttons__coupon_copy" data-clipboard-text="{{ $promocode->code }}"><span class="icon"></span><span class="txt">Копировать</span></button>
                                <button class="toolbar-buttons__vk_save_wall" data-url="{{ $promocode->url }}"><span class="icon"></span>Сохранить на стену</button>
                            </div>

                            <div class="cell__footer">
                                <a href="#" class="toolbar-cell__link toolbar-cell__link__toggle"><img src="/static/desktop/img/icons/question-sign.png" alt="" height="10"> Как воспользоваться</a>
                            </div>

                        </div>

                        <div class="toolbar-cell__back">
                            <a href="#" class="toolbar-cell__close toolbar-cell__link__toggle"></a>
                            <div class="toolbar-cell__content">Скопируй и вставь купон в поле для ввода купона во время оформления заказа</div>
                        </div>

                    </div>

                    <div class="toolbar-cell toolbar-expired">
                        <div class="toolbar-cell__front">
                            <div class="title"><img src="/static/desktop/img/icons/stopwatch.png" alt="" height="14"> До конца акции осталось</div>
                            <div class="toolbar-expired__countdown" data-date="{{ $promocode->expire_date->format('M d, Y h:i:s') }}">

                                <div class="toolbar-expired__cell">
                                    <div class="toolbar-expired__cell_value"><div id="expired-days-1"></div><div id="expired-days-2"></div></div>
                                    <div class="toolbar-expired__cell_label">Дней</div>
                                </div>

                                <div class="toolbar-expired__cell">
                                    <div class="toolbar-expired__cell_value"><div id="expired-hours-1"></div><div id="expired-hours-2"></div></div>
                                    <div class="toolbar-expired__cell_label">Часов</div>
                                </div>
                                <div class="toolbar-expired__cell">
                                    <div class="toolbar-expired__cell_value"><div id="expired-minutes-1"></div><div id="expired-minutes-2"></div></div>
                                    <div class="toolbar-expired__cell_label">Минут</div>
                                </div>
                                <div class="toolbar-expired__cell">
                                    <div class="toolbar-expired__cell_value"><div id="expired-seconds-1"></div><div id="expired-seconds-2"></div></div>
                                    <div class="toolbar-expired__cell_label">Секунд</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>



        </div>
    </div>
@endif
