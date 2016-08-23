@section('modules')
    @include('partials.modals.confirm', [
        'modalTitle' => trans('general.warning'),
        'modalContent' => isset($message) ? $message : trans('general.confirm_delete')
    ])
@endsection

@section('scripts')
    <script>
        window.deleteModal = new Modal($('.modal--content'),
            {
                onConfirmEvent : function(dialog) {
                    dialog.current.closest('form').submit();
                }
            },
            $('.delete-form > .option-delete, .header__action--bulk .button--bulk-delete'));
    </script>
@endsection