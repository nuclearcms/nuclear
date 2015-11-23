<?php $flaps = [
    'reactor.contents.edit'       => 'nodes.content',
    'reactor.contents.parameters' => 'nodes.parameters',
    'reactor.contents.seo'        => 'nodes.seo',
]; ?>

<ul class="content-tabs-bar">
    @if($node->hidesChildren())
        <li>
            @if($currentTab === 'reactor.contents.tree')
                <span class="content-tab-flap active">{{ uppercase(trans('nodes.tree')) }}</span>
            @else
                {!! link_to_route('reactor.contents.tree', uppercase(trans('nodes.tree')), $currentKey, ['class' => 'content-tab-flap']) !!}
            @endif
        </li>
    @endif
    @foreach($flaps as $route => $text)
        <li>
            @if($currentTab === $route)
                <span class="content-tab-flap active">{{ uppercase(trans($text)) }}</span>
            @else
                @if($route === 'reactor.contents.parameters' || !isset($source))
                    {!! link_to_route($route, uppercase(trans($text)), $currentKey, ['class' => 'content-tab-flap']) !!}
                @else
                    {!! link_to_route($route, uppercase(trans($text)), ['id' => $currentKey, 'source' => $source->getKey()], ['class' => 'content-tab-flap']) !!}
                @endif
            @endif
        </li>
    @endforeach
</ul>
