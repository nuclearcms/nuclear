@section('metaDescription', $node->getMetaDescription())
@section('metaKeywords', $node->getMetaKeywords())

@if(isset($isHome) && $isHome)
    @section('pageTitle', $node->getTitle())

    @section('metaAlternateLinks')
        @foreach(locales() as $locale)
        <link rel="alternate" href="{{ route('locale.set.home', $locale) }}" hreflang="{{ $locale }}">
        @endforeach
    @endsection
@else
    @section('pageTitle', $node->getMetaTitle())

    @section('metaAlternateLinks')
        @foreach($node->translations as $translation)
        <link rel="alternate" href="{{ $node->getSiteURL($translation->locale) }}" hreflang="{{ $translation->locale }}">
        @endforeach
    @endsection
@endif

@section('metaImage')
@if($cover = $node->getMetaImage())
<meta property="og:image" content="{{ $cover->getFilteredImageUrlFor('rcompact') }}">
<meta property="twitter:image" content="{{ $cover->getFilteredImageUrlFor('rcompact') }}">
<link rel="image_src" href="{{ $cover->getFilteredImageUrlFor('rcompact') }}">
@endif
@endsection