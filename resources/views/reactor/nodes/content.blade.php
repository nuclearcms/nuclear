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
        {!! content_options_close() !!}
    </tr>
@endforeach