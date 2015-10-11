<div class="content-form content-form-sub">
    <h3>{{ trans('users.add_an_user') }}</h3>
    {!! form_start($form) !!}
    {!! form_rest($form) !!}
    {!! submit_button('icon-user-add', 'users.add_user') !!}
    {!! form_end($form) !!}
</div>