<?php

use Illuminate\Database\Seeder;
use \App\Model\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $settings = [

            [
                'id' => 'social-link-vk',
                'type' => 'text',
                'name' => 'Ссылка на Вконтакте',
                'value' => 'http://vk.com/'
            ],

            [
                'id' => 'social-link-facebook',
                'type' => 'text',
                'name' => 'Ссылка на Facebook',
                'value' => 'http://facebook.com/'
            ],

            [
                'id' => 'social-link-twitter',
                'type' => 'text',
                'name' => 'Ссылка на Twitter',
                'value' => 'http://twitter.com/'
            ],

            [
                'id' => 'social-link-google-plus',
                'type' => 'text',
                'name' => 'Ссылка на Google Plus',
                'value' => 'https://google.com/'
            ],

            [
                'id' => 'order_minimum_amount',
                'type' => 'text',
                'name' => 'Сумма минимального заказа',
                'value' => '1000',
                'sort' => 6
            ],
            [
                'id' => 'passport_field_description',
                'type' => 'textarea',
                'name' => 'Описание для поля "Паспорт серия, номер" в профиле',
                'value' => '1000'
            ],

            [
                'id' => 'seo_title_sale_page',
                'type' => 'text',
                'name' => 'Титл для страницы "Распродажа"',
                'value' => 'Распродажа'
            ],

            [
                'id' => 'seo_title_catalog_new_page',
                'type' => 'text',
                'name' => 'Титл для страницы "Новинки"',
                'value' => 'Новинки'
            ],

            [
                'id' => 'order-delivery-price-description',
                'type' => 'text',
                'name' => 'Описание для цены доставки, при оформлении заказа',
                'value' => 'Описание для цены доставки, при оформлении заказа'
            ],

            [
                'id' => 'login',
                'type' => 'text',
                'name' => 'Логин',
                'value' => 'admin',
                'sort' => 1
            ],
            [
                'id' => 'password',
                'type' => 'password',
                'name' => 'Новый пароль',
                'value' => '5beae320800e4ef0fa4b5e3fd0040e59',
                'sort' => 2
            ],
            [
                'id' => 'quick-order-success-message',
                'type' => 'textarea',
                'name' => 'Сообщение после заказа ([number] - номер счета)',
                'value' => 'Номер Вашего заказа: [number]'
            ],
            [
                'id' => 'repeat-order-success-message',
                'type' => 'textarea',
                'name' => 'Сообщение после повторного заказа',
                'value' => 'Спасибо! Ваш заказа успешно повторен'
            ],
            [
                'id' => 'quick-order-agreement-text',
                'type' => 'textarea',
                'name' => 'Сообщение о обработке персональных данных в "Купить в 1 клик" ([link] - ссылка на положение)',
                'value' => 'Нажимая кнопку "Купить в 1 клик" я даю согласие на обработку персональных данных в соответствии с указанным [link] текстом.'
            ],
            [
                'id' => 'order-agreement-text',
                'type' => 'textarea',
                'name' => 'Сообщение о обработке персональных данных при оформлении заказа ([link] - ссылка на положение)',
                'value' => 'Нажимая кнопку "Подтвердить заказ" я подтверждаю свою дееспособность, согласие на получение информации об оформлении и получении заказа, согласие на обработку персональных данных в соответствии с указанным [link] текстом.'
            ],
            [
                'id' => 'forget-password-hash',
                'type' => 'text',
                'name' => 'Хеш для восстановления пароля',
                'value' => md5('test'),
                'hide' => 1
            ],
            [
                'id' => 'google-merchant-feed-name',
                'type' => 'text',
                'name' => 'Google Merchant название',
                'value' => 'MigTele.ru',
                'hide' => 1
            ],
            [
                'id' => 'google-merchant-feed-description',
                'type' => 'text',
                'name' => 'Google Merchant описание',
                'value' => 'Интернет магазин MigTele.ru',
                'hide' => 1
            ],
            [
                'id' => 'friend-promocode-reward',
                'type' => 'text',
                'name' => 'Размер скидки по промокоду',
                'value' => 3
            ],
            [
                'id' => 'friend-promocode-expired',
                'type' => 'text',
                'name' => 'Количество дней действия промокода',
                'value' => 7
            ]


        ];


        foreach ($settings as $setting)
        {

            if(!Setting::where('id', $setting['id'])->count()){

                $sort = Setting::orderBy('sort', 'desc')->first()->sort;

                $setting['sort'] = isset($setting['sort']) && $setting['sort'] ? $setting['sort'] : ++$sort;
                $setting['hide'] = 0;

                Setting::create($setting);

            }

        }


        $remove_setting_ids = ['admin'];

        foreach ($remove_setting_ids as $id)
        {
            if(Setting::where('id', $id)->count()){
                Setting::where('id', $id)->delete();
            }

        }
    }
}
