
@extends('mobile.layouts.template')

@section('content')

    @include('mobile.components.back_link', [
            'name' => 'Главная',
            'url' => '/'
    ])

    <div class="container">

        <div class="product-list__block">

            @include('mobile.profile.tabs', ['selected' => 'orders'])

            <div class="heading-1">Заказы</div>

            <div class="order-list">

                @foreach($user->orders as $order)
                    <div class="order {{ $order->cancel ? 'order-cancel' : '' }}">
                        <div class="order-header">
                            <div class="order-header__number">№СчЛ-{{ $order->number }}</div>
                            <div class="order-header__date"><span class="date">{{ $order->date->format('d.m.Y') }}</span><span class="time">{{ $order->date->toTimeString()}}</span></div>
                            @if($order->is_new && !$order->cancel)
                                <div class="order-header__status">Новый</div>
                            @endif
                            @if($order->cancel)
                                <div class="order-header__status order-header__status_cancel">Отменен</div>
                            @endif
                        </div>
                        <div class="order-tools">
                            <div class="order-tools__status">Стадия: <a>{{ $order->api_status }}</a></div>
                            @if(!$order->cancel)
                                <div class="order-tools__links">
                                    @if($order->shipping_file_url)
                                        <span class="order-tools__links_download">Отгрузочные документы: <a href="{{ url($order->shipping_file_url) }}" target="_blank">Скачать</a></span>
                                    @endif
                                    @if($order->order_file_url)
                                        <a href="{{ url($order->order_file_url) }}" target="_blank"><span class="icon icon-print"></span>Распечатать</a>
                                    @endif
                                    <a href="{{ url('/profile/order-cancel/'.$order->id) }}" class="order-tools__link_cancel"><span class="icon icon-cancel"></span>Отменить заказ</a>
                                    {{--<a href="#callback-form" class="open-modal"><span class="icon icon-phone-single"></span>Связаться с нами</a>--}}
                                </div>
                            @endif
                        </div>

                        <div class="order-body">
                            <div class="order-body__title">Товары</div>
                            <table>
                                <thead>
                                <tr>
                                    <td></td>
                                    <td>Фото</td>
                                    <td>Описание</td>
                                    <td>Кол-во</td>
                                    <td>Цена</td>
                                    <td>Сумма</td>
                                </tr>
                                </thead>
                                <tbody>
                                @php($k = 0)
                                @if($order->delivery_name)
                                    <tr>
                                        <td>{{ ++$k }}</td>
                                        <td>
                                            <div class="img-wrapper">
                                                @if($order->delivery_img)
                                                    <img class="img-circle" src="{{ url($order->delivery_img) }}" alt="">
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $order->delivery_name }}</td>
                                        <td>1 шт.</td>
                                        @if($order->delivery_price)
                                            <td>{{ _price($order->delivery_price) }} <span class="rub">у</span></td>
                                            <td>{{ _price($order->delivery_price) }} <span class="rub">у</span></td>
                                        @else
                                            <td>бесплатно</td>
                                            <td>бесплатно</td>
                                        @endif

                                    </tr>
                                @endif
                                @foreach($order->products as $product)
                                    <tr>
                                        <td>{{ ++$k }}</td>
                                        <td>
                                            <div class="img-wrapper">
                                                <img src="{{ url('/images/widget/uploads/goods_img/'.$product->preview.'.jpg') }}" alt="">
                                            </div>
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->pivot->kol }} шт.</td>
                                        <td>{{ _price($product->pivot->price) }} <span class="rub">у</span></td>
                                        <td>{{ _price($product->pivot->stoim) }} <span class="rub">у</span></td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <div class="order-body__amount">Общая сумма заказа: <span class="price">{{ _price($order->amount) }} <span class="rub">у</span></span></div>
                        </div>
                    </div>
                    <div class="order-hr"></div>
                @endforeach

            </div>

        </div>

    </div>




@endsection