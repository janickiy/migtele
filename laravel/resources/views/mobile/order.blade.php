@extends('mobile.layouts.template')

@section('content')

    @include('mobile.components.back_link', [
            'return_back' => true
    ])

    <div class="container">
        <div class="heading-1">Оформление заказа</div>
    </div>

    @if(\CartProducts::getTotalQuantity())
        <form action="{{ url('/ordering') }}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="is_mobile" value="1">

            <div class="container">

                @include('mobile.form.type', ['label' => 'Получатель', 'field_name' => 'contractor_type'])

                <div class="form-group">
                    <label for="order-name" class="label">ФИО<span>*</span></label>
                    @include('form.input', [
                        'field_name' => 'name',
                        'field_value' =>  Auth::user() ? Auth::user()->name : '',
                        'field_id' => 'order-name',
                        'tabindex' => 2,
                        'errors' => $errors->order
                    ])
                </div>

                <div class="form-group">
                    <label for="order-phone" class="label">Телефон<span>*</span></label>
                    @include('form.input', [
                        'field_name' => 'phone',
                        'field_value' =>  Auth::user() ? Auth::user()->phone : '',
                        'field_id' => 'order-phone',
                        'tabindex' => 3,
                        'errors' => $errors->order
                    ])
                </div>

                <div class="form-group">
                    <label for="order-email" class="label">E-mail<span>*</span></label>
                    @include('form.input', [
                        'field_name' => 'email',
                        'field_value' =>  Auth::user() ? Auth::user()->email : '',
                        'field_id' => 'order-email',
                        'tabindex' => 3,
                        'errors' => $errors->order
                    ])
                </div>



                <div class="for-juridical">

                    <div class="form-group">
                        <label class="label">Название компании<span>*</span></label>
                        @include('form.input', [
                            'field_name' => 'company_name',
                            'field_value' =>  Auth::user() ? Auth::user()->company_name : '',
                            'field_id' => 'order-company_name',
                            'tabindex' => 1,
                            'errors' => $errors->order
                        ])
                    </div>

                    <div class="form-group">
                        <label class="label">ИНН/КПП<span>*</span></label>
                        @include('form.input', [
                            'field_name' => 'inn',
                            'field_value' =>  Auth::user() ? Auth::user()->contractor_inn : '',
                            'field_id' => 'order-contractor_inn',
                            'tabindex' => 4,
                            'errors' => $errors->order
                        ])
                    </div>

                    <div class="form-group">
                        <label class="label">Юридический адрес<span>*</span></label>
                        @include('form.input', [
                            'field_name' => 'address',
                            'field_value' =>  Auth::user() ? Auth::user()->contractor_address : '',
                            'field_id' => 'order-contractor_address',
                            'tabindex' => 5,
                            'errors' => $errors->order
                        ])
                    </div>

                </div>


                <div class="form-group">
                    <div class="label">Выберете способ оплаты:</div>
                    <div class="form-group__radio_inline">

                        @foreach($payments as $i => $payment)
                            <div class="form-radio">
                                @include('mobile.form.radio', [
                                    'label' => $payment->name,
                                    'field_id' => 'order-payment-'.$payment->id,
                                    'field_name' => 'payment_method_id',
                                    'field_value' => $payment->id,
                                    'checked' => old('payment_method_id') ? old('payment_method_id') == $payment->id  : $i == 0,
                                    'dataid' => $payment->id,
                                    'tabindex' => 10
                                ])
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="form-group">
                    <div class="label">Выберете способ доставки:</div>

                    <div class="form_group__radio_list delivery-type">

                        @foreach($deliveries as $i=>$delivery)

                            <div class="form-radio">
                                <input {{ old('delivery_method_id') ? (old('delivery_method_id') == $delivery->id ? 'checked' : '') : ($i == 0 ? 'checked' : '') }} data-id="{{ $delivery->id }}" tabindex="11" class="radio" id="order-delivery-{{ $delivery->id }}" type="radio" name="delivery_method_id" value="{{ $delivery->id }}" data-price="{{ $delivery->price }}">
                                <label for="order-delivery-{{ $delivery->id }}">{{ $delivery->name }}
                                    @if($delivery->price)
                                        <span class="price">{{ _price($delivery->price) }} Р</span>
                                    @else
                                        <span class="price price__success">Бесплатно</span>
                                    @endif
                                </label>
                            </div>

                            @continue($i == 0)

                            <div class="delivery-description" data-id="{{ $delivery->id }}">
                                <div class="form-group">
                                    <label for="order-delivery-{{ $delivery->id }}-address" class="label">Адрес доставки:</label>
                                    @include('form.input', [
                                        'field_name' => 'delivery-'.$delivery->id.'-address',
                                        'field_value' =>  Auth::user() ? Auth::user()->delivery_address : '',
                                        'field_id' => 'order-delivery-'.$delivery->id.'-address',
                                        'errors' => $errors->order,
                                        'tabindex' => 11
                                    ])
                                </div>
                            </div>

                        @endforeach

                    </div>

                </div>

                <div class="order-amount">
                    <div class="row">
                        <div class="order-amount__left">Сумма товара:</div>
                        <div class="order-amount__right"><span class="amount-value">{{ _price(\CartProducts::getTotal()) }}</span> <div class="rub">у</div></div>
                    </div>
                    <div class="row">
                        <div class="order-amount__left">Сумма доставки:</div>
                        <div class="order-amount__right"><span class="amount-value" id="order-delivery-price">300</span> <div class="rub">у</div></div>
                    </div>
                    <div class="row">
                        <div class="order-amount__left">Скидка:</div>
                        <div class="order-amount__right"><span class="amount-value" id="order-discount">{{ _price(\App\Model\Product::getAllCartDiscount()) }}</span> <div class="rub">у</div></div>
                    </div>
                </div>

                <div class="order-amount__total">
                    <div class="row">
                        <div class="order-amount__left">Всего к оплате:</div>
                        <div class="order-amount__right"><span class="amount-value" id="order-amount">17 731</span> <div class="rub">у</div></div>
                    </div>
                </div>


                <div class="form-group__checkboxes">


                    @if(!Auth::user())
                        @include('form.checkbox', [
                            'label' => 'Зарегистрироваться на сайте',
                            'field_id' => 'order-register',
                            'field_name' => 'register',
                            'tabindex' => 13,
                            'checked' => old('register') ? true : (old('register') ? false : true)
                        ])

                        @include('form.checkbox', [
                                    'label' => 'Информация о статусе заказа',
                                    'field_name' => 'subscribe_order',
                                    'field_id' => 'order-subscribe_order',
                                    'tabindex' => 14,
                                    'checked' => old('subscribe_order') ? true : (old('subscribe_order') ? false : true)

                                ])

                        @include('form.checkbox', [
                                    'label' => 'Информация о товаре в корзине',
                                    'field_name' => 'subscribe_cart',
                                    'field_id' => 'order-subscribe_cart',
                                    'tabindex' => 15,
                                    'checked' => old('subscribe_cart') ? true : (old('subscribe_cart') ? false : true)
                                ])

                        @include('form.checkbox', [
                                    'label' => 'Информация о просмотренном товаре',
                                    'field_name' => 'subscribe_view',
                                    'field_id' => 'order-subscribe_view',
                                    'tabindex' => 16,
                                    'checked' => old('subscribe_view') ? true : (old('subscribe_view') ? false : true)
                                ])

                        @include('form.checkbox', [
                                    'label' => 'Информация о закладках',
                                    'field_name' => 'subscribe_wishlist',
                                    'field_id' => 'order-subscribe_wishlist',
                                    'tabindex' => 17,
                                    'checked' => old('subscribe_wishlist') ? true : (old('subscribe_wishlist') ? false : true)
                        ])

                        @include('form.checkbox', [
                            'label' => 'На новости компании',
                            'field_name' => 'subscribe_news',
                            'field_id' => 'order-subscribe_news',
                            'tabindex' => 18,
                            'checked' => old('subscribe_news') ? true : (old('subscribe_news') ? false : true)

                        ])

                    @endif

                </div>

                <div style="margin: 10px 0">
                    @include('form.recaptcha')
                </div>

                <div class="order-button">
                    <button type="submit" class="btn">Оформить заказ</button>
                </div>

            </div>

        </form>
    @else
        <p>Для заказа, Вам нужно добравить товар в корзину</p>
    @endif


@endsection