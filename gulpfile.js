const elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss')
    .scripts([
        'vendor/jquery.min.js',
        'vendor/bootstrap.js',
        'vendor/RecordRTC.js',
        'vendor/getScreenId.js',
        'vendor/gif-recorder.js',
        'vendor/gumadapter.js',
        // 'vendor/three.js',
        //  'vendor/leap-0.6.4.js',
        //  'vendor/leap-plugins-0.1.11.js',
        // 'vendor/leap-widgets-0.1.0.js',
        // 'vendor/leap.rigged-hand-0.1.7.js',
        //'vendor/socket.io-1.4.5.js',
        //'leap.js',
        'app.js'
    ], 'public/js/app.js')
    .webpack('echo.js')
    .version(['public/css/app.css', 'public/js/app.js']);
});
