@component('components.modal', [
    'id' => 'share-promocode',
    'title' => 'Ваш заказ принят и находится в обработке',
    'description' => 'Поделитесь с друзьями и получите скидку '.$promocode->reward.'% на следующую покупку!'
])

    <div class="social-share">
        <script type="text/javascript">(function() {
                if (window.pluso)if (typeof window.pluso.start == "function") return;
                if (window.ifpluso==undefined) { window.ifpluso = 1;
                    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                    var h=d[g]('body')[0];
                    h.appendChild(s);
                }})();</script>
        <div class="pluso" data-background="transparent" data-options="big,circle,line,horizontal,nocounter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter" data-title="{{ $promocode->seo_title }}" data-description="{{ $promocode->seo_description }}" data-url="{{ $promocode->url }}"></div>

        <a href="#" class="promocode-tab-link share-email" data-id="1"></a>
        <a href="#" class="promocode-tab-link share-link" data-id="2"></a>

    </div>

    <div class="promocode-tab-content promocode-friend-email" data-id="1">
        <form action="{{ route('promocode.send-friend') }}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="code" value="{{ $promocode->code }}" >

            <input type="text" name="email" value="" class="form-control" placeholder="Введите email">

            <div class="message"></div>

            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    </div>

    <div class="promocode-tab-content" data-id="2">
        <button class="toolbar-buttons__coupon_copy btn btn-primary" data-clipboard-text="{{ $promocode->url }}"><span class="icon"></span><span class="txt">Копировать ссылку</span></button>
    </div>


    <div class="promocode-info">
        <div class="title">Правила акции.</div>
        <ol>
            <li>Ваш друг получит скидку {{$promocode->reward}}% на покупки.</li>
            <li>Вы получите скидку {{$promocode->reward}}% на следующий заказ за то, что ваш друг совершит покупку.</li>
        </ol>
    </div>
@endcomponent

