@foreach($subscribers as $subscriber)
    <tr class="content-list__row--body">

        {!! content_list_thumbnail($subscriber->getKey()) !!}

        <td class="content-list__cell">
            {!! link_to_route('reactor.subscribers.edit', $subscriber->email, $subscriber->getKey()) !!}
        </td>
        <td class="content-list__cell">
            {{ $subscriber->name }}
        </td>
        <td class="content-list__cell">
            {{ $subscriber->created_at->formatLocalized('%b %e, %Y') }}
        </td>

        {!! content_options('subscribers', $subscriber->getKey()) !!}

    </tr>
@endforeach