var elixir = require('laravel-elixir');
var argv = require('yargs').argv;

/**
 * Config for the site theme
 */
elixir.config.assetsPath = 'resources/assets/site';
elixir.config.publicPath = 'public_html/site';

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
    elixir.config.publicPath = 'public_html/reactor';

    elixir(function (mix) {
        mix
            .sass('app.sass', elixir.config.publicPath + '/css/app.css')
            .scripts([
                'components/Modernizr.min.js',
                'components/jquery.min.js',
                'common.js'
            ], elixir.config.publicPath + '/js/app.js');
    });

}
