<ul class="content-tabs-bar">
    @foreach($flaps as $route => $text)
        <li>
            @if($currentTab === $route)
                <span class="content-tab-flap active">{{ uppercase(trans($text)) }}</span>
            @else
                {!! link_to_route($route, uppercase(trans($text)), $currentKey, ['class' => 'content-tab-flap']) !!}
            @endif
        </li>
    @endforeach
</ul>