<?php

use Illuminate\Database\Seeder;
use \App\Model\Pages;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pages = [

            [
                'name' => 'Оплата',
                'link' => '/payment.htm',
                'text' => 'Страница оплаты',
                'top' => 1,
                'mid' => 0,
                'bot' => 0,
                'readonly' => 1,
                'title' => '',
                'keywords' => '',
                'description' => ''
            ],

            [
                'name' => 'Гарантия',
                'link' => '/warranty.htm',
                'text' => 'Страница гарантии',
                'top' => 1,
                'mid' => 0,
                'bot' => 0,
                'readonly' => 1,
                'title' => '',
                'keywords' => '',
                'description' => ''
            ],

            [
                'name' => 'Публичная оферта',
                'link' => '/oferta.htm',
                'text' => "<p>Договор публичной оферты о продаже товаров интернет-магазина www.migtele.ru</p>",
                'top' => 0,
                'mid' => 0,
                'bot' => 0,
                'readonly' => 1,
                'title' => 'Публичная оферта',
                'keywords' => '',
                'description' => ''
            ],

            [
                'name' => 'Положение о защите персональных данных',
                'link' => '/zaschita_personalnih_dannih.htm',
                'text' => "<p>Для целей настоящего Положения применяются следующие термины и определения:</p>",
                'top' => 0,
                'mid' => 0,
                'bot' => 0,
                'readonly' => 1,
                'title' => 'Положение о защите персональных данных',
                'keywords' => '',
                'description' => ''
            ],



        ];


        foreach ($pages as $page){

            if(!Pages::where('link', $page['link'])->count()){
                Pages::create($page);
            }

        }

    }
}
