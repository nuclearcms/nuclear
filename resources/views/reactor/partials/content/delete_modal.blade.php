@section('modules')
    @include('modal.confirm', [
        'modalTitle' => trans('general.warning'),
        'modalContent' => trans($message)
    ])
@endsection

@section('scripts')
    <script>
        var deleteDialog = new Modal($('.modal-content'),
            {
                onConfirmEvent : function(dialog) {
                    dialog.current.closest('form').submit();
                }
            },
            $('.container-content form > .option-delete'));
    </script>
@endsection