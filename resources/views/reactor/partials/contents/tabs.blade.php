<div class="tabs-container">
    <div class="tabs-outer scroller">
        <ul class="tabs">
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
    <div class="tabs-outer tabs-outer--children scroller">
        <ul class="tabs">
            {{-- HERE NEED CHILD TABS, ALSO NEED OPTIONS MENU YIELD --}}
        </ul>
    </div>
</div>