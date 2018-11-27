@extends('emails.layouts.template')

@section('content')

    <div class="cart-title" style="border: 0; color: #232323; font: inherit; font-size: 18px; margin: 0; margin-top: 24px; padding: 0; text-align: center; vertical-align: baseline;">{{ $mailTemplate->title }}</div>

    <div class="cart-description" style="border: 0; font: inherit; font-size: 14px; margin: 0; margin-bottom: -34px; margin-top: 8px; padding: 0; vertical-align: baseline;">{!! $mailTemplate->body !!}</div>

    <div class="products" style="background-color: #f6f6f6; border: 0; font: inherit; font-size: 100%; margin: 0; margin-top: 38px; padding: 0; vertical-align: baseline;">
        <?php
            $total = 0;
            $totalQuantity = 0;
            $totalDiscount = 0;
        ?>
        @foreach($products as $product)
            @include('emails.component.product_row', ['is_cart' => true])
            <?php
               $total += $product->getCorrectPrice() * $product->pivot->quantity;
               $totalQuantity += $product->pivot->quantity;
               $totalDiscount += $product->discount_original * $product->pivot->quantity;
            ?>
        @endforeach
    </div>

    <div class="product-amount" style="-webkit-box-shadow: 0 1px 3px rgba(4,6,7,.1); border: 1px solid #dedede; box-shadow: 0 1px 3px rgba(4,6,7,.1); font: inherit; font-size: 100%; margin: 0; margin-top: 20px; padding: 0; padding-left: 21px; vertical-align: baseline;">
        <div class="count" style="border: 0; color: #212121; display: inline-block; font: inherit; font-size: 14px; line-height: 61px; margin: 0; padding: 0; vertical-align: baseline;">{{ $totalQuantity }} товара в корзине</div>
        <div class="discount" style="border: 0; color: #212121; display: inline-block; font: inherit; font-size: 14px; line-height: 61px; margin: 0; margin-left: 51px; padding: 0; vertical-align: baseline; width: 340px;">С учетом общей <b style="border: 0; font: inherit; font-size: 100%; font-weight: 500; margin: 0; padding: 0; vertical-align: baseline;">скидки в {{ _price($totalDiscount) }}  р.</b></div>
        <div class="amount" style="border: 0; color: #212121; display: inline-block; font: inherit; font-size: 14px; line-height: 61px; margin: 0; padding: 0; text-align: right; vertical-align: baseline; width: 283px;">Итого: <div class="price" style="border: 0; color: #212121; display: inline-block; font: inherit; font-size: 18px; line-height: 61px; margin: 0; padding: 0; vertical-align: baseline;">{{ _price($total) }}   р.</div></div>
    </div>



    <div class="cart-buttons" style="border: 0; font: inherit; font-size: 100%; margin: 0; margin-bottom: 45px; margin-top: 30px; padding: 0; vertical-align: baseline;">
        <a href="{{ url('/#callback-form') }}" class="btn btn-back btn-medium btn-left" style="-webkit-border-radius: 4px; border: 1px solid #2072b5; border-radius: 4px; color: #2072b5; display: inline-block; float: left; font: inherit; font-size: 14px; line-height: 28px; margin: 0; padding: 0; text-align: center; text-decoration: none; vertical-align: baseline; width: 186px;">Заказать звонок</a>
        <a href="{{ url('/order') }}" class="btn btn-primary btn-big btn-right" style="-webkit-border-radius: 4px; background-color: #2072b5; border: 1px solid #2072b5; border-radius: 4px; color: #fff; display: inline-block; float: right; font: inherit; font-size: 14px; line-height: 28px; margin: 0; padding: 0; text-align: center; text-decoration: none; vertical-align: baseline; width: 296px;">Оформить заказ</a>
        <div class="clr" style="border: 0; clear: both; font: inherit; font-size: 100%; margin: 0; padding: 0; vertical-align: baseline;"></div>
    </div>


@endsection
