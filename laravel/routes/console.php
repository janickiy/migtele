<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command('add_markup_price_to_products', function () {

    foreach(\App\Model\Product::all() as $product) {

        $product->price_markup = random_int(5, 15);
        $product->save();

    }

})->describe('Success');


Artisan::command('fix_products', function () {

    foreach(\App\Model\Product::all() as $product) {

        if(!count($product->cattmr)){
            $product->id_cattmr = 0;
            $product->save();
        }


    }

})->describe('Success');

Artisan::command('fix_images', function () {

    $count = 0;



    foreach(\App\Model\ProductImages::all() as $image) {

        $file_path = 'uploads/goods_img/'.$image->id.'.jpg';


        if(!count($image->product) || !file_exists(__DIR__.'/../../'.$file_path)){
            $image->delete();
            $count++;
        }

    }




    echo 'deleting '.$count.' images';

})->describe('Success');