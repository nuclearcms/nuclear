<div class="content-form content-form-sub">
    <h3>{{ trans('users.add_a_role') }}</h3>
    {!! form_start($form) !!}
    {!! form_rest($form) !!}
    {!! submit_button('icon-plus', 'users.add_role') !!}
    {!! form_end($form) !!}
</div>