<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Name of route
    |--------------------------------------------------------------------------
    |
    | Enter the routes name to enable dynamic imagecache manipulation.
    | This handle will define the first part of the URI:
    | 
    | {route}/{template}/{filename}
    | 
    | Examples: "images", "img/cache"
    |
    */
   
    'route' => 'images',

    /*
    |--------------------------------------------------------------------------
    | Storage paths
    |--------------------------------------------------------------------------
    |
    | The following paths will be searched for the image filename, submited 
    | by URI. 
    | 
    | Define as many directories as you like.
    |
    */




    'paths' => array(
        public_path().'/../..',
    ),

    /*
    |--------------------------------------------------------------------------
    | Manipulation templates
    |--------------------------------------------------------------------------
    |
    | Here you may specify your own manipulation filter templates.
    | The keys of this array will define which templates 
    | are available in the URI:
    |
    | {route}/{template}/{filename}
    |
    | The values of this array will define which filter class
    | will be applied, by its fully qualified name.
    |
    */
   
    'templates' => array(
        'widget' => function($image) {
            return $image->resize(null, 90, function ($constraint) {
                $constraint->aspectRatio();
            });
        },
        'sub_category' => function($image) {
            return $image->resize(90, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        },
        'preview' => function($image) {
            return $image->resize(null, 145, function ($constraint) {
                $constraint->aspectRatio();
            });
        },
        'modal-cart' => function($image) {
            return $image->resize(185, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        },
        'cart' => function($image) {
            return $image->resize(135, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        },
        'order-profile' => function($image) {
            return $image->resize(140, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        },
        'order-email' => function($image) {
            return $image->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        },
        'gallery' => function($image) {
            return $image->resize(470, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        },
        'email-product' => function($image) {
            return $image->fit(200, 200);
        },

        'mobile-widget' => function($image) {
            return $image->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
        },

        'mobile-preview' => function($image) {
            return $image->resize(null, 190, function ($constraint) {
                $constraint->aspectRatio();
            });
        },

        'small' => 'Intervention\Image\Templates\Small',
        'large' => 'Intervention\Image\Templates\Large',
    ),

    /*
    |--------------------------------------------------------------------------
    | Image Cache Lifetime
    |--------------------------------------------------------------------------
    |
    | Lifetime in minutes of the images handled by the imagecache route.
    |
    */
   
    'lifetime' => 43200,

);
