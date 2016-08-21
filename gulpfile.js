var elixir = require('laravel-elixir');
var argv = require('yargs').argv;

/**
 * Config for the site theme
 */
elixir.config.assetsPath = 'resources/assets/site';
elixir.config.publicPath = 'public_html/assets/site';

if( ! argv.r) {
    // Site elixir
    elixir(function (mix) {
        mix
            .sass('app.sass', elixir.config.publicPath + '/css/app.css')
            .scripts('app.js', elixir.config.publicPath + '/js/app.js');
    });

} else {
    // Reactor elixir
    elixir.config.assetsPath = 'resources/assets/reactor';
    elixir.config.publicPath = 'public_html/assets/reactor';

    elixir(function (mix) {
        mix
            .sass('app.sass', elixir.config.publicPath + '/css/app.css')
            .scripts([
                'vendor/Modernizr.min.js',
                'vendor/jquery.min.js',
                'vendor/jquery-ui.min.js',
                'vendor/perfect-scrollbar.min.js',
                'common.js',
                'helpers.js',
                'dropdowns.js',
                'modals.js',
                'navigation.js',
                'nodetrees.js'
            ], elixir.config.publicPath + '/js/app.js')
            .scripts([
                'vendor/minicolors.min.js',
                'passwords.js',
                'relations.js',
                'slugs.js',
                'forms.js'
            ], elixir.config.publicPath + '/js/forms.js')
            .scripts([
                'uploader.js'
            ], elixir.config.publicPath + '/js/uploader.js')
            .scripts([
                'vendor/cropper.min.js',
                'image.js'
            ], elixir.config.publicPath + '/js/image.js')
        ;
    });

}
