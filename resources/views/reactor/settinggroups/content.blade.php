@foreach($groups as $key => $group)
    <tr class="content-item">
        <td class="content-item-thumbnail">

        </td>
        <td>
            {!! link_to_route('reactor.settinggroups.edit', $group, $key) !!}
        </td>
        {!! content_options_open() !!}
        <li>
            <a href="{{ route('reactor.settinggroups.edit', $key) }}">
                <i class="icon-pencil"></i> {{ trans('settings.edit_group') }}</a>
        </li>
        <li>
            {!! delete_form(
                route('reactor.settinggroups.destroy', $key),
                trans('settings.delete_group')
            ) !!}
        </li>
        {!! content_options_close() !!}
    </tr>
@endforeach