@section('modules')
    @parent

    @include('partials.modals.confirm', [
        'modalTitle' => trans('general.warning'),
        'modalContent' => isset($message) ? $message : trans('general.confirm_delete'),
        'containerClass' => 'modal--specific'
    ])
@endsection

@section('scripts')
    @parent

    <script>
        var specificModal = new Modal($('.modal--specific'),
            {
                onConfirmEvent : function(dialog) {
                    dialog.current.closest('form').submit();
                }
            },
            $('.delete-form-specific > .option-delete'));
    </script>
@endsection