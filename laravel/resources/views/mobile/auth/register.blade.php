@extends('mobile.layouts.template')

@section('content')

    @include('mobile.components.back_link', [
            'name' => 'Главная',
            'url' => '/'
    ])

    <div class="container">

        <div class="heading-1">Регистрация</div>

        <form class="form-horizontal" method="POST" action="{{ route('register') }}">

            <input type="text" style="display:none">
            <input type="password" name="password" style="display:none">

            {{ csrf_field() }}


            @include('mobile.form.type', ['label' => 'Тип аккаунта'])


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

                @include('form.row', [
                    'label' => 'Адрес доставк',
                    'required' => false,
                    'field_name' => 'juridical_delivery_addresses[]',
                    'field_id' => 'registration-juridical_delivery_addresses',
                    'tabindex' => 11
                ])

            </div>

            <div class="form-group__checkboxes" style="margin: 20px 0">
            @include('form.checkbox', [
                        'label' => 'Информация о статусе заказа',
                        'field_name' => 'subscribe_order',
                        'field_id' => 'registration-subscribe_order',
                        'tabindex' => 13,
                        'checked' => old('subscribe_order') ? true : (old('subscribe_order') ? false : true)

                    ])

            @include('form.checkbox', [
                        'label' => 'Информация о товаре в корзине',
                        'field_name' => 'subscribe_cart',
                        'field_id' => 'registration-subscribe_cart',
                        'tabindex' => 14,
                        'checked' => old('subscribe_cart') ? true : (old('subscribe_cart') ? false : true)
                    ])

            @include('form.checkbox', [
                        'label' => 'Информация о просмотренном товаре',
                        'field_name' => 'subscribe_view',
                        'field_id' => 'registration-subscribe_view',
                        'tabindex' => 15,
                        'checked' => old('subscribe_view') ? true : (old('subscribe_view') ? false : true)

                    ])

            @include('form.checkbox', [
                         'label' => 'Информация о закладках',
                         'field_name' => 'subscribe_wishlist',
                         'field_id' => 'registration-subscribe_wishlist',
                         'tabindex' => 16,
                         'checked' => old('subscribe_wishlist') ? true : (old('subscribe_wishlist') ? false : true)

                     ])

            @include('form.checkbox', [
                        'label' => 'На новости компании',
                        'field_name' => 'subscribe_news',
                        'field_id' => 'registration-subscribe_news',
                        'tabindex' => 17,
                        'checked' => old('subscribe_news') ? true : (old('subscribe_news') ? false : true)

                    ])


            </div>
            @include('form.recaptcha')

            <div class="center login-button">
                <button type="submit" class="btn">Зарегистрироваться</button>
            </div>

        </form>


    </div>




@endsection