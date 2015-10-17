@foreach($groups as $key => $group)
    <tr class="content-item">
        <td class="content-item-thumbnail">

        </td>
        <td>
            <a href="{{ route('reactor.settinggroups.edit', $key) }}">
                @if(trans()->has('settings.' . $key))
                    @trans('settings.' . $key)
                @else
                    {{ $group }}
                @endif
            </a>
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