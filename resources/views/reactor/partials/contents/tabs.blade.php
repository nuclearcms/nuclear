<div class="tabs-container">
    <div class="tabs-outer scroller scroller--muted">
        <ul class="tabs">
            @yield('tabs_prepended')
            @foreach($flaps as $route => $text)
                <li class="tabs__flap">
                    @if($currentRoute === $route)
                        <span class="tabs__link tabs__link--active">{{ uppercase(trans($text)) }}</span>
                    @else
                        {!! link_to_route($route, uppercase(trans($text)), $currentKey, ['class' => 'tabs__link']) !!}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
    <div class="tabs-outer tabs-outer--children scroller scroller--muted">
        @yield('children_tabs')
    </div>
</div>