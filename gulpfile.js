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
            'components/jquery.min.js',
            'components/touch-dnd.js',
            'common.js',
            'option.js',
            'navigation.js',
            'nodes.js',
            'helpers.js',
            'modal.js'
        ], elixir.config.publicPath + '/js/app.js').
        scripts([
            'components/minicolors.js',
            'password.js',
            'upload.js',
            'slug.js',
            'fields.js'
        ], elixir.config.publicPath + '/js/form.js').
        scripts([
            'components/cropper.js',
            'image.js'
        ], elixir.config.publicPath + '/js/image.js');
});
