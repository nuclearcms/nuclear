<div id="library-modal-container" class="modal-container library-modal-container"
     data-retrieveurl="{{ route('reactor.documents.json.index') }}">

    <form id="library-modal-dropzone" class="library-modal-dropzone"
          enctype="multipart/form-data"
          action="{{ route('reactor.documents.store') }}"
          method="post" data-maxsize="{{ max_upload_size() }}">

        <p>
            <i class="icon-upload-cloud"></i>
            <br>
            {{ trans('documents.drop') }}
        </p>
    </form>

    <div class="blackout">
        <div id="library-modal" class="library-modal">
            <div class="library-modal-header">
                <h2 class="library-modal-heading-document">
                    {{ uppercase(trans('documents.add_document')) }}</h2>
                <h2 class="library-modal-heading-gallery">
                    {{ uppercase(trans('documents.add_gallery')) }}</h2>

                <span id="library-modal-close" class="library-modal-close">
                    <i class="icon-cancel"></i>
                </span>
            </div>

            <div id="library-modal-columns" class="library-modal-columns">
                <div class="library-modal-column column-media-list">
                    <h3>{{ uppercase(trans('documents.title')) }}</h3>

                    <form id="library-modal-search" class="library-modal-search" action="{{ route('reactor.documents.json.search') }}">
                        <div class="form-group form-group-icon-label">
                            <input type="search" name="q" id="q" placeholder="{{ trans('general.search') }}" required>
                            <label class="icon-label" for="q">
                                <i class="icon-search"></i>
                            </label>
                        </div>
                    </form>

                    <div class="scroller-container-library">
                        <div class="scroller-library">
                            <ul id="library-modal-media-list" class="library-modal-media-list">

                            </ul>

                            <div id="library-modal-disabler" class="library-modal-disabler"></div>

                            <div id="library-modal-noresults" class="library-modal-noresults">
                                <div>
                                    <h4>{{ trans('general.search_no_results') }}</h4>
                                    <p>{{ trans('documents.drop') }}.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><button class="library-modal-scroll-button right">
                    <i class="icon-right-open-big"></i>
                </button><button class="library-modal-scroll-button left">
                    <i class="icon-left-open-big"></i>
                </button><div class="library-modal-column column-media-detail">
                    <h3>{{ uppercase(trans('documents.details')) }}</h3>
                    <div data-id="" class="library-modal-media-detail" id="library-modal-media-detail">
                        <div class="library-modal-media-tag">
                            <div class="media-name-tag">
                                <h4 class="media-name"></h4>
                                <p class="media-detail"></p>
                            </div><div class="media-thumbnail">

                            </div>
                        </div>
                        <div class="library-modal-media-none">
                            <p>{{ trans('documents.no_media_selected') }}</p>
                        </div>
                    </div>
                </div><div class="library-modal-column column-media-gallery">
                    <h3>{{ uppercase(trans('documents.gallery')) }}</h3>
                    <p class="library-modal-gallery-hint">{{ trans('documents.gallery_dnd') }}</p>

                    <ul id="library-modal-gallery-sortable" class="library-modal-gallery-sortable">

                    </ul>
                </div>
            </div>

            <div class="library-modal-footer">
                <div id="library-modal-gallery-selected" class="library-modal-gallery-selected">
                    <span>0</span> {{ trans('documents.selected') }}.
                    <a href="#" id="library-modal-clear" class="library-modal-clear">{{ trans('general.clear') }}</a>
                </div>
                <button id="library-modal-insert" class="button button-emphasized button-icon">
                    {{ uppercase(trans('general.insert')) }} <i class="icon-plus"></i>
                </button><button id="library-modal-remove" class="button button-emphasized button-icon button-clear">
                    {{ uppercase(trans('general.clear')) }} <i class="icon-trash"></i>
                </button>
            </div>
        </div>
    </div>

</div>