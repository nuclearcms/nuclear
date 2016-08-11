@extends('layout.content')

@section('pageSubtitle', uppercase(trans('permissions.title')))

@section('actions')
    @include('partials.contents.search', ['key' => 'permissions'])
    @include('partials.contents.bulk', ['key' => 'permissions'])

    @can('EDIT_PERMISSIONS')
    {!! header_action_open('permissions.new', 'header__action--right') !!}
        {!! action_button(route('reactor.permissions.create'), 'icon-plus') !!}
    {!! header_action_close() !!}
    @endcan
@endsection

@section('content_sortable_links')
    <th class="content-list__cell content-list__cell--head">
        {!! sortable_link('name', uppercase(trans('validation.attributes.name'))) !!}
    </th>
@endsection

@section('content_list')
    @include('permissions.content')
@endsection

@section('content_footer')
    @include('partials.contents.pagination', ['paginator' => $permissions])
@endsection

@include('partials.modals.delete')