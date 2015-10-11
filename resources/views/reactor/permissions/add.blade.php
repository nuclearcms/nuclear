<div class="content-form content-form-sub">
    <h3>{{ trans('users.add_a_permission') }}</h3>
    {!! form_start($form) !!}
    {!! form_rest($form) !!}
    {!! submit_button('icon-list-add', 'users.add_permission') !!}
    {!! form_end($form) !!}
</div>