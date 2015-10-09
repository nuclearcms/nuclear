@extends('layout.content')

@section('pageTitle', trans('users.manage'))
@section('contentSubtitle', uppercase(trans('users.title')))

@section('action')
    <a href="/reactor/users/create" class="button button-emphasized button-icon-primary">
        <i class="icon-user-add"></i>
    </a>
@endsection

@section('content_options')
    @include('partials.content.search', ['placeholder' => trans('users.search')])
@endsection

@section('content_sortable_links')
    <th>
        {!! sortable_link('first_name', uppercase(trans('users.name'))) !!}
    </th>
    <th class="content-column-hidden">
        {!! sortable_link('email', uppercase(trans('validation.attributes.email'))) !!}
    </th>
    <th class="content-column-hidden">
        {!! sortable_link('created_at', uppercase(trans('users.joined_at'))) !!}
    </th>
@endsection

@section('content_list')
    @include('users.content')
@endsection

@section('content_footer')
    @include('partials.pagination', ['pagination' => $users])
@endsection

@section('modules')
    @include('modal.confirm', [
        'modalTitle' => trans('general.warning'),
        'modalContent' => trans('users.confirm_delete')
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