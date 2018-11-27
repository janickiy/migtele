@extends('mobile.layouts.template')

@section('content')

    @include('mobile.components.back_link', [
            'name' => 'Главная',
            'url' => '/'
    ])

    <div class="container">

        <div class="product-list__block">

            @include('mobile.profile.tabs', ['selected' => 'settings'])

            <div class="heading-1">Подписки</div>

            <form action="{{ url('/profile/save-settings') }}" method="POST">

                {{ csrf_field() }}


                <div class="form-group__checkboxes">
                    @include('form.checkbox', [
                                'label' => 'Информация о статусе заказа',
                                'field_name' => 'subscribe_order',
                                'field_id' => 'setting-subscribe_order',
                                'tabindex' => 13,
                                'checked' => $user->subscribe_order

                            ])

                    @include('form.checkbox', [
                                'label' => 'Информация о товаре в корзине',
                                'field_name' => 'subscribe_cart',
                                'field_id' => 'setting-subscribe_cart',
                                'tabindex' => 14,
                                'checked' => $user->subscribe_cart
                            ])

                    @include('form.checkbox', [
                                'label' => 'Информация о просмотренном товаре',
                                'field_name' => 'subscribe_view',
                                'field_id' => 'setting-subscribe_view',
                                'tabindex' => 15,
                                'checked' => $user->subscribe_view
                            ])

                    @include('form.checkbox', [
                                'label' => 'Информация о закладках',
                                'field_name' => 'subscribe_wishlist',
                                'field_id' => 'setting-subscribe_wishlist',
                                'tabindex' => 16,
                                'checked' => $user->subscribe_wishlist
                    ])

                    @include('form.checkbox', [
                        'label' => 'На новости компании',
                        'field_name' => 'subscribe_news',
                        'field_id' => 'setting-subscribe_news',
                        'tabindex' => 17,
                        'checked' => $user->subscribe_news,

                    ])
                </div>

                <div class="profile-button">
                    <button type="submit" class="btn">Сохранить</button>
                </div>

            </form>

            <br>

            <div class="heading-1">Пароль</div>

            <br>

            <form action="{{ url('/profile/change-password') }}" method="POST">

                {{ csrf_field() }}


                @include('form.row', [
                    'label' => 'Старый пароль',
                    'required' => true,
                    'field_name' => 'old_password',
                    'field_type' => 'password',
                    'field_id' => 'change-old_password',
                    'tabindex' => 4,
                    'errors' => $errors->change_password
                ])

                @include('form.row', [
                    'label' => 'Новый пароль',
                    'required' => true,
                    'field_name' => 'password',
                    'field_type' => 'password',
                    'field_id' => 'change-password',
                    'tabindex' => 5,
                    'errors' => $errors->change_password
                ])

                @include('form.row', [
                    'label' => 'Повторение пароля',
                    'required' => true,
                    'field_name' => 'password_confirmation',
                    'field_type' => 'password',
                    'field_id' => 'change-password_confirmation',
                    'tabindex' => 6,
                    'errors' => $errors->change_password
                ])

                <div class="profile-button">
                    <button type="submit" class="btn">Сохранить</button>
                </div>

            </form>

        </div>

    </div>




@endsection