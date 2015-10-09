@extends('layout.content')

@section('pageTitle', trans('users.manage_roles'))
@section('contentSubtitle', uppercase(trans('users.roles')))

@section('action')
    <a href="/reactor/roles/create" class="button button-emphasized button-icon-primary">
        <i class="icon-plus"></i>
    </a>
@endsection

@section('content_options')
    @include('partials.content.search', ['placeholder' => trans('users.search_roles')])
@endsection

@section('content_sortable_links')
    <th>
        {!! sortable_link('label', uppercase(trans('validation.attributes.label'))) !!}
    </th>
    <th>
        {!! sortable_link('name', uppercase(trans('validation.attributes.name'))) !!}
    </th>
@endsection

@section('content_list')
    @include('roles.content')
@endsection

@section('content_footer')
    @include('partials.pagination', ['pagination' => $roles])
@endsection

@section('modules')
    @include('modal.confirm', [
        'modalTitle' => trans('general.warning'),
        'modalContent' => trans('users.confirm_delete_role')
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