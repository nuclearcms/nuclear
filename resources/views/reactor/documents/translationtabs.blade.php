@if(locale_count() > 1)
    <div class="translation-tabs translation-tabs-sub">
        <ul class="content-tabs-bar secondary-tabs-bar">
            @foreach(config('translatable.locales') as $localeTab)
                @if($translation = $media->translateOrNew($localeTab))
                    <li>
                        @if($translation->locale === $locale)
                            <span class="content-tab-flap active">{{ uppercase($translation->locale) }}</span>
                        @else
                            {!! link_to_route('reactor.documents.edit', uppercase($translation->locale), ['id' => $media->getKey(), 'locale' => $localeTab], ['class' => 'content-tab-flap']) !!}
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif