const mix = require('laravel-mix');

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

//  frontend mix
mix.js('resources/js/script.js', 'public/js/front_js/')
   .js('resources/js/vanilla-tilt.js', 'public/js/front_js/')
   .sass('resources/sass/select2.scss', 'public/css/front_css/')
   .sass('resources/sass/style.scss', 'public/css/front_css/');
   
