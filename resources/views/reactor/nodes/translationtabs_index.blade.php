@if(locale_count() > 1)
    <ul class="content-tabs-bar">
        @foreach(config('translatable.locales') as $localeTab)
            <li>
                @if($localeTab === $locale)
                    <span class="content-tab-flap active">{{ uppercase($localeTab) }}</span>
                @else
                    {!! link_to_route('reactor.contents.index', uppercase($localeTab), [$scope, $localeTab], ['class' => 'content-tab-flap']) !!}
                @endif
            </li>
        @endforeach
    </ul>
@endif