@section('modules')
    @include('modal.confirm', [
        'modalTitle' => trans('general.warning'),
        'modalContent' => trans($message)
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