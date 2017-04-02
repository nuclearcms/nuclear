<meta name="description" content="@yield('metaDescription', $home->getTranslationAttribute('meta_description'))">
<meta name="keywords" content="@yield('metaKeywords', $home->getTranslationAttribute('meta_keywords'))">

<meta property="og:locale" content="{{ App::getLocale() }}">
<meta property="og:title" content="@yield('pageTitle')">
<meta property="og:site_name" content="{{ $home->getTranslationAttribute('meta_title') }}">
<meta property="og:description" content="@yield('metaDescription', $home->getTranslationAttribute('meta_description'))">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:type" content="website">

<meta property="twitter:card" content="summary">
<meta property="twitter:title" content="@yield('pageTitle')">
<meta property="twitter:description" content="@yield('metaDescription', $home->getTranslationAttribute('meta_description'))">
<meta property="twitter:site" content="{{ $home->getTranslationAttribute('meta_title') }}">
<meta property="twitter:url" content="{{ request()->url() }}">

@yield('metaImage')
@yield('metaAlternateLinks')