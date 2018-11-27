@extends('mobile.layouts.template')

@section('title', 'Онлайн оплата счета №'.$pay_order->number)

@section('content')

    <div class="container">
        <div class="heading-2">Онлайн оплата счета №{{ $pay_order->number }}</div>

        <div style="text-align: center">

            @if(!$pay_order->is_pay)

                <iframe src="https://money.yandex.ru/quickpay/shop-widget?writer=seller&default-sum={{ $pay_order->amount }}&targets={{ $pay_order->title }}&target-visibility=on&button-text=12&payment-type-choice=on&mobile-payment-type-choice=on&fio=on&phone=on&comment=on&mail=on&hint=&successURL={{$pay_order->return_url}}&quickpay=shop&account=410011257937969" width="450" height="290" frameborder="0" allowtransparency="true" scrolling="no"></iframe>


            @else

                <p class="alert-success">Счет оплачен</p>

            @endif
        </div>
    </div>


@endsection

