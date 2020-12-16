<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('page-title') &mdash; {{ config('app.name') }}</title>

    <meta name="description" content="@yield('page-description')">
    <meta name="robots" content="index, follow">
    @stack('meta')
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="@yield('page-title')">
    <meta property="og:description" content="@yield('page-description')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:locale"content="{{ str_replace('_', '-', app()->getLocale()) }}">

    <link rel="manifest" href="/site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    @stack('styles')
    
</head>
<body>
    @yield('content')

    @include('cookieConsent::index')
    
    <script src="{{ mix('/js/app.js') }}"></script>

    @stack('scripts')

    @if(config('app.analytics_id'))
    <script>
        window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
        ga('create', '{{ config('app.analytics_id') }}', 'auto'); ga('set', 'anonymizeIp', true); ga('set', 'transport', 'beacon'); ga('send', 'pageview')
    </script>
    <script src="https://www.google-analytics.com/analytics.js" async></script>
    @endif
</body>

</html>
