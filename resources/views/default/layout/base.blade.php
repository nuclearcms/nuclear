<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html lang="{{ App::getLocale() }}" class="no-js"><!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="{!! settings('site-description') !!}">

    @yield('opengraph')

    <title>@yield('pageTitle') &mdash; {{ settings('site-title') }}</title>

    <link href='https://fonts.googleapis.com/css?family=Lato:100,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->

    {!! Theme::css('css/app.css') !!}

    @yield('styles')

    {!! Theme::js('js/vendor/modernizr-2.8.3.min.js') !!}

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', '{{ settings('settings') }}', 'auto');
        ga('send', 'pageview');

    </script>
</head>
<body>
<!--[if lt IE 8]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

@yield('body')

@yield('modules')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="{!! Theme::url('js/vendor/jquery-1.11.3.min.js') !!}"><\/script>');</script>

{!! Theme::js('js/app.js') !!}

@yield('scripts')

</body>
</html>