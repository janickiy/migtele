@if($order->delivery_name)
    <div class="product delivery" style="-webkit-box-shadow: 0 1px 3px rgba(4,6,7,.1); background-color: #fff; border: 1px solid #dedede; box-shadow: 0 1px 3px rgba(4,6,7,.1); font: inherit; font-size: 0; margin: 0; margin-bottom: 10px; padding: 0; vertical-align: baseline;">
        <div class="img" style="border: 0; display: inline-block; font: inherit; font-size: 100%; margin: 0; min-height: 84px; padding: 0; text-align: center; vertical-align: top; width: 152px;">{{--<img src="http://alshan.kz/email/img/demo/2.png" alt="" style="border: 0; display: inline-block; font: inherit; font-size: 100%; margin: 0; max-height: 84px; max-width: 100%; padding: 0; vertical-align: middle; width: auto;">--}}</div>

        <div class="info" style="border: 0; display: inline-block; font: inherit; font-size: 100%; margin: 0; padding: 0; vertical-align: top; width: 566px;">
            <div class="title" style="border: 0; color: #212121; font: inherit; font-size: 14px; line-height: 84px; margin: 0; margin-top: 13px; padding: 0; vertical-align: baseline;">{{ $order->delivery_name }}</div>
        </div>

        <div class="amount" style="border: 0; display: inline-block; font: inherit; font-size: 100%; margin: 0; padding: 0; text-align: right; vertical-align: top; width: 115px;">
            <div class="price" style="border: 0; color: #212121; font: inherit; font-size: 18px; line-height: 82px; margin: 0; margin-top: 11px; padding: 0; vertical-align: baseline;">{{ $order->delivery_price ? _price($order->delivery_price).' р.' : 'Бесплатно' }}</div>
        </div>
    </div>
@endif