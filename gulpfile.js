var elixir = require('laravel-elixir');

/**
 * Config for reactor theme
 */
elixir.config.assetsPath = 'resources/assets/reactor';
elixir.config.publicPath = 'public/reactor_assets';

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

elixir(function (mix) {
    mix
        .sass('app.sass')
        .scripts([
            'components/Modernizr.js',
            'components/zepto.min.js',
            'navigation.js',
            'modal.js',
            'option.js'
        ], 'public/reactor_assets/js/app.js').
        scripts([
            'password.js',
            'fields.js'
        ], 'public/reactor_assets/js/form.js');
});
