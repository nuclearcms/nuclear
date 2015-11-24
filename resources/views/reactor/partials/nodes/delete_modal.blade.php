@include('modal.confirm', [
    'modalTitle' => trans('general.warning'),
    'modalContent' => trans($message),
])

<script>
    var nodeModel = new Modal($('.modal-node'),
        {
            onConfirmEvent: function (dialog) {
                dialog.current.closest('form').submit();
            }
        },
        $('.nodes-list form > .option-delete'));
</script>