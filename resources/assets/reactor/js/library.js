;(function (window) {
    'use strict';

    /**
     * Library constructor
     *
     * @param DOM Object
     */
    function Library(el) {
        this.container = el;

        this._init();
    }

    // Prototype
    Library.prototype = {
        // Initialize
        _init: function () {
            this.retrieveURL = this.container.data('retrieveurl');

            this.modal = this.container.find('#library-modal');
            this.scroller = this.modal.find('#library-modal-columns');
            this.mediaList = $('#library-modal-media-list');

            this.searchForm = this.modal.find('#library-modal-search');
            this.noResults = this.modal.find('#library-modal-noresults');
            this.disabler = this.modal.find('#library-modal-disabler');

            this.mediaDetails = this.modal.find('#library-modal-media-detail');
            this.gallerySortable = this.modal.find('#library-modal-gallery-sortable');
            this.numSelected = this.modal.find('#library-modal-gallery-selected > span');

            this.clearButton = this.modal.find('#library-modal-clear');
            this.removeButton = this.modal.find('#library-modal-remove');
            this.insertButton = this.modal.find('#library-modal-insert');
            this.closeButton = this.modal.find('#library-modal-close');

            this.dropzone = this.container.find('#library-modal-dropzone');

            this.controller = null;
            this.isOpen = false;
            this.isRetrieved = false;
            this.mode = null;
            this.masterFilter = null;
            this.lastValue = null;
            this.uploadIndicators = [];
            this.controllerDirty = false;

            // Create dialog
            this.dialog = new Modal($('#library-modal-container'));

            // Create uploader
            this.uploader = new Uploader($('#library-modal-dropzone'), {
                outputList: this.mediaList,
                enabled: false,
                append: false,
                indicator: 'LibraryIndicator'
            });

            this._disableList();

            this._initEvents();
        },
        // Initialize events
        _initEvents: function () {
            // Cache self
            var self = this;

            // Scrollers
            this.scroller.find('.library-modal-scroll-button').on('click', function () {
                // Check direction
                if ($(this).hasClass('right')) {
                    self.scroller.addClass('scrolled');
                } else if ($(this).hasClass('left')) {
                    self.scroller.removeClass('scrolled');
                }
            });

            // Stop propagation for the library-modal
            this.modal.on('click', function (e) {
                e.stopPropagation();
            });

            // Clear button
            this.clearButton.on('click', function (e) {
                self._clearGallery();

                e.preventDefault();
                e.stopPropagation();
            });

            // Remove button
            this.removeButton.on('click', function () {
                self._deselectDocument();

                self.controller.setValue(null);

                self.close();
            });

            // Search
            this.searchForm.on('submit', function (e) {
                e.preventDefault();
                e.stopPropagation();

                if (!$(this).hasClass('disabled')) {
                    var search = $(this).find('input[name="q"]');

                    var keywords = search.val();

                    self._search(keywords);
                }
            });

            // Search input keypress
            this.searchForm.find('input[type="search"]').bind('keydown', function (e) {
                if (e.keyCode === 27) {
                    e.stopPropagation();
                    if ($(this).val() === '') {
                        $(this).blur();
                    } else {
                        self._search('');
                    }
                }
            });

            // Sortable
            this.gallerySortable.sortable({
                cursor: 'move',
                tolerance: 'pointer',
                placeholder: 'placeholder',
                opacity: 0.7,
                delay: 50,
                scroll: false
            }).disableSelection();

            // Sortable remove
            this.gallerySortable.on('click', '.library-modal-sortable-remove', function (e) {
                var parent = $(this).parent();

                self._deselectGallery($('#md_' + parent.data('id')));

                parent.remove();

                e.preventDefault();
                e.stopPropagation();
            });

            // Dragenter, dragover
            this.container.on("dragenter, dragover", function (e) {
                e.preventDefault();
                e.stopPropagation();

                self.dropzone.addClass('dragenter');
            });

            // Dragleave
            this.dropzone.on("dragleave", function () {
                $(this).removeClass('dragenter');
            });

            // Call upload handler
            this.dropzone.on("drop", function (e) {
                e.preventDefault();

                $(this).removeClass('dragenter');
            });

            // Close button
            this.closeButton.on("click", function () {
                self.close();
            });
        },
        // Initialize
        run: function (controller) {
            if (!this.isRetrieved) {
                // We do not store controller here since we don't want
                // conflicts when this mode runs again after retrieval
                this._setMode(controller.type);

                this._reset();

                this._retrieve(controller);
            } else {
                if (this.controller !== controller) {
                    this.controller = controller;

                    this._setMode(controller.type);

                    this.controllerDirty = true;

                    this._reset();
                }

                this._initByMode();
            }

            this.open();
        },
        // Displays by controller value/options
        _initByMode: function () {
            if (this.mode === 'gallery') {
                this._initGallery();
            } else {
                this._initDocument();
            }
        },
        // Init gallery
        _initGallery: function () {
            // Do this bit if the controller is not the same
            if (this.controllerDirty === true) {
                var self = this;

                this._setMasterFilter('image');

                this.mediaList.unbind('click').on('click', 'li', function () {
                    self._selectForGallery($(this));
                });

                this.insertButton.unbind('click').on('click', function () {
                    self.controller.setValue(self._parseForGallery());

                    self.close();
                });

                this.controllerDirty = false;
            }

            var mediaIds = this.controller.getValue();

            // If the last value has changed reinit
            if (this.isRetrieved && this.lastValue !== mediaIds) {
                this.lastValue = mediaIds;

                this._clearGallery();

                // Take action if not empty
                if (mediaIds !== '' && mediaIds.length > 0) {
                    mediaIds = JSON.parse(mediaIds);

                    for (var i = mediaIds.length - 1; i >= 0; i--) {
                        var media = $('#md_' + mediaIds[i]);

                        if (media.length > 0) {
                            this._selectGallery(media);
                        }
                    }
                }

                this._recalculateSelected();
            }
        },
        // Init document
        _initDocument: function () {
            // Do this bit if the controller is not the same
            if (this.controllerDirty === true) {
                var self = this;

                if (typeof this.controller.filter !== 'undefined') {
                    this._setMasterFilter(this.controller.filter);
                }

                this.mediaList.unbind('click').on('click', 'li', function () {
                    self._selectForDocument($(this));
                });

                this.insertButton.unbind('click').on('click', function () {
                    self.controller.setValue(self._parseForDocument());

                    self.close();
                });

                this.controllerDirty = false;
            }

            var mediaId = this.controller.getValue();

            // If the last value has changed reinit
            if (this.isRetrieved && this.lastValue !== mediaId) {
                this.lastValue = mediaId;

                var media = $('#md_' + mediaId);

                if (media.length > 0) {
                    this._selectDocument(media);
                } else {
                    this._deselectDocument();
                }
            }
        },
        // Selects media depending on the mode
        selectMediaById: function (id) {
            var media = $('#md_' + id);

            if (media.length > 0) {
                // Select depending on mode
                if (this.mode === 'gallery') {
                    this._selectForGallery(media);
                } else {
                    this._selectForDocument(media);
                }
            }
        },
        // Select media
        _selectForDocument: function (media) {
            // Return if it has indicator
            if (media.hasClass('indicator')) {
                return false;
            }

            // Take action depending on the selected condition
            if (media.hasClass('selected')) {
                this._deselectDocument();
            } else {
                this._selectDocument(media);
            }
        },
        // Selects document
        _selectDocument: function (media) {
            this.mediaList.children('li.selected').removeClass('selected');
            media.addClass('selected');
            this.mediaDetails.addClass('selected');

            this.mediaDetails.data('id', media.data('id'));

            var tag = this.mediaDetails.children('.library-modal-media-tag'),
                name = tag.find('.media-name'),
                detail = tag.find('.media-detail'),
                thumbnail = tag.find('.media-thumbnail');

            name.text(media.data('name'));

            if (isNaN(media.data('size')) || media.data('size') == '0') {
                var details = media.data('mimetype');
            } else {
                var details = media.data('mimetype') + ' | ' + readable_size(media.data('size'));
            }

            detail.text(details);

            thumbnail.html(media.find('.document-thumbnail').clone());
        },
        // Deselects document
        _deselectDocument: function () {
            this.mediaList.children('li.selected').removeClass('selected');
            this.mediaDetails.removeClass('selected');

            this.mediaDetails.data('id', '');
        },
        // Select media for gallery
        _selectForGallery: function (media) {
            if (media.hasClass('indicator') || media.hasClass('filtered')) {
                return false;
            }

            if (media.hasClass('selected')) {
                this._deselectGallery(media);
            } else {
                this._selectGallery(media);
            }

            this._recalculateSelected();
        },
        // Selects media for gallery
        _selectGallery: function (media) {
            media.addClass('selected');

            var thumbnail = $('<li data-id="' + media.data('id') + '" id="gl_' + media.data('id') + '"></li>');

            $('<img src="' + media.find('img').attr('src') + '">').appendTo(thumbnail);

            $('<i class="icon-cancel library-modal-sortable-remove"></i>').appendTo(thumbnail);

            this.gallerySortable.prepend(thumbnail);
        },
        // Deselects media for gallery
        _deselectGallery: function (media) {
            media.removeClass('selected');

            this.gallerySortable.find('#gl_' + media.data('id')).remove();

            this._recalculateSelected();
        },
        _clearGallery: function () {
            this.mediaList.children('li.selected').removeClass('selected');

            this.gallerySortable.empty();

            this.numSelected.text(0);
        },
        // Recalculates the number of selected media
        _recalculateSelected: function () {
            var selected = this.gallerySortable.children('li').length;

            this.numSelected.text(selected);
        },
        // Parse media
        _parseMedia: function (id) {
            var media = $('#md_' + id);

            if (media.length > 0) {
                return {
                    'id': id,
                    'name': media.data('name'),
                    'thumbnail': media.find('.document-thumbnail').children('img,i').clone()
                };
            } else {
                return null;
            }
        },
        // Parse for document
        _parseForDocument: function () {
            var id = this.mediaDetails.data('id');

            return this._parseMedia(id);
        },
        // Parse for gallery
        _parseForGallery: function () {
            var array = [];

            var gallery = this.gallerySortable.children('li');

            for (var i = 0; i < gallery.length; i++) {
                var id = gallery.eq(i).data('id');
                // Push into array
                array.push(this._parseMedia(id));
            }

            return array;
        },
        // Open
        open: function () {
            this.dialog.openModal();
        },
        // Open
        close: function () {
            this.dialog.closeModal();
        },
        _setMode: function (mode) {
            this.mode = mode;

            this.container.removeClass('library-modal-mode-gallery library-modal-mode-document');

            this.container.addClass('library-modal-mode-' + mode);
        },
        // Sets the master filter
        _setMasterFilter: function (key) {
            this.masterFilter = key;

            this._filter(key);
        },
        // Refilter (useful when new uploaded files arrive)
        refilter: function () {
            this._filter(
                this.masterFilter
            );
        },
        // Resets library modal
        _reset: function () {
            this.masterFilter = null;

            this._deselectDocument();

            this._clearGallery();

            this.mediaList.children('li').removeClass();
        },
        // Retrieves the media
        _retrieve: function (controller) {
            var self = this;

            $.getJSON(this.retrieveURL, function (data) {
                self._populateList(data);

                self.isRetrieved = true;

                self._enableList();

                self._enableUploader();

                self.run(controller);
            });
        },
        // Populates the media list
        _populateList: function (data) {
            for (var i = 0; i < data.length; i++) {
                var media = data[i];

                this.mediaList.prepend(this.createMediaThumbnail(media));
            }
        },
        createMediaThumbnail: function (media) {
            var thumbnail = $('<li data-id="' + media.id + '" ' +
                'id="md_' + media.id + '" data-name="' + html_entities(media.name) + '" ' +
                'data-flag="' + media.type + '" data-size="' + media.size + '" ' +
                'data-mimetype="' + media.mimetype + '">');

            $('<div class="document-thumbnail">' + media.thumbnail + '</div>').appendTo(thumbnail);

            $('<p>' + html_entities(media.name) + '</p>').appendTo(thumbnail);

            $('<i class="icon-check"></i>').appendTo(thumbnail);

            return thumbnail;
        },
        // Enables list
        _enableList: function () {
            this.disabler.removeClass('active');

            this.searchForm.removeClass('disabled');
        },
        // Disable list
        _disableList: function () {
            this.disabler.addClass('active');

            this.searchForm.addClass('disabled');
        },
        // Filter items by key
        _filter: function (key) {
            if (!key || key === 'all') {
                this.mediaList.children('li').removeClass('filtered');
            } else {
                this.mediaList.children('li').addClass('filtered');
                this.mediaList.children('li[data-flag="' + key + '"]').removeClass('filtered');
            }

            this._anyResults();
        },
        // Makes a search
        _search: function (keywords) {
            if (keywords.trim() === "") {
                this.mediaList.children('li').removeClass('searched');

                this._anyResults();
            } else {
                var self = this;

                this._yesResults();

                var formData = new FormData();
                formData.append('q', keywords);

                this.mediaList.children('li').addClass('searched');

                this._disableList();

                $.ajax({
                    url: self.searchForm.attr('action'),
                    type: "POST",
                    contentType: false,
                    processData: false,
                    cache: false,
                    data: formData,
                    success: function (data) {
                        if (data !== '') {
                            var selector = '#md_' + data.join(',#md_');

                            $(selector).removeClass('searched');
                        }

                        self._enableList();

                        self._anyResults();
                    }
                });
            }
        },
        // Displays no results notification if there are no results
        _anyResults: function () {
            if (this.isRetrieved) {
                if (this.mediaList.find('li').length === this.mediaList.find('.searched,.filtered').length) {
                    this.noResults.addClass('active');
                } else {
                    this.noResults.removeClass('active');
                }
            }
        },
        // Forces hide no results notification
        _yesResults: function () {
            this.noResults.removeClass('active');
        },
        // Enables uploader
        _enableUploader: function () {
            this.uploader.options.enabled = true;
        }
    };

    // Register to window namespace
    window.Library = Library;

    // LibraryIndicator Constructor
    function LibraryIndicator(name, size) {
        this._init(name);

        this.app = window.documentsLibrary;
    }

    // Inherit from Indicator
    LibraryIndicator.prototype = Indicator.prototype;

    // Overload Indicator _init
    LibraryIndicator.prototype._init = function (name) {
        this.parent = $('<li class="indicator"></li>');

        this.thumbnail = $('<div class="document-thumbnail"></div>');
        this.thumbnail.appendTo(this.parent);

        this.name = $('<p>' + name + '</p>');
        this.name.appendTo(this.parent);

        $('<i class="icon-check"></i>').appendTo(this.parent);

        this.progressBar = $('<div class="progress"></div>');
        this.progressBar.appendTo(this.thumbnail);
    };

    // Overload Indicator _error
    LibraryIndicator.prototype._error = function (data) {
        this.parent.remove();
    };

    // Overload Indicator _success
    LibraryIndicator.prototype._success = function (data) {
        this.parent.removeClass('indicator');

        this.parent.attr('data-id', data.id);
        this.parent.attr('id', 'md_' + data.id);
        this.parent.attr('data-name', html_entities(data.name));
        this.parent.attr('data-flag', data.type);
        this.parent.attr('data-size', data.size);
        this.parent.attr('data-mimetype', data.mimetype);

        this.thumbnail.html(data.thumbnail);

        // Refilter the app
        this.app.refilter();

        // Select new uploaded media
        this.app.selectMediaById(data.id);
    };

    // Overload Indicator setProgress
    LibraryIndicator.prototype.setProgress = function (percentage) {
        percentage = percentage.toString() + '%';

        this.progressBar.height(percentage).width(percentage);
    };

    // Register indicator to the window namespace
    window.LibraryIndicator = LibraryIndicator;

})(window);