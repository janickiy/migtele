@extends('layouts.template')


@section('content')

    <div class="main-side">
        <div class="heading-2">Регистрация</div>



        <form action="{{ route('register') }}" method="POST" class="form-wrapper">

            <input type="text" style="display:none">
            <input type="password" name="password" style="display:none">

            {{ csrf_field() }}
            <div class="row">
                <div class="form-column__left">

                </div>
                <div class="form-column__right">

                    @include('form.profile_type')

                </div>
            </div>


            @include('form.row', [
                'label' => 'ФИО',
                'required' => true,
                'field_name' => 'name',
                'field_id' => 'registration-name',
                'tabindex' => 1
            ])

            @include('form.row', [
                'label' => 'Мобильный телефон',
                'required' => true,
                'field_name' => 'phones[]',
                'field_value' => old('phones')[0],
                'field_id' => 'registration-phone',
                'error_name' => 'phones.0',
                'tabindex' => 4
            ])

            @include('form.row', [
                'label' => 'E-mail',
                'required' => true,
                'field_name' => 'email',
                'field_id' => 'registration-email',
                'tabindex' => 5
            ])

            <div class="for-individual">
                @include('form.row', [
                    'label' => 'Адрес доставки',
                    'required' => true,
                    'field_name' => 'delivery_addresses[]',
                    'field_value' => old('delivery_addresses')[0],
                    'field_id' => 'registration-delivery_addresses',
                    'error_name' => 'delivery_addresses.0',
                    'autocomplete' => 'false',
                    'tabindex' => 6
                ])
            </div>

            @include('form.row', [
                'label' => 'Пароль',
                'required' => true,
                'field_name' => 'password',
                'field_id' => 'registration-password',
                'field_type' => 'password',
                'autocomplete' => 'false',
                'tabindex' => 7
            ])


            <div class="for-juridical">

                @include('form.row', [
                    'label' => 'Название компании',
                    'required' => true,
                    'field_name' => 'company_name',
                    'field_id' => 'registration-company_name',
                    'tabindex' => 8
                ])

                @include('form.row', [
                    'label' => 'ИНН/КПП',
                    'required' => true,
                    'field_name' => 'tin',
                    'field_id' => 'registration-tin',
                    'tabindex' => 9
                ])

                @include('form.row', [
                    'label' => 'Юридический адрес',
                    'required' => true,
                    'field_name' => 'juridical_address',
                    'field_id' => 'registration-juridical_address',
                    'tabindex' => 10
                ])

                @include('form.row', [
                    'label' => 'Фактический адрес',
                    'required' => true,
                    'field_name' => 'actual_address',
                    'field_id' => 'registration-actual_address',
                    'tabindex' => 11
                ])

                <div class="row">
                    <div class="form-column__left">
                        <label for="registration-juridical_delivery_address">Адрес доставки <span class="required">*</span></label>
                    </div>
                    <div class="form-column__right form-control__checkbox-layer">
                        @include('form.checkbox', [
                        'label' => 'Совпадает с фактическим',
                        'field_name' => 'delivery_is_actual',
                        'field_id' => 'registration-delivery_is_actual',
                        'tabindex' => 12,
                        'checked' => old('delivery_is_actual') ? true : (old('juridical_delivery_address') ? false : true)
                        ])
                        @include('form.input', [
                            'field_name' => 'juridical_delivery_addresses[]',
                            'field_id' => 'registration-juridical_delivery_addresses',
                            'tabindex' => 12
                        ])
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="form-column__left"></div>
                <div class="form-column__right">
                    @include('form.checkbox', [
                        'label' => 'Информация о статусе заказа',
                        'field_name' => 'subscribe_order',
                        'field_id' => 'registration-subscribe_order',
                        'tabindex' => 13,
                        'checked' => old('subscribe_order') ? true : (old('subscribe_order') ? false : true)

                    ])
                </div>
            </div>

            <div class="row">
                <div class="form-column__left"></div>
                <div class="form-column__right">
                    @include('form.checkbox', [
                        'label' => 'Информация о товаре в корзине',
                        'field_name' => 'subscribe_cart',
                        'field_id' => 'registration-subscribe_cart',
                        'tabindex' => 14,
                        'checked' => old('subscribe_cart') ? true : (old('subscribe_cart') ? false : true)
                    ])
                </div>
            </div>

            <div class="row">
                <div class="form-column__left"></div>
                <div class="form-column__right">
                    @include('form.checkbox', [
                        'label' => 'Информация о просмотренном товаре',
                        'field_name' => 'subscribe_view',
                        'field_id' => 'registration-subscribe_view',
                        'tabindex' => 15,
                        'checked' => old('subscribe_view') ? true : (old('subscribe_view') ? false : true)

                    ])
                </div>
            </div>

            <div class="row">
                <div class="form-column__left"></div>
                <div class="form-column__right">
                    @include('form.checkbox', [
                        'label' => 'Информация о закладках',
                        'field_name' => 'subscribe_wishlist',
                        'field_id' => 'registration-subscribe_wishlist',
                        'tabindex' => 16,
                        'checked' => old('subscribe_wishlist') ? true : (old('subscribe_wishlist') ? false : true)

                    ])
                </div>
            </div>

            <div class="row">
                <div class="form-column__left"></div>
                <div class="form-column__right">
                    @include('form.checkbox', [
                        'label' => 'На новости компании',
                        'field_name' => 'subscribe_news',
                        'field_id' => 'registration-subscribe_news',
                        'tabindex' => 17,
                        'checked' => old('subscribe_news') ? true : (old('subscribe_news') ? false : true)

                    ])
                </div>
            </div>


            <div class="row row-recaptcha">
                <div class="form-column__left"></div>
                <div class="form-column__right">
                    @include('form.recaptcha')
                </div>
            </div>

            <div class="row row-btn">
                <div class="form-column__left"></div>
                <div class="form-column__right">
                    <button tabindex="15" type="submit" class="btn">Зарегистрироваться</button>
                </div>
            </div>



        </form>
    </div>



@endsection