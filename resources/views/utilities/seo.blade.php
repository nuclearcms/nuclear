@section('page-title', !empty($content->meta_title) ? $content->meta_title : $content->title)
@section('page-description', $content->meta_description)

@push('meta')
@if(!empty($content->meta_author))
<meta name="author" content="{{ $content->meta_author }}">
@endif

@if($content->id != config('app.home_content'))
@foreach($content->site_urls as $locale => $url)
<link rel="alternate" hreflang="{{ $locale }}" href="{{ url($url) }}">
@endforeach
@endif

@if($cover = $content->cover)
<meta property="og:image" content="{{ $cover->public_url }}">
@endif
@endpush