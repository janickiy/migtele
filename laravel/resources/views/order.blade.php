@extends('layouts.template')

@section('title', 'Оформление заказа')
@section('content')


    @widget('breadcrumbs', ['type' => 'order'])


    <div class="heading-2">Оформление заказа</div>

    @if(\CartProducts::getTotalQuantity())

        <form action="{{ url('/ordering') }}" method="POST">
            {{ csrf_field() }}
            <div class="order-step">

                <input type="hidden" name="mobile_phone" value="{{ Auth::user() ? Auth::user()->phone2 : '' }}">
                <input type="hidden" name="delivery_address" value="{{ Auth::user() ? Auth::user()->delivery_address : '' }}">
                <input type="hidden" name="delivery_address_2" value="{{ Auth::user() ? Auth::user()->delivery_address_2 : '' }}">

                <input type="hidden" name="passport_number" value="{{ Auth::user() ? Auth::user()->passport : '' }}">
                <input type="hidden" name="fact_address" value="{{ Auth::user() ? Auth::user()->actual_address : '' }}">

                <div class="row">
                    <div class="order-step__left">
                        <div class="order-step__title">Получатель:</div>
                    </div>
                    <div class="order-step__right">
                        @include('form.profile_type', ['field_name' => 'type'])
                    </div>
                </div>

                @include('form.row', [
                        'label' => 'ФИО',
                        'required' => true,
                        'field_name' => 'name',
                        'field_id' => 'order-name',
                        'field_value' =>  Auth::user() ? Auth::user()->name : '',
                        'tabindex' => 2,
                        'class_left' => 'order-step__left',
                        'class_right' => 'order-step__right',
                        'errors' => $errors->order

                    ])

                @include('form.row', [
                        'label' => 'Телефон',
                        'required' => true,
                        'field_name' => 'phone',
                        'field_id' => 'contractor_phone',
                        'field_value' =>  Auth::user() ? Auth::user()->phone : '',
                        'tabindex' => 3,
                        'class_left' => 'order-step__left',
                        'class_right' => 'order-step__right',
                        'errors' => $errors->order
                    ])

                @include('form.row', [
                        'label' => 'E-mail',
                        'required' => true,
                        'field_name' => 'email',
                        'field_id' => 'contractor_email',
                        'field_value' =>  Auth::user() ? Auth::user()->email : '',
                        'tabindex' => 4,
                        'class_left' => 'order-step__left',
                        'class_right' => 'order-step__right',
                        'errors' => $errors->order
                    ])


                <div class="for-juridical">

                    <div class="row">
                        <div class="order-step__left">
                            <label for="order-company_name">Компания покупатель <span class="required">*</span></label>
                        </div>
                        <div class="order-step__right">
                            <div class="row">
                                <div class="form_group_col_2">
                                    @include('form.input', [
                                        'field_name' => 'company_name',
                                        'field_value' =>  Auth::user() ? Auth::user()->company_name : '',
                                        'field_id' => 'order-company_name',
                                        'tabindex' => 8,
                                        'errors' => $errors->order
                                    ])
                                </div>
                                <div class="form_group_col_4 form-control__checkbox-layer">
                                    <label class="form-label" for="order-juridical_delivery_company_name">Компания грузополучатель <span>*</span></label>

                                    @include('form.checkbox', [
                                        'label' => 'Совпадает с юридическим',
                                        'field_name' => 'coincides_company_name',
                                        'field_id' => 'order-company_name_is_actual',
                                        'tabindex' => 8,
                                        'checked' => old('coincides_company_name') ? true : (old('company_receiver') ? false : !$errors->has('company_receiver'))
                                        ])

                                    @include('form.input', [
                                        'field_name' => 'company_receiver',
                                        'field_value' => '',
                                        'field_id' => 'order-juridical_delivery_company_name',
                                        'tabindex' => 8,
                                        'errors' => $errors->order
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>


                    @include('form.row', [
                       'label' => 'ИНН/КПП',
                       'required' => true,
                       'field_name' => 'inn',
                       'field_id' => 'order-tin',
                       'field_value' =>  Auth::user() ? Auth::user()->tin : '',
                       'tabindex' => 9,
                       'class_left' => 'order-step__left',
                       'class_right' => 'order-step__right',
                       'errors' => $errors->order
                   ])

                    @include('form.row', [
                       'label' => 'Юридический адрес',
                       'required' => true,
                       'field_name' => 'address',
                       'field_id' => 'order-juridical_address',
                       'field_value' =>  Auth::user() ? Auth::user()->juridical_address : '',
                       'tabindex' => 10,
                       'class_left' => 'order-step__left',
                       'class_right' => 'order-step__right',
                       'errors' => $errors->order
                   ])

                </div>
            </div>

            @include('modules.order.payment_methods')

            @include('modules.order.delivery_methods')


            <div class="order-step order-step__final">
                <div class="order-step__checkbox_list">

                    @if(!Auth::user())
                        @include('form.checkbox', [
                            'label' => 'Зарегистрироваться на сайте',
                            'field_id' => 'order-register',
                            'field_name' => 'register',
                            'tabindex' => 13,
                            'checked' => old('register') ? true : (old('register') ? false : true)
                        ])

                        <div class="register-subscriptions">
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
                        </div>

                    @endif

                </div>
                <div class="order-step__amount">
                    <div class="record"><span class="name">Сумма товара:</span> <span class="price"><span class="value" id="order-amount-without-discount">{{ _price(\CartProducts::getTotal() + \App\Model\Product::getAllCartDiscount()) }}</span> Р</span></div>
                    <div class="record"><span class="name">Сумма доставки:</span> <span class="price"> <span id="order-delivery-price-prefix">От</span> <span class="value" id="order-delivery-price">200</span> Р@include('modules.common.quest_block', ['text' => _setting('order-delivery-price-description')])</span></div>
                    <div class="record"><span class="name">Скидка:</span> <span class="price"><span class="value" id="order-discount">{{ _price(\App\Model\Product::getAllCartDiscount()) }}</span> Р</span></div>
                    <div class="record amount"><span class="name">Всего к оплате:</span> <span class="price"><span class="value" id="order-amount">17 800</span> Р</span></div>
                </div>
            </div>

            <div class="order-recaptcha">
                @include('form.recaptcha', ['errors' => $errors->order])
            </div>

            @if((int)_setting('order_minimum_amount') > \CartProducts::getTotal())
                @include('modules.minimum_order_text')
            @endif

            <div class="order-buttons">
                <a href="{{ url('/cart') }}" class="btn-back">Вернуться в корзину</a>
                <button type="submit" class="btn" @if((int)_setting('order_minimum_amount') > \CartProducts::getTotal()) disabled @endif>Подтвердить заказ</button>
            </div>

            <div class="text-agreement">
                {!!  str_replace('[link]', "<a href='".url('/zaschita_personalnih_dannih.htm')."'>здесь</a>", _setting('order-agreement-text'))  !!}
            </div>

        </form>
    @else
        <p>Для заказа, Вам нужно добравить товар в корзину</p>
    @endif

@endsection

@section('before-script')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkG46bTzP07uJ75WdKjx6IGgEFtfzf4CI">
    </script>
@endsection