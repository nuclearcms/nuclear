{!! content_table_open(true) !!}
<th class="content-list__cell content-list__cell--head">
    {{ uppercase(trans('nodefields.self')) }}
</th>
<th class="content-list__cell content-list__cell--head">
    {{ uppercase(trans('validation.attributes.type')) }}
</th>
{!! content_table_middle() !!}

@if($fields->count())
    @foreach ($fields as $field)
        <tr class="content-list__row--body">

            <td class="content-list__cell">
                {!! link_to_route('reactor.nodefields.edit', $field->label, $field->getKey()) !!}
            </td>
            <td class="content-list__cell">
                {{ $field->type }}
            </td>

            {!! content_options('nodefields', $field->getKey()) !!}

        </tr>
    @endforeach
@else
    {!! no_results_row('nodetypes.no_fields') !!}
@endif

{!! content_table_close(true) !!}