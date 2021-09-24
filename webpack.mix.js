const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         //
//     ]);

mix.sass('resources/css/sass/app.scss', 'public/css/app.css')
.sass('resources/css/sass/fonts.scss', 'public/css/fonts.css')
.copy('node_modules/bootstrap-icons', 'public/bootstraps-icons')
.copy('node_modules/interactjs/dist/interact.min.js', 'public/js')
.js('resources/js/certificateLayout.js', 'public/js')
.js('resources/js/addCertificateSearch.js', 'public/js')
.js('resources/js/checksEvent.js', 'public/js')
.js('resources/js/signature.js', 'public/js')
.js('resources/js/statistic.js', 'public/js');
