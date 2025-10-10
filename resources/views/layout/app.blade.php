<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
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

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('page-title') &mdash; {{ config('app.name') }}</title>

    <meta name="description" content="@yield('page-description')">
    <meta name="robots" content="index, follow">
    
    @stack('meta')

    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('icon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite('resources/css/app.css')
    @endif

    @stack('styles')
</head>
<body>
    @include('partials.navigation')

    <div class="flex min-h-screen">
        <main class="flex-grow">
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    @include('cookie-consent::index')
    
    @vite('resources/js/app.js')

    @stack('scripts')
</body>

</html>
