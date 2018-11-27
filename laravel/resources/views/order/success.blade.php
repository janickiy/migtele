@extends('layouts.template')

@section('content')


    <div class="heading-2">Заказ успешно оформлен</div>

    <div class="text-content">
        <?php $text = str_replace('[number]', $order->number, _setting('quick-order-success-message')); ?>
        {!! $text !!}
    </div>


@endsection