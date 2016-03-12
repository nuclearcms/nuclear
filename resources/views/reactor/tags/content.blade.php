@foreach($tags as $tag)
    <tr class="content-item">
        <td class="content-item-thumbnail">

        </td>
        <td>
            {!! link_to_route('reactor.tags.edit', $tag->name, [$tag->getKey(), $tag->translate()->getKey()]) !!}
        </td>
        <td class="content-column-hidden">
            {{ $tag->created_at->formatLocalized('%b %e, %Y') }}
        </td>

        {!! content_options_open() !!}
        <li>
            <a href="{{ route('reactor.tags.edit', [$tag->getKey(), $tag->translate()->getKey()]) }}">
                <i class="icon-pencil"></i> {{ trans('tags.edit') }}</a>
        </li>
        <li>
            {!! delete_form(
                route('reactor.tags.destroy', $tag->getKey()),
                trans('tags.delete')
            ) !!}
        </li>
        {!! content_options_close() !!}

    </tr>
@endforeach