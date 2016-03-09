@extends('layout.form')

@section('scripts')
    @parent

    <script>
        $(document).ready(function () {
            var deleteDialog = new Modal($('.modal-node-options'),
                {
                    onOpenEvent : function(dialog) {
                        dialog.el.find('.node-option-message').removeClass('active');
                        dialog.el.find('.node-option-message.' + dialog.current.data('type')).addClass('active');
                    },
                    onConfirmEvent : function(dialog) {
                        var form = create_form_from(dialog.current)
                        append_and_submit_form(form);
                    }
                },
                $('.node-option-deletable'));
        });
    </script>
@endsection

@section('modules')
    @parent

    @include('partials.nodes.options_modal', [
        'containerClass' => 'modal-node-options'
    ])
@endsection