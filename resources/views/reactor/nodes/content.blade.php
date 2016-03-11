<?php
    $thumbnails = isset($thumbnails) ? $thumbnails : true;
    $locale = isset($locale) ? $locale : null;
?>

@foreach($nodes as $node)
    <tr class="content-item">
        @if ($thumbnails)
        <td class="content-item-thumbnail">

        </td>
        @endif
        <td>
            {!! link_to_route('reactor.contents.edit', $node->translate($locale)->title, [$node->getKey(), $node->translate($locale)->getKey()]) !!}
        </td>
        <td class="content-column-hidden">
            {{ $node->nodeType->label }}
        </td>
        <td>
            {{ $node->created_at->formatLocalized('%b %e, %Y') }}
        </td>
        {!! content_options_open() !!}

        @if ($node->canHaveChildren())
        <li>
            <a href="{{ route('reactor.contents.create', $node->getKey()) }}">
                <i class="icon-plus"></i> {{ trans('nodes.add_child') }}</a>
        </li>
        @endif

        <li>
            <a href="{{ route('reactor.contents.edit', $node->getKey()) }}">
                <i class="icon-pencil"></i> {{ trans('nodes.edit') }}</a>
        </li>
        <li>
            {!! delete_form(
                route('reactor.contents.destroy', $node->getKey()),
                trans('nodes.delete')
            ) !!}
        </li>

        <li class="options-splitter"></li>

        <li>{!! node_option_form(
                $node->isPublished() ? route('reactor.contents.unpublish', $node->getKey()) : route('reactor.contents.publish', $node->getKey()),
                $node->isPublished() ? 'icon-cancel-circled' : 'icon-publish',
                $node->isPublished() ? 'nodes.unpublish' : 'nodes.publish'
        ) !!}</li>
        <li>{!! node_option_form(
                $node->isVisible() ? route('reactor.contents.hide', $node->getKey()) : route('reactor.contents.show', $node->getKey()),
                $node->isVisible() ? 'icon-eye-off' : 'icon-eye',
                $node->isVisible() ? 'nodes.hide' : 'nodes.show'
        ) !!}</li>
        <li>{!! node_option_form(
                $node->isLocked() ? route('reactor.contents.unlock', $node->getKey()) : route('reactor.contents.lock', $node->getKey()),
                $node->isLocked() ? 'icon-lock-open' : 'icon-lock',
                $node->isLocked() ? 'nodes.unlock' : 'nodes.lock'
        ) !!}</li>

        {!! content_options_close() !!}
    </tr>
@endforeach