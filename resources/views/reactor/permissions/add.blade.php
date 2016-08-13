<div class="content-inner__row">
    <h3 class="content-inner__heading">{{ trans('permissions.add_permission') }}</h3>
    {!! form_start($form) !!}
    {!! form_rest($form) !!}
    {!! submit_button('icon-plus', trans('permissions.add_permission')) !!}
    {!! form_end($form) !!}
</div>