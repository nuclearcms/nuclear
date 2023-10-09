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

    @if(Str::startsWith($current = url()->current(), 'https://www'))
    <link rel="canonical" href="{{ str_replace('https://www.', 'https://', $current) }}">
    @else
    <link rel="canonical" href="{{ str_replace('https://', 'https://www.', $current) }}">
    @endif

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    @stack('styles')
    
    @if(config('app.analytics_id'))
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('app.analytics_id') }}"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{ config('app.analytics_id') }}');
    </script>
    @endif
</head>
<body>
    @yield('content')

    @include('cookie-consent::index')
    
    <script src="{{ mix('/js/app.js') }}"></script>

    @stack('scripts')
</body>

</html>
