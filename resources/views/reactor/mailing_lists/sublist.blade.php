{!! content_table_open(true) !!}
<th class="content-list__cell content-list__cell--head">
    {{ uppercase(trans('mailing_lists.self')) }}
</th>
<th class="content-list__cell content-list__cell--head">
    {{ uppercase(trans('validation.attributes.created_at')) }}
</th>
{!! content_table_middle() !!}

@if($mailing_lists->count())
    @foreach ($mailing_lists as $mailing_list)
        <tr class="content-list__row--body">

            <td class="content-list__cell">
                {!! link_to_route('reactor.mailing_lists.edit', $mailing_list->name, $mailing_list->getKey()) !!}
            </td>
            <td class="content-list__cell">
                {{ $mailing_list->created_at->formatLocalized('%b %e, %Y') }}
            </td>

            {!! content_options_open() !!}
            <li class="dropdown-sub__item dropdown-sub__item--delete">
                {!! delete_form(
                    $dissociateRoute,
                    trans('mailing_lists.dissociate'),
                    '<input type="hidden" name="list" value="' . $mailing_list->getKey() . '">',
                    true
                ) !!}
            </li>
            {!! content_options_close() !!}

        </tr>
    @endforeach
@else
    {!! no_results_row('mailing_lists.no_mailing_lists') !!}
@endif

{!! content_table_close(true) !!}