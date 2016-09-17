<nav class="container navigation">
    <a href="{{ route('site.home') }}" class="navigation__home">
        {!! Theme::img('img/nuclear-logo.svg', 'Nuclear Logo', 'navigation__logo') !!}
    </a>

    <div class="navigation__links">
        @foreach($home->getPositionOrderedChildren() as $section)
            @if( ! $section->isArchived() && $section->hasTranslation())
            <a class="navigation__link" href="{{ $section->getSiteURL() }}">
                {{ uppercase($section->getTitle()) }}
            </a>
            @endif
        @endforeach
    </div>
</nav>