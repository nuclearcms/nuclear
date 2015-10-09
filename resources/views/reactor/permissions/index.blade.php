@extends('layout.content')

@section('pageTitle', trans('users.manage_permissions'))
@section('contentSubtitle', uppercase(trans('users.permissions')))

@section('action')
    <a href="/reactor/permissions/create" class="button button-emphasized button-icon-primary">
        <i class="icon-list-add"></i>
    </a>
@endsection

@section('content_options')
    @include('partials.content.search', ['placeholder' => trans('users.search_permissions')])
@endsection

@section('content_sortable_links')
    <th>
        {!! sortable_link('name', uppercase(trans('validation.attributes.name'))) !!}
    </th>
@endsection

@section('content_list')
    @include('permissions.content')
@endsection

@section('content_footer')
    @include('partials.pagination', ['pagination' => $permissions])
@endsection

@section('modules')
    @include('modal.confirm', [
        'modalTitle' => trans('general.warning'),
        'modalContent' => trans('users.confirm_delete_permission')
    ])
@endsection

@section('scripts')
    <script>
        var deleteDialog = new Modal($('.modal-container'),
            {
                onConfirmEvent : function(dialog) {
                    dialog.current.closest('form').submit();
                }
            },
            $('form > .option-delete'));
    </script>
@endsection