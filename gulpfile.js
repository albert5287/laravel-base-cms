var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less(['admin/AdminLTE.less',
        'admin/skins/skin-blue.less'
    ], 'resources/assets/css')
        .styles([
        'app.css',
        'vendor/bootstrap.css'
    ]).version('css/all.css');

    mix.scripts([
        'libs/jQuery-2.1.3.min.js',
        'libs/bootstrap.min.js',
        'app.js',
    ], 'public/js/all.js');
});
