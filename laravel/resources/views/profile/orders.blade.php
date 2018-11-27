@extends('layouts.template')


@section('content')

    @widget('breadcrumbs', ['type' => 'profile', 'element' => 'Мои заказы'])

    <div class="heading-2 heading-2__modify">Мои заказы</div>

    @include('modules.profile.tabs', ['selected' => '1'])

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
                    @if(!$order->cancel && $order->api_status != 'Ждет обработки')
                        <div class="order-tools__links">
                            @if($order->shipping_file_url)
                                <span class="order-tools__links_download">Отгрузочные документы: <a href="{{ url('/orders/'.$order->id.'/download/shipping') }}" target="_blank">Скачать</a></span>
                            @endif
                            @if($order->order_file_url)
                                <a href="{{ url('/orders/'.$order->id.'/download/order') }}" target="_blank"><span class="icon icon-print"></span>Скачать счет</a>
                            @endif
                            <a href="#callback-form" class="open-modal"><span class="icon icon-phone-single"></span>Связаться с нами</a>
                        </div>
                    @endif
                </div>
                <div class="order-body">

                    <div class="order-row">
                        <div class="order-row__left">
                            <div class="order-body__title">Товары</div>
                        </div>
                        <div class="order-row__right order-tools__links">
                            @if(!$order->cancel)

                                <a href="{{ url('/profile/order-cancel/'.$order->id) }}" class="order-tools__link_cancel"><span class="icon icon-cancel"></span>Отменить</a>

                                <form action="{{ url('/profile/order-repeat') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <button type="submit" class="order-tools__link_repeat"><span class="icon icon-repeat"></span>Повторить</button>
                                </form>
                            @endif
                        </div>
                    </div>

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
                                    <td>{{ _price($order->delivery_price) }} Р</td>
                                    <td>{{ _price($order->delivery_price) }} Р</td>
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
                                        <img src="{{ url('/images/order-profile/uploads/goods_img/'.$product->preview.'.jpg') }}" alt="">
                                    </div>
                                </td>
                                <td><a href="{{ url($product->url) }}">{{ $product->name }}</a></td>
                                <td>{{ $product->pivot->kol }} шт.</td>
                                <td>{{ _price($product->pivot->price) }} Р</td>
                                <td>{{ _price($product->pivot->stoim) }} Р</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="order-body__amount">Общая сумма заказа: <span class="price">{{ _price($order->amount) }} Р</span></div>
                </div>
            </div>
            <div class="order-hr"></div>
        @endforeach

    </div>



@endsection