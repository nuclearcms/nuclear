<div class="modal modal--library" id="libraryModal"
     data-retrieveurl="{{ route('reactor.documents.retrieve') }}"
     data-loadurl="{{ route('reactor.documents.load') }}"
     data-locale="{{ env('REACTOR_LOCALE') }}"
     data-locales="{{ json_encode(locales()) }}">

    <form class="dropzone dropzone--library" id="libraryDropzone"
         enctype="multipart/form-data" method="POST"
         action="{{ route('reactor.documents.store') }}"
         data-maxsize="{{ max_upload_size() }}">
        <i class="icon-upload dropzone__icon"></i>
    </form>

    <div class="modal__whiteout">
        <div class="modal__inner library">

            <i class="library__close icon-cancel"></i>

            <div class="library__columns">
                <div class="library-column library-column--documents">
                    <h3 class="library-column__heading">{{ uppercase(trans('documents.title')) }}</h3>

                    <div class="library-column__toolbar">
                        <div class="form-group__select header__select library-column__tool library-column__tool--filter">
                            <?php
                            $filterTypes = ['all', 'audio', 'document', 'image', 'video', 'embedded']
                            ?>
                            <select name="_filter" id="libraryFilter">
                                @foreach($filterTypes as $filter)
                                    <option value="{{ $filter }}">{{ trans('documents.filter_' . $filter) }}</option>
                                @endforeach
                            </select>
                            <i class="icon-arrow-down"></i>
                        </div><form class="header__search library-column__tool" method="GET" action="{{ route('reactor.documents.search.json') }}" id="librarySearch">
                            <i class="icon-search"></i>
                            <input type="search" name="q" placeholder="{{ trans('documents.search') }}..." autocomplete="off">
                        </form>
                    </div>

                    <div class="scroller library-column__inner library-column__inner--documents">
                        <ul class="library-documents" id="libraryDocuments">

                        </ul>
                    </div>

                    <div class="library-column__message-container" id="libraryDocumentsMessage">
                        <p class="library-column__message">{{ trans('documents.no_documents') }}</p>
                        <p class="library-column__message library-column__message--muted">{{ trans('documents.drop_images_to_upload') }}</p>
                    </div>

                    <div class="library-column__blackout" id="libraryDocumentsBlackout"></div>
                </div><div class="library-column library-column--details">
                    <h3 class="library-column__heading library-column__heading--details">{{ uppercase(trans('documents.details')) }}</h3>

                    <div class="scroller library-column__inner">
                        <div class="library-details library-details--empty">
                            <div class="library-details__content">
                                <div class="library-details__header" id="libraryDetails">

                                </div>
                                <div class="library-details__translations" id="libraryTranslations">
                                    @if(locale_count() > 1)
                                    <ul class="compact-tabs">
                                        <?php $i = 0; ?>
                                        @foreach(locales() as $locale)
                                        <li class="compact-tabs__tab compact-tabs__tab--{{ $locale }}{{ $i === 0 ? ' compact-tabs__tab--active' : '' }}" data-locale="{{ $locale }}">
                                            {{ uppercase($locale) }}</li>
                                            <?php $i++; ?>
                                        @endforeach
                                    </ul>
                                    @endif

                                    <form id="libraryTranslationsForm" method="POST" action="{{ route('reactor.documents.update.json') }}">
                                        <input type="hidden" name="document" val="">

                                        <div class="sub-tabs">
                                            <?php $i = 0; ?>
                                            @foreach(locales() as $locale)
                                            <div class="sub-tab sub-tab--{{$locale}}{{ $i === 0 ? ' sub-tab--active' : '' }}" data-locale="{{ $locale }}">

                                                {!! field_wrapper_open([], "{$locale}[caption]", $errors, 'form-group--inverted') !!}
                                                    {!! field_label(true, ['label' => trans('validation.attributes.caption')], "{$locale}[caption]", $errors) !!}
                                                    {!! Form::text("{$locale}[caption]") !!}
                                                </div>

                                                {!! field_wrapper_open([], "{$locale}[description]", $errors, 'form-group--inverted') !!}
                                                    {!! field_label(true, ['label' => trans('validation.attributes.description')], "{$locale}[description]", $errors) !!}
                                                    {!! Form::textarea("{$locale}[description]") !!}
                                                </div>

                                                {!! field_wrapper_open([], "{$locale}[alttext]", $errors, 'form-group--inverted') !!}
                                                    {!! field_label(true, ['label' => trans('validation.attributes.alttext')], "{$locale}[alttext]", $errors) !!}
                                                    {!! Form::text("{$locale}[alttext]") !!}
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            @endforeach
                                        </div>

                                        {!! submit_button('icon-floppy', trans('general.save_changes'), 'button--plain', 'l') !!}
                                    </form>

                                </div>
                            </div>
                            <div class="library-details__empty-message">
                                {{ trans('documents.no_document_selected') }}
                            </div>
                        </div>
                    </div>

                    <div class="library-column__blackout library-column__blackout--details" id="libraryDetailsBlackout"></div>
                </div>
            </div>
            <div class="library-footer">
                <div class="library-footer__indicator">
                    <h4 class="library-footer__header">{{ uppercase(trans('documents.title')) }}</h4>
                    <p class="library-footer__total"><span id="libraryTotal">0</span> {{ trans('general.selected') }}.</p>
                </div>
                <div class="library-footer__selected-container scroller">
                    <ul class="library-footer__selected" id="librarySelected"></ul>
                </div>
                <div class="library-footer__buttons" id="libraryButtons">
                    {!! button('', trans('general.clear'), 'button', 'button--clear') !!}{!! button('icon-plus', trans('general.insert'), 'button', 'button--emphasis button--insert') !!}
                </div>
            </div>
        </div>
    </div>
</div>