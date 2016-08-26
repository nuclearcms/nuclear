{!! content_options_open(null, false) !!}

@if($node->canHaveChildren())
<li class="dropdown-sub__item">
    <a href="{{ route('reactor.nodes.create', $node->getKey()) }}">
        <i class="icon-plus"></i>{{ trans('nodes.add_child') }}</a>
</li>
<li class="dropdown-sub__splitter"></li>
@endif

@if($node->canHaveMoreTranslations())
<li class="dropdown-sub__item">
    <a href="{{ route('reactor.nodes.translation.create', [$node->getKey(), $source->getKey()]) }}">
        <i class="icon-language"></i>{{ trans('general.add_translation') }}</a>
</li>
@endif

<li class="dropdown-sub__splitter"></li>
<li class="dropdown-sub__item">{!! node_option_form(
    $node->isPublished() ? route('reactor.nodes.unpublish', $node->getKey()) : route('reactor.nodes.publish', $node->getKey()),
    $node->isPublished() ? 'icon-status-withheld' : 'icon-status-published',
    $node->isPublished() ? 'nodes.unpublish' : 'nodes.publish'
    ) !!}</li>
<li class="dropdown-sub__item">{!! node_option_form(
    $node->isLocked() ? route('reactor.nodes.unlock', $node->getKey()) : route('reactor.nodes.lock', $node->getKey()),
    $node->isLocked() ? 'icon-status-unlocked' : 'icon-status-locked',
    $node->isLocked() ? 'nodes.unlock' : 'nodes.lock'
    ) !!}</li>
<li class="dropdown-sub__item">{!! node_option_form(
    $node->isVisible() ? route('reactor.nodes.hide', $node->getKey()) : route('reactor.nodes.show', $node->getKey()),
    $node->isVisible() ? 'icon-status-invisible' : 'icon-status-visible',
    $node->isVisible() ? 'nodes.hide' : 'nodes.show'
    ) !!}</li>

{!! content_options_close(false) !!}
MOVE
TRANSFORM
ADDING / DELETING TRANSLATIONS
APPEND AND SUBMIT FORM