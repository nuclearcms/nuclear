@foreach($settings as $key => $setting)
    <tr class="content-item">
        <td class="content-item-thumbnail">

        </td>
        <td>
            {!! link_to_route('reactor.settings.edit',
            (trans()->has('settings.key_' . $key)) ? trans('settings.key_' . $key) : $key,
            $key) !!}
        </td>
        <td>
            {{ $key }}
        </td>
        <td>
            {{ trans('settings.type_' . $setting['type']) }}
        </td>
        {!! content_options_open() !!}
        <li>
            <a href="{{ route('reactor.settings.edit', $key) }}">
                <i class="icon-pencil"></i> {{ trans('settings.edit') }}</a>
        </li>
        <li>
            {!! delete_form(
                route('reactor.settings.destroy', $key),
                trans('settings.delete')
            ) !!}
        </li>
        {!! content_options_close() !!}
    </tr>
@endforeach