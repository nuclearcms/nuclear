<form id="dropzone" class="dropzone" enctype="multipart/form-data" action="{{ route('reactor.documents.store') }}" method="post" data-maxsize="{{ max_upload_size() }}" data-editroute="{{ route('reactor.documents.edit') }}">
    {!! csrf_field() !!}

    <div class="dropzone-container">
        <h3>DROPZONE</h3>

        <p class="dropzone-message">
            {{ trans('documents.drop') }}
        </p>
        <p class="dropzone-message dropzone-message-muted">
            {{ trans('general.or') }}
        </p>


        <input type="file" id="dropzone-file" class="dropzone-file" multiple="multiple">

        <button class="button button-emphasized button-dropzone" id="dropzone-select-button">
            <i class="icon-upload-cloud"></i> {{ uppercase(trans('documents.select')) }}
        </button>

        <p class="dropzone-rule">
            {{ trans('documents.allowed_extensions') }}: <strong>{{ allowed_extensions(', ') }}</strong>
        </p>
        <p class="dropzone-rule">
            {{ trans('documents.max_size') }}: <strong>{{ readable_size(max_upload_size()) }}</strong>
        </p>
    </div>

</form>

<ul id="upload-list" class="upload-list">

</ul>