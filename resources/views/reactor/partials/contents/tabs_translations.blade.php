@if(locale_count() > 1)
    <ul class="tabs">
    @foreach(locales() as $localeTab)
        @if($t = $translatable->translate($localeTab))
        <li class="tabs__flap">
            @if($t->locale === $locale)
                <span class="tabs__child-link tabs__child-link--active">{{ uppercase($localeTab) }}</span>
            @else
                {!! link_to_route($translationRoute, uppercase($localeTab), [$translatable->getKey(), $t->getKey()], ['class' => 'tabs__child-link']) !!}
            @endif
        </li>
        @endif
    @endforeach
</ul>
@endif

@hasSection('tab_options')
    @yield('tab_options')
@else
    @if(count($translatable->translations) < locale_count())
    <div class="tabs__options">
        <a href="{{ route($translateRoute, [$translatable->getKey(), $translation->getKey()]) }}" class="tabs__option-button">
            <i class="icon-plus"></i>
        </a>
    </div>
    @endif
@endif