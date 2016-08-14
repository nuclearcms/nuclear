<div class="content-inner__row">
    <h3 class="content-inner__heading">{{ trans('roles.associate') }}</h3>
    {!! form_start($form) !!}
    {!! form_rest($form) !!}
    {!! submit_button('icon-plus', trans('roles.associate')) !!}
    {!! form_end($form) !!}
</div>