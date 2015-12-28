var elixir = require('laravel-elixir');
var argv = require('yargs').argv;

/**
 * Config for reactor theme
 */
elixir.config.assetsPath = 'resources/assets/default';
elixir.config.publicPath = 'public/default_assets';

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
if(!argv.r) {
    elixir(function (mix) {
        mix
            .sass('app.sass')
            .scripts(
                'app.js',
                elixir.config.publicPath + '/js/app.js'
            );
    });
}

// Reactor elixir
// If you add the "--r" flag this command will set the
// configuration and run elixir for reactor assets
if(argv.r)
{
    /**
     * Config for reactor theme
     */
    elixir.config.assetsPath = 'resources/assets/reactor';
    elixir.config.publicPath = 'public/reactor_assets';

    elixir(function (mix) {
        mix
            .sass('app.sass')
            .scripts([
                'components/Modernizr.js',
                'components/jquery.min.js',
                'components/jquery-ui.js',
                'common.js',
                'option.js',
                'navigation.js',
                'tree.js',
                'helpers.js',
                'modal.js'
            ], elixir.config.publicPath + '/js/app.js').
        scripts([
            'components/minicolors.js',
            'password.js',
            'slug.js',
            'tag.js',
            'upload.js',
            'library.js',
            'gallery.js',
            'document.js',
            'node_collection.js',
            'editor.js',
            'fields.js'
        ], elixir.config.publicPath + '/js/form.js').
        scripts([
            'upload.js'
        ], elixir.config.publicPath + '/js/upload.js').
        scripts([
            'update.js'
        ], elixir.config.publicPath + '/js/update.js').
        scripts([
            'components/cropper.js',
            'image.js'
        ], elixir.config.publicPath + '/js/image.js');
    });
}