<div id="modalEditor" class="modal-container modal-editor">
    <div class="blackout">
        <div class="modal modal-notice">

            <div class="editor-modal-tab editor-modal-library">
                <h4>{{ trans('nodes.add_media') }}</h4>
                <p>{{ trans('nodes.choose_media_mode') }}</p>

                <div class="modal-content">
                    <div class="buttons">
                        <button class="button button-emphasized button-add editor-modal-gallery-button">
                            {{ uppercase(trans('documents.gallery')) }} <i class="icon-doc"></i>
                        </button> <button class="button button-emphasized button-add editor-modal-document-button">
                            {{ uppercase(trans('documents.document')) }} <i class="icon-docs"></i>
                        </button>
                    </div>

                    <p class="or">{{ trans('general.or') }}</p>
                    <p class="description">{{ trans('nodes.enter_image_info') }}</p>

                    <div class="form-group">
                        <label class="control-label" for="_src">
                            {{ trans('validation.attributes.source') }}
                        </label>
                        <input type="text" name="_src" id="_src">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="_alt">
                            {{ trans('validation.attributes.alt') }}
                        </label>
                        <input type="text" name="_alt" id="_alt">
                    </div>
                </div>
            </div>

            <div class="editor-modal-tab editor-modal-link">
                <h4>{{ trans('nodes.add_link') }}</h4>
                <p>{{ trans('nodes.enter_link_info') }}</p>

                <div class="modal-content">
                    <div class="form-group">
                        <label class="control-label" for="_link">
                            {{ trans('validation.attributes.url') }}
                        </label>
                        <input type="text" name="_link" id="_link">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="_text">
                            {{ trans('validation.attributes.text') }}
                        </label>
                        <input type="text" name="_text" id="_text">
                    </div>
                    <div class="form-group">
                        <div class="control-label">{{ trans('nodes.open_in_newpage') }}</div>
                        <label class="button form-checkbox">
                            <input type="checkbox" name="_newpage" id="_newpage">
                            <span>
                                <i class="icon-cancel">{{ trans('general.no') }}</i><i class="icon-check">{{ trans('general.yes') }}</i>
                            </span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="modal-buttons">
                <button class="button close-button">
                    {{ uppercase(trans('general.dismiss')) }}
                </button>
                <button class="button button-emphasized confirm-button">
                    {{ uppercase(trans('general.insert')) }}
                </button>
            </div>
        </div>
    </div>
</div>