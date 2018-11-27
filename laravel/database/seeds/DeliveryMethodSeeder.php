<?php

use Illuminate\Database\Seeder;
use \App\Model\DeliveryMethod;

class DeliveryMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $deliveries = [
            [
                'name' => 'Самовывоз',
                'type' => 'pickup',
                'price' => 0,
                'sort' => 1,
                'hide' => 0,
            ],
            [
                'name' => 'Доставка по Москве',
                'type' => 'in_moscow',
                'price' => 300,
                'sort' => 2,
                'hide' => 0,
            ],
            [
                'name' => 'Доставка по РФ',
                'type' => 'in_russia',
                'price' => 100,
                'sort' => 3,
                'hide' => 0,
            ]

        ];

        foreach ($deliveries as $delivery){

            if(!DeliveryMethod::where('name', $delivery['name'])->count()){
                DeliveryMethod::create($delivery);
            }

        }




    }
}
