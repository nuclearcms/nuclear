<?php $flaps = [
    'reactor.contents.edit'       => 'nodes.content',
    'reactor.contents.parameters' => 'nodes.parameters',
    'reactor.contents.seo'        => 'nodes.seo'
]; ?>

<div class="content-tabs-bar-container">
    <ul class="content-tabs-bar">
        @if($node->hidesChildren())
            <li>
                @if($currentTab === 'reactor.contents.list')
                    <span class="content-tab-flap active">{{ uppercase(trans('nodes.list')) }}</span>
                @else
                    {!! link_to_route('reactor.contents.list', uppercase(trans('nodes.list')), [$currentKey, $source->getKey()], ['class' => 'content-tab-flap']) !!}
                @endif
            </li>

            <li>
                @if($currentTab === 'reactor.contents.tree')
                    <span class="content-tab-flap active">{{ uppercase(trans('nodes.tree')) }}</span>
                @else
                    {!! link_to_route('reactor.contents.tree', uppercase(trans('nodes.tree')), [$currentKey, $source->getKey()], ['class' => 'content-tab-flap']) !!}
                @endif
            </li>
        @endif
        @foreach($flaps as $route => $text)
            <li>
                @if($currentTab === $route)
                    <span class="content-tab-flap active">{{ uppercase(trans($text)) }}</span>
                @else
                    {!! link_to_route($route, uppercase(trans($text)), [$currentKey, $source->getKey()], ['class' => 'content-tab-flap']) !!}
                @endif
            </li>
        @endforeach

        @if ($node->isTaggable())
            <li>
                @if($currentTab === 'reactor.contents.tags')
                    <span class="content-tab-flap active">{{ uppercase(trans('tags.title')) }}</span>
                @else
                    {!! link_to_route('reactor.contents.tags', uppercase(trans('tags.title')), [$currentKey, $source->getKey()], ['class' => 'content-tab-flap']) !!}
                @endif
            </li>
        @endif

        <li>
            @if($currentTab === 'reactor.contents.statistics')
                <span class="content-tab-flap active">{{ uppercase(trans('nodes.statistics')) }}</span>
            @else
                {!! link_to_route('reactor.contents.statistics', uppercase(trans('nodes.statistics')), [$currentKey, $source->getKey()], ['class' => 'content-tab-flap']) !!}
            @endif
        </li>
    </ul>

    <div class="node-options">
        {!! content_options_open() !!}

        @if ($node->canHaveChildren())
        <li>
            <a href="{{ route('reactor.contents.create', $node->getKey()) }}">
                <i class="icon-plus"></i> {{ trans('nodes.add_child') }}</a>
        </li>
        @endif

        @if ($node->isLocked())
            <li>
                <span class="disabled">
                     <i class="icon-trash"></i> {{ trans('nodes.delete') }}</span>
                </span>
            </li>
        @else
        <li
            class="node-option-deletable"
            data-action="{{ route('reactor.contents.destroy', [$node->getKey(), 'self']) }}"
            data-method="DELETE"
            data-type="node">
            <span class="option-delete">
                <i class="icon-trash"></i> {{ trans('nodes.delete') }}</span>
        </li>
        @endif

        <li class="options-splitter"></li>

        @if ($node->isLocked())
            <li>
                <span class="disabled">
                      <i class="icon-exchange"></i> {{ trans('nodes.transform') }}</span>
                </span>
            </li>
        @else
        <li>
            <a href="{{ route('reactor.contents.transform', [$node->getKey(), $source->getKey()]) }}">
                <i class="icon-exchange"></i> {{ trans('nodes.transform') }}</a>
        </li>
        @endif

        @if (isset($translated) && $translated)
            @if ($node->isLocked() || count($node->translations) === 1)
                <li>
                    <span class="disabled">
                          <i class="icon-language"></i> {{ trans('nodes.delete_translation') }}</span>
                    </span>
                </li>
            @else
                <li
                    class="node-option-deletable"
                    data-action="{{ route('reactor.contents.translation.destroy', $source->getKey()) }}"
                    data-method="DELETE"
                    data-type="translation">
                    <span class="option-delete">
                        <i class="icon-language"></i> {{ trans('nodes.delete_translation') }}</span>
                </li>
            @endif
        @endif

        <li class="options-splitter"></li>

        @if ($node->isPublished())
        <li
            class="node-option-formable"
            data-action="{{ route('reactor.contents.unpublish', $node->getKey()) }}"
            data-method="PUT">
            <span>
                <i class="icon-cancel-circled"></i> {{ trans('nodes.unpublish') }}</span>
        </li>
        @else
        <li
            class="node-option-formable"
            data-action="{{ route('reactor.contents.publish', $node->getKey()) }}"
            data-method="PUT">
            <span>
                <i class="icon-publish"></i> {{ trans('nodes.publish') }}</span>
            </li>
        @endif

        @if ($node->isVisible())
        <li
            class="node-option-formable"
            data-action="{{ route('reactor.contents.hide', $node->getKey()) }}"
            data-method="PUT">
            <span>
                <i class="icon-eye-off"></i> {{ trans('nodes.hide') }}</span>
            </li>
        @else
        <li
            class="node-option-formable"
            data-action="{{ route('reactor.contents.show', $node->getKey()) }}"
            data-method="PUT">
            <span>
                <i class="icon-eye"></i> {{ trans('nodes.show') }}</span>
            </li>
        @endif

        @if ($node->isLocked())
        <li
            class="node-option-formable"
            data-action="{{ route('reactor.contents.unlock', $node->getKey()) }}"
            data-method="PUT">
            <span>
                <i class="icon-lock-open"></i> {{ trans('nodes.unlock') }}</span>
        </li>
        @else
        <li
            class="node-option-formable"
            data-action="{{ route('reactor.contents.lock', $node->getKey()) }}"
            data-method="PUT">
            <span>
                <i class="icon-lock"></i> {{ trans('nodes.lock') }}</span>
        </li>
        @endif

        {!! content_options_close() !!}
    </div>

</div>