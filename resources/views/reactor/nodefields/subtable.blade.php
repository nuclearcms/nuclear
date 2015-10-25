{!! content_table_open(true) !!}
    <th>{{ uppercase(trans('nodes.field')) }}</th>
    <th>{{ uppercase(trans('validation.attributes.type')) }}</th>
{!! content_table_middle() !!}
    @if($fields->count())
        @foreach ($fields as $field)
            <tr class="content-item">
                <td>
                    {!! link_to_route('reactor.nodes.field.edit', $field->label, $field->getKey()) !!}
                </td>
                <td>
                    {{ $field->type }}
                </td>
                {!! content_options_open() !!}
                <li>
                    {!! link_to_route('reactor.nodes.field.edit', 'nodes.edit_field', $field->getKey()) !!}
                </li>
                <li>
                    {!! delete_form(
                        $route,
                        trans('nodes.delete_field'),
                        '<input type="hidden" name="field" value="' . $field->getKey() . '">'
                    ) !!}
                </li>
                {!! content_options_close() !!}
            </tr>
        @endforeach
    @else
        {!! no_results_row('nodes.no_fields') !!}
    @endif
{!! content_table_close(true) !!}