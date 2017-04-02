@section('metaDescription', $node->getMetaDescription())
@section('metaKeywords', $node->getMetaKeywords())

@if(isset($isNode) && $isNode)
    @section('pageTitle', $node->getMetaTitle())

    @section('metaAlternateLinks')
        @foreach($node->translations as $translation)
            @if($translation->locale !== App::getLocale())
            <link rel="alternate" href="{{ $node->getSiteURL($translation->locale) }}" hreflang="{{ $translation->locale }}">
            @endif
        @endforeach
    @endsection
@else
    @section('pageTitle', $node->getTitle())

    @section('metaAlternateLinks')
        @foreach(locales() as $locale)
            @if($locale !== App::getLocale())
            <link rel="alternate" href="{{ route('locale.set.home', $locale) }}" hreflang="{{ $locale }}">
            @endif
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