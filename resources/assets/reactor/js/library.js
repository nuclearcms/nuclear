;(function (window) {
    'use strict';

    /**
     * DocumentsLibrary Constructor
     */
    function DocumentsLibrary(el, documentsBag) {
        this.el = el;
        this.documentsBag = documentsBag;

        this._init();
    }

    // Prototype
    DocumentsLibrary.prototype = {
        _init: function () {
            this.documentsList = this.el.find('ul.library-documents');
            this.documentDetails = this.el.find('div.library-details');

            this.detailsHeader = $('#libraryDetails');
            this.detailsTranslations = $('#libraryTranslations');
            this.detailsTranslationsForm = $('#libraryTranslationsForm');

            this.search = $('#librarySearch');
            this.selected = $('#librarySelected');
            this.total = $('#libraryTotal');

            this.documentsBlackout = $('#libraryDocumentsBlackout');
            this.detailsBlackout = $('#libraryDetailsBlackout');

            this.detailsFlaps = this.detailsTranslations.find('li.compact-tabs__tab');
            this.detailsTabs = this.detailsTranslations.find('div.sub-tab');

            this.detailsurl = this.detailsTranslationsForm.attr('action');
            this.retrieveurl = this.el.data('retrieveurl');
            this.loadurl = this.el.data('loadurl');
            this.searchurl = this.search.attr('action');
            this.locale = this.el.data('locale');
            this.locales = this.el.data('locales');

            this.modal = new Modal(this.el);

            this.controller = null;

            this.searchActive = false;
            this.isBooted = false;
            this.mode = null;
            this.masterFilter = null;
            this.currentFilter = null;
            this.lastValue = null;

            this.offset = 0;
            this.take = 30;
            this.isLoading = false;
            this.canLoadMode = true;

            this._initUploader();

            this._initEvents();
        },
        _initUploader: function () {
            var self = this;

            this.dropzone = $('#libraryDropzone');

            this.el.on("dragenter dragover", function (e) {
                e.preventDefault();
                e.stopPropagation();

                self.dropzone.addClass('dropzone--library-focus dropzone--focus');
            });

            this.dropzone.on("dragleave", function () {
                $(this).removeClass('dropzone--library-focus dropzone--focus');
            });

            this.dropzone.on("drop", function (e) {
                e.preventDefault();

                $(this).removeClass('dropzone--library-focus dropzone--focus');
            });

            this.uploader = new Uploader(this.dropzone, {
                outputList: '#libraryDocuments',
                indicatorClass: 'LibraryIndicator',
                outputAppend: false
            });
        },
        _initEvents: function () {
            var self = this;

            // SELECT DOCUMENT
            this.documentsList.on('click', 'li', function () {
                var document = $(this);

                if (!document.hasClass('library-document--selected')) {
                    self.selectDocument(document);
                }

                self._showDetails(document);
            });

            // FOCUS DOCUMENT
            this.selected.on('click', 'li', function () {
                var document = self.documentsList.children('li[data-id="' + $(this).data('id') + '"]');

                self._showDetails(document);
            });

            // DESELECT DOCUMENT
            this.documentsList.on('click', '.library-document__select-label', function (e) {
                e.stopPropagation();

                var document = $(this).closest('.library-document');

                self._toggleDocument(document);

                self._showDetails(document);
            });

            // CLOSE MODAL
            this.el.find('i.library__close').on('click', function () {
                self.modal.closeModal();
            });

            // EDIT TRANSLATIONS
            this.detailsTranslationsForm.on('submit', function (e) {
                e.preventDefault();
                e.stopPropagation();

                self._editDocumentTranslations($(this).serializeArray());
            });

            // CHANGE TRANSLATION TABS
            this.detailsFlaps.on('click', function () {
                self._changeDetailsTab($(this).data('locale'));
            });

            // INSERT
            $('#libraryButtons > .button--insert').on('click', function () {
                self._insertDocuments();

                self.modal.closeModal();
            });

            // CLEAR
            $('#libraryButtons > .button--clear').on('click', function () {
                self._deselectAll();
            });

            // SEARCH
            this.search.on('submit', function (e) {
                e.preventDefault();
                e.stopPropagation();

                var search = $(this).find('input[name="q"]');

                var keywords = search.val().trim();

                self._search(keywords);
            });

            // SEARCH INPUT ESCAPE/CANCEL SEARCH
            this.search.children('input[name="q"]').on('keydown', function (e) {
                if (e.keyCode === 27) {
                    e.stopPropagation();

                    if ($(this).val().trim() === '') {
                        $(this).blur();
                    }

                    self._search('');

                    self.searchActive = false;
                }
            });

            // FILTER
            $('#libraryFilter').on('change', function () {
                if (self.masterFilter === null) {
                    self._filterDocuments($(this).val());
                }
            });

            // LOAD MORE DOCUMENTS
            this.el.find('div.library-column__inner--documents').on('scroll', function () {
                if (self.documentsList.height() - $(this).height() - $(this).scrollTop() - 300 <= 0) {
                    self._load();
                }
            });
        },
        run: function (controller) {
            this.modal.openModal();

            // Boot if not booted
            if (!this.isBooted) {
                this.isBooted = true;

                this._expandDocumentsBag();

                this._load();
            }

            var controllerDirty = false;

            // The controller changes, we need to reset some of the options
            if (this.controller !== controller) {
                this.controller = controller;
                this.mode = controller.mode;

                this._reset();
                this._setMasterFilter(controller.filter);
                this._anyDocuments();

                controllerDirty = true;
            }

            var val = this.controller.getValue();

            // Now let's select documents if necessary
            if (controllerDirty || this.lastValue !== val) {
                this._deselectAll();

                this._selectDocuments(val);

                this._initSelectedSortable();
            }

            this.lastValue = val;
        },
        _reset: function () {
            var scroller = this.documentsList.parent();

            scroller.scrollTop(0);
            scroller.perfectScrollbar('update');

            if (this.selected.hasClass('ui-sortable')) {
                this.selected.sortable('destroy');
            }

            this.documentDetails.addClass('library-details--empty');

            this._search('');
            this._filterDocuments('all');
            this._deselectAll();
            this._sortDocuments();
        },
        _setMasterFilter: function (filter) {
            if (filter === 'all') {
                this.masterFilter = null;

                this.documentsList.children('li').removeClass('library-document--force-filtered');

                this.el.find('.library-column__tool--filter').removeClass('library-column__tool--disabled');

                return;
            }

            this.masterFilter = filter;

            this.el.find('.library-column__tool--filter').addClass('library-column__tool--disabled');

            this.documentsList.children('li').addClass('library-document--force-filtered');

            this.documentsList.children('li[data-type="' + filter + '"]').removeClass('library-document--force-filtered');
        },
        _expandDocumentsBag: function () {
            var documents = this.documentsBag.getDocuments();

            for (var i in documents) {
                var document = documents[i];

                this.createDocument(document.id, document.name, document.type, document.thumbnail, true);
            }
        },
        createDocument: function (id, name, type, thumbnail, append) {
            if (this.documentsList.children('li[data-id="' + id + '"]').length > 0) {
                return;
            }

            var document = $('<li class="library-document" data-id="' + id + '" data-type="' + type + '"></li>');

            $('<div class="library-document__select-label"><i class="library-document__select-icon icon-checkbox-checked"></i><i class="library-document__select-icon icon-checkbox-unchecked"></i></div>').appendTo(document);

            $(thumbnail).appendTo(document);

            $('<p class="library-document__name">' + name + '</p>').appendTo(document);

            if (this.masterFilter !== null && this.masterFilter !== type) {
                document.addClass('library-document--force-filtered');
            }
            else if (this.currentFilter !== null && this.currentFilter !== type) {
                document.addClass('library-document--filtered');
            }

            if (append) {
                this.documentsList.append(document);
            } else {
                return document;
            }
        },
        _load: function () {
            var self = this;

            if (!self.isLoading && !self.searchActive && this.canLoadMode) {
                self.isLoading = true;

                $.getJSON(self.loadurl, {offset: self.offset}, function (response) {
                    if (response.remaining <= 0) {
                        self.canLoadMode = false;
                    }

                    self._populateLibrary(response.documents);

                    self._anyDocuments();

                    self.isLoading = false;
                    self.offset += self.take;
                });
            }
        },
        _populateLibrary: function (documents) {
            for (var i in documents) {
                var document = documents[i];

                this.createDocument(document.id, document.name, document.type, document.thumbnail, true);

                this.documentsBag.addDocument(document.id, document);
            }

            this.documentsList.parent().perfectScrollbar('update');
        },
        _sortDocuments: function () {
            this.documentsList.find('li').sort(function (a, b) {
                return +b.getAttribute('data-id') - +a.getAttribute('data-id');
            }).appendTo(this.documentsList);
        },
        _anyDocuments: function () {
            if (this.documentsList.children('li:not(.library-document--hidden,.library-document--force-filtered)').length > 0) {
                $('#libraryDocumentsMessage').removeClass('library-column__message-container--active');
            } else {
                $('#libraryDocumentsMessage').addClass('library-column__message-container--active');
            }
        },
        _filterDocuments: function (filter) {
            if (filter === 'all') {
                this.currentFilter = null;

                this.documentsList.children('li').removeClass('library-document--filtered');

                return;
            }

            this.documentsList.children('li').addClass('library-document--filtered');

            this.currentFilter = filter;

            this.documentsList.children('li[data-type="' + filter + '"]').removeClass('library-document--filtered');
        },
        _showDetails: function (document) {
            this.documentDetails.removeClass('library-details--empty');

            this.documentsList.children('li').removeClass('library-document--detailed');
            this.selected.children('li').removeClass('library-document--detailed');

            document.addClass('library-document--detailed');
            this.selected.children('li[data-id="' + document.data('id') + '"]').addClass('library-document--detailed');

            var scroller = this.documentDetails.parent();

            scroller.scrollTop(0);
            scroller.perfectScrollbar('update');

            this._populateDetails(document.data('id'));
        },
        _populateDetails: function (id) {
            var document = this.documentsBag.getDocument(id);

            this.detailsHeader.html('');

            $('<div class="library-details__preview">' + document.preview + '</div>').appendTo(this.detailsHeader);
            $('<div class="library-details__name">' + document.name + '</div>').appendTo(this.detailsHeader);
            $(document.meta).appendTo(this.detailsHeader);

            this._changeDetailsTab(this.locale);

            this._populateTranslationForm(document);
        },
        _populateTranslationForm: function (document) {
            this.detailsTranslationsForm.find('input[name="document"]').val(document.id);

            for (var i in this.locales) {
                var locale = this.locales[i],
                    translation = document[locale];

                this.detailsTranslationsForm.find('input[name="' + locale + '[caption]"]').val(translation ? translation.caption : '');
                this.detailsTranslationsForm.find('textarea[name="' + locale + '[description]"]').val(translation ? translation.description : '');
                this.detailsTranslationsForm.find('input[name="' + locale + '[alttext]"]').val(translation ? translation.alttext : '');
            }
        },
        _insertDocuments: function () {
            var val = '';

            if (this.mode === 'document') {
                var document = this.selected.children('li:first-child');

                if (document.length == 1) {
                    val = document.data('id');
                }
            } else {
                var array = [],
                    documents = this.selected.children();

                for (var i = 0; i < documents.length; i++) {
                    array.push($(documents[i]).data('id'));
                }

                val = array;
            }

            this.lastValue = (this.mode === 'document') ? val : JSON.stringify(val);

            this.controller.setValue(val);
        },
        _deselectAll: function () {
            this.documentsList.children('li').removeClass('library-document--selected library-document--detailed');

            this.selected.empty();
            this.total.text(0);

            this.documentDetails.addClass('library-details--empty');
        },
        _selectDocuments: function (val) {
            if (val === '' || val === '[]' || val == 0) {
                return;
            }

            if (this.mode === 'document') {
                var document = this.documentsList.children('li[data-id="' + val + '"]');

                this.selectDocument(document);
                this._showDetails(document);

                return;
            }

            val = JSON.parse(val);

            for (var i in val) {
                var document = this.documentsList.children('li[data-id="' + val[i] + '"]');

                this.selectDocument(document);
            }
        },
        selectDocument: function (document) {
            var type = document.data('type');

            if (this.masterFilter !== null && type !== this.masterFilter) {
                return;
            }

            if (this.mode === 'document') {
                this._deselectAll();
            }

            document.addClass('library-document--selected');

            var thumbnail = $('<li class="library-document library-document--compact" data-id="' + document.data('id') + '"></li>');
            document.children('.document-thumbnail').clone().appendTo(thumbnail);

            this.selected.append(thumbnail);

            this.total.text(this.selected.children().length);
        },
        _deselectDocument: function (document) {
            document.removeClass('library-document--selected');

            this.selected.children('li[data-id="' + document.data('id') + '"]').remove();

            this.total.text(this.selected.children().length);
        },
        _toggleDocument: function (document) {
            if (document.hasClass('library-document--selected')) {
                this._deselectDocument(document);
            } else {
                this.selectDocument(document);
            }
        },
        // Makes a search
        _search: function (keywords) {
            if (keywords === '') {
                this.documentsList.children('li').removeClass('library-document--hidden');

                this.searchActive = false;

                this._anyDocuments();

                return;
            }

            this.searchActive = true;

            var self = this,
                scroller = this.documentsList.parent();

            this._disableDocumentsList();

            $.post(this.searchurl, {q: keywords}, function (response) {
                self._enableDocumentsList();

                self.documentsList.children('li').addClass('library-document--hidden');

                scroller.scrollTop(0);
                scroller.perfectScrollbar('update');

                if (response.documents.length > 0) {
                    self._populateLibrary(response.documents);

                    var selector = 'li[data-id="' + response.ids.join('"],li[data-id="') + '"]';
                    self.documentsList.children(selector).removeClass('library-document--hidden');
                }

                self._anyDocuments();
            }, 'json');
        },
        _enableDocumentsList: function () {
            this.documentsBlackout.removeClass('library-column__blackout--active');
        },
        _disableDocumentsList: function () {
            this.documentsBlackout.addClass('library-column__blackout--active');
        },
        _enableDetails: function () {
            this.detailsBlackout.removeClass('library-column__blackout--active');
        },
        _disableDetails: function () {
            this.detailsBlackout.addClass('library-column__blackout--active');
        },
        _initSelectedSortable: function () {
            if (this.mode === 'document') {
                return;
            }

            this.selected.sortable({
                cursor: 'move',
                tolerance: 'pointer',
                placeholder: 'placeholder',
                opacity: 0.7,
                delay: 50,
                scroll: false
            });
        },
        _changeDetailsTab: function (locale) {
            this.detailsFlaps.removeClass('compact-tabs__tab--active');
            this.detailsTabs.removeClass('sub-tab--active');

            this.detailsFlaps.siblings('.compact-tabs__tab--' + locale).addClass('compact-tabs__tab--active');
            this.detailsTabs.siblings('.sub-tab--' + locale).addClass('sub-tab--active');
        },
        _editDocumentTranslations: function (info) {
            var self = this;

            this._disableDetails();

            $.post(this.detailsurl, info, function (document) {
                self._enableDetails();

                self.documentsBag.addDocument(document.id, document);
            });
        }
    };

    window.DocumentsLibrary = DocumentsLibrary;

    /**
     * DocumentsBag Constructor
     */
    function DocumentsBag() {
        this._init();
    }

    // Prototype
    DocumentsBag.prototype = {
        _init: function () {
            this.bag = [];
        },
        addDocument: function (id, document) {
            if (typeof document === 'string') {
                document = JSON.parse(document);
            }

            this.bag[id] = document;
        },
        getDocument: function (id) {
            return this.bag[id];
        },
        getDocuments: function () {
            return this.bag;
        }
    };

    window.DocumentsBag = DocumentsBag;

    // LibraryIndicator Constructor
    function LibraryIndicator(file, uploader) {
        this.uploader = uploader;

        this._init(file);
    }

    inheritsFrom(LibraryIndicator, UploadIndicator);

    LibraryIndicator.prototype._init = function (file) {
        this.container = $('<li class="library-document"></li>');

        this.progress = $('<div class="upload__progress"></div>').appendTo(this.container);
        this.progressBar = $('<div class="upload__progress-bar"></div>').appendTo(this.progress);

        this.thumbnail = $('<div class="document-thumbnail"></div>').appendTo(this.container);

        this.filename = $('<p class="library-document__name">' + html_entities(file.name) + '</p>').appendTo(this.container);
    };

    LibraryIndicator.prototype._success = function (upload) {
        upload = upload.summary;

        window.documentsBag.addDocument(upload.id, upload);

        this.container.replaceWith(window.documentsLibrary.createDocument(upload.id, upload.name, upload.type, upload.thumbnail, false));

        var library = window.documentsLibrary;
        library.selectDocument(library.documentsList.children('li[data-id="' + upload.id + '"]'));
    };

    LibraryIndicator.prototype._error = function (message) {
        this.container.remove();
    };

    window.LibraryIndicator = LibraryIndicator;

})(window);