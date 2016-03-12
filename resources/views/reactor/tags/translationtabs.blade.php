@if(locale_count() > 1)
<div class="translation-tabs">
    <ul class="content-tabs-bar secondary-tabs-bar">
        @foreach(config('translatable.locales') as $localeTab)
            @if($translation = $tag->translate($localeTab))
            <li>
                @if($translation->locale === $locale)
                    <span class="content-tab-flap active">{{ uppercase($translation->locale) }}</span>
                @else
                    {!! link_to_route($route, uppercase($translation->locale), [$tag->getKey(), $translation->getKey()], ['class' => 'content-tab-flap']) !!}
                @endif
            </li>
            @endif
        @endforeach
    </ul>
    @if(count($tag->translations) < locale_count())
        <a href="{{ route('reactor.tags.translation.create', [$tag->getKey(), $currentTranslation->getKey()]) }}" class="add-translation-button">
            <i class="icon-plus"></i>
        </a>
    @endif
</div>
@endif