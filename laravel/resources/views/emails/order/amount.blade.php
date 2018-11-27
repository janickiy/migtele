<div class="product-amount" style="-webkit-box-shadow: 0 1px 3px rgba(4,6,7,.1); border: 1px solid #dedede; box-shadow: 0 1px 3px rgba(4,6,7,.1); font: inherit; font-size: 100%; margin: 0; margin-top: 20px; padding: 0; padding-left: 21px; vertical-align: baseline;">

    <div class="count" style="border: 0; color: #212121; display: inline-block; font: inherit; font-size: 14px; line-height: 61px; margin: 0; padding: 0; vertical-align: baseline; width: 200px" >{{ $order->quantity }} товара в корзине</div>

    <div class="discount" style="border: 0; color: #212121; display: inline-block; font: inherit; font-size: 14px; line-height: 61px; margin: 0; margin-left: 41px; padding: 0; vertical-align: baseline; width: 320px;">С учетом общей <b style="border: 0; font: inherit; font-size: 100%; font-weight: 500; margin: 0; padding: 0; vertical-align: baseline;">скидки в {{_price($order->discount)}}  р.</b></div>

    <div class="amount" style="border: 0; color: #212121; display: inline-block; font: inherit; font-size: 14px; line-height: 61px; margin: 0; padding: 0; text-align: right; vertical-align: baseline; width: 263px;">Итого: <div class="price" style="border: 0; color: #212121; display: inline-block; font: inherit; font-size: 18px; line-height: 61px; margin: 0; padding: 0; vertical-align: baseline;">{{ _price($order->amount) }}   р.</div></div>

</div>