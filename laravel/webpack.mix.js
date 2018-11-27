let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.setPublicPath(path.normalize('..'));

mix.scripts([
    'resources/assets/libs/jquery/dist/jquery.min.js',
    'resources/assets/libs/owl.carousel/dist/owl.carousel.min.js',
    'resources/assets/libs/jquery-mousewheel/jquery.mousewheel.min.js',
    'resources/assets/libs/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.js',
    'resources/assets/libs/jquery-modal/jquery.modal.min.js',
    'resources/assets/libs/nouislider/distribute/nouislider.min.js',
    'resources/assets/libs/jquery.form-styler/dist/jquery.formstyler.min.js',
    'resources/assets/libs/izimodal/js/iziModal.min.js',
    'resources/assets/libs/jquery.number.min.js',
    'resources/assets/libs/clipboard.min.js'
], '../static/desktop/js/libs.js');

mix.js('resources/assets/desktop/js/app.js', '../static/desktop/js')
   .sass('resources/assets/desktop/sass/app.sass', '../static/desktop/css')
    .js('resources/assets/mobile/js/common.js', '../static/mobile/js')
    .sass('resources/assets/mobile/sass/main.sass', '../static/mobile/css')
    .options({processCssUrls: false});


/**
 * Mobile
 */


mix.scripts([
    'resources/assets/libs/jquery/dist/jquery.min.js',
    'resources/assets/libs/owl.carousel/dist/owl.carousel.min.js',
    'resources/assets/libs/slideout.js/dist/slideout.min.js',
    'resources/assets/libs/jquery-modal/jquery.modal.min.js',
    'resources/assets/libs/izimodal/js/iziModal.min.js',
    'resources/assets/libs/jquery.number.min.js',
    'resources/assets/libs/clipboard.min.js'
], '../static/mobile/js/libs.js');


