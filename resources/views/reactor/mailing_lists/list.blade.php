@foreach($mailing_lists as $mailing_list)
    <tr class="content-list__row--body">

        {!! content_list_thumbnail($mailing_list->getKey()) !!}

        <td class="content-list__cell">
            {!! link_to_route('reactor.mailing_lists.edit', $mailing_list->name, $mailing_list->getKey()) !!}
        </td>
        <td class="content-list__cell">
            {{ $mailing_list->created_at->formatLocalized('%b %e, %Y') }}
        </td>

        {!! content_options('mailing_lists', $mailing_list->getKey()) !!}

    </tr>
@endforeach