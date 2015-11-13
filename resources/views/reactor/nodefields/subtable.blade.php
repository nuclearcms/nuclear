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
                    <a href="{{ route('reactor.nodes.field.edit', $field->getKey()) }}">
                        <i class="icon-pencil"></i> {{ trans('nodes.edit_field') }}</a>
                </li>
                <li>
                    {!! delete_form(
                        route('reactor.nodes.field.destroy', $field->getKey()),
                        trans('nodes.delete_field')
                    ) !!}
                </li>
                {!! content_options_close() !!}
            </tr>
        @endforeach
    @else
        {!! no_results_row('nodes.no_fields') !!}
    @endif
{!! content_table_close(true) !!}