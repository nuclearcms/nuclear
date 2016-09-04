@section('scripts')
    @parent

    {!! Theme::js('js/tags.js') !!}
    {!! Theme::js('js/uploader.js') !!}
    <script>window.editorTooltips = JSON.parse('{!! json_encode(trans('general.tooltips')) !!}');</script>
    {!! Theme::js('js/nodesforms.js') !!}
@endsection

@section('modules')
    @parent

    @include('documents.library')
    @include('partials.modals.editor')
@endsection