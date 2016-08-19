@extends('layout.reactor')

@section('pageSubtitle')
    {!! link_to_route('reactor.documents.index', uppercase(trans('documents.title'))) !!}
@endsection

@section('content')
    <form class="dropzone" id="dropzone"
          enctype="multipart/form-data" method="POST"
          action="{{ route('reactor.documents.store') }}"
          data-maxsize="{{ max_upload_size() }}">

        <h2 class="dropzone__heading">DROPZONE</h2>
        <p class="dropzone__message">{!! trans('documents.drop_to_upload') !!}</p>

        <input type="file" id="dropzoneFile" class="dropzone__file" multiple="multiple">

        {!! button('icon-document-upload', trans('documents.select_to_upload'), 'button', 'button--emphasis dropzone__button', 'l') !!}

        <p class="dropzone__message dropzone__message--muted">
            <strong>{{ trans('documents.allowed_extensions') }}:</strong> {{ allowed_extensions(', ') }}
        </p>
        <p class="dropzone__message dropzone__message--muted">
            <strong>{{ trans('documents.max_size') }}:</strong> {{ readable_size(max_upload_size()) }}
        </p>
    </form>
    <div class="documents-list-container">
        <ul class="documents-list uploads-list" id="uploadsList">

        </ul>
    </div>
@endsection

@section('scripts')
    {!! Theme::js('js/uploader.js') !!}
    <script>
        $(document).ready(function () {
            var uploader = new Uploader($('#dropzone'), {
                selectButton: '#dropzone > .dropzone__button',
                uploadInput: '#dropzoneFile',
                outputList: '#uploadsList'
            });
        });
    </script>
@endsection