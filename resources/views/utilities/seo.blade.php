@section('page-title', !empty($content->meta_title) ? $content->meta_title : $content->title)
@section('page-description', $content->meta_description)

@push('meta')
@if(!empty($content->meta_author))
<meta name="author" content="{{ $content->meta_author }}">
@endif

@if($cover = $content->cover_image)
<meta property="og:image" content="{{ $cover->public_url }}">
@endif
@endpush

@push('meta')
@if($content->id != config('app.home_content'))
    @foreach($content->site_urls as $locale => $url)
        @if($locale === config('app.fallback_locale'))
            <link rel="alternate" hreflang="x-default" href="{{ str_replace('www.', '', url($url)) }}">
            <link rel="canonical" href="{{ str_replace('www.', '', url($url)) }}">
        @endif
        <link rel="alternate" hreflang="{{ $locale }}" href="{{ url($url) }}">
    @endforeach
@else
    <link rel="alternate" hreflang="x-default" href="{{ str_replace('www.', '', route('home')) }}">
    <link rel="canonical" href="{{ str_replace('www.', '', route('home')) }}">
    @foreach(config('app.locales') as $locale)
        <link rel="alternate" hreflang="{{ $locale }}" href="{{ str_replace('www.', '', route($locale .'.home')) }}">
    @endforeach
@endif
@endpush

@push('meta')
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:title" content="@yield('page-title')">
<meta property="og:description" content="@yield('page-description')">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
@endpush