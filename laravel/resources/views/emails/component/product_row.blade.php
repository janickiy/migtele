<div class="product" style="-webkit-box-shadow: 0 1px 3px rgba(4,6,7,.1); background-color: #fff; border: 1px solid #dedede; box-shadow: 0 1px 3px rgba(4,6,7,.1); font: inherit; font-size: 0; margin: 0; margin-bottom: 10px; padding: 0; vertical-align: baseline;">

    <div class="img" style="border: 0; display: inline-block; font: inherit; font-size: 100%; margin: 0; min-height: 110px; padding: 0; text-align: center; vertical-align: top; width: 152px;"><img src="{{ url('/images/order-email/uploads/goods_img/'.$product->preview.'.jpg') }}" alt="" style="border: 0; display: inline-block; font: inherit; font-size: 100%; margin: 0; max-height: 110px; max-width: 100%; padding: 0; vertical-align: middle; width: auto;"></div>

    <div class="info" style="border: 0; display: inline-block; font: inherit; font-size: 100%; margin: 0; padding: 0; vertical-align: top; width: 501px;">
        <div class="title" style="border: 0; color: #2072b5; font: inherit; font-size: 18px; line-height: 18px; margin: 0; margin-top: 13px; padding: 0; vertical-align: baseline;">{{ $product->name }}</div>
        <div class="description" style="border: 0; color: #212121; font: inherit; font-family: Roboto,sans-serif; font-size: 12px; line-height: 16px; margin: 0; margin-top: 14px; padding: 0; vertical-align: baseline;">{{ $product->short_description }}
            <a href="{{ url($product->url) }}" class="more" style="border: 0; color: #2072b5; font: inherit; font-family: Rubik,sans-serif; font-size: 100%; margin: 0; padding: 0; text-decoration: none; vertical-align: baseline;">Подробнее</a></div>
    </div>

    <div class="amount" style="border: 0; display: inline-block; font: inherit; font-size: 100%; margin: 0; padding: 0; text-align: right; vertical-align: top; width: 180px;">
        <div class="price" style="border: 0; color: #212121; font: inherit; font-size: 18px; line-height: 18px; margin: 0; margin-top: 11px; padding: 0; vertical-align: baseline;">{{ isset($is_cart) ? $product->price : _price($product->pivot->price) }}   р.</div>
        <div class="discount" style="border: 0; color: #212121; font: inherit; font-size: 14px; line-height: 14px; margin: 0; margin-top: 5px; padding: 0; vertical-align: baseline;">Скидка {{ $product->pivot->discount }}   р.</div>
        <div class="count" style="border: 1px solid #c1c1c1; color: #212121; display: inline-block; font: inherit; font-size: 18px; line-height: 30px; margin: 15px 2px 0 0; padding: 0 10px; text-align: center; vertical-align: baseline; ">{{ isset($is_cart) ? $product->pivot->quantity :  $product->pivot->kol }}</div>
    </div>

</div>