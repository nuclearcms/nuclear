<footer class="footer">
    <div class="footer__inner container">

        <a class="footer__kk" href="http://kenarkose.com" target="_blank">
            <svg version="1.1" id="kk_logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 64 64" xml:space="preserve">
                <path fill="#FFFFFF" d="M64,64l0-12.8L41.6,28.8l-6.4,6.4L64,64z M0,64V25.6l9.1-9v25.6L51.2,0H64L0,64z"/>
            </svg>
        </a>

        <div class="navigation__links footer__links">
            @foreach(locales() as $locale)
                @if($locale === app()->getLocale())
                    <span class="navigation__link footer__link footer__link--active">{{ uppercase(trans('general.' . $locale, [], 'messages', $locale)) }}</span>
                @else
                    <a class="navigation__link footer__link" href="{{ route('locale.set.home', $locale) }}">{{ uppercase(trans('general.' . $locale, [], 'messages', $locale)) }}</a>
                @endif
            @endforeach
        </div>

    </div>
</footer>