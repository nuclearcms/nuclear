;( function(window) {
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
        _init : function() {
            this.retrieveURL = this.container.data('retrieve');

            this.modal = this.container.find('.library-modal');
            this.scroller = this.modal.find('.library-modal-media-scroller');
            this.mediaList = $('#library-modal-media-list');
            this.asideMenu = this.modal.find('.library-modal-aside');

            this.searchForm = this.asideMenu.find('.aside-search');
            this.filterForm = this.asideMenu.find('.orderable');

            this.noResults = this.modal.find('.library-modal-noresults');
            this.disabler = this.modal.find('.library-modal-disable');

            this.mediaDetails = $('#library-modal-media-detail');
            this.gallerySortable = $('#library-modal-gallery-sortable');
            this.numSelected = this.modal.find('.library-modal-num-selected');

            this.clearButton = this.modal.find('.library-modal-clear-gallery');
            this.removeButton = $('#library-modal-remove');
            this.insertButton = $('#library-modal-insert');

            this.dropzone = this.container.find('.modal-dropzone');

            this.controller = null;
            this.isOpen = false;
            this.isRetrieved = false;
            this.mode = null;
            this.masterFilter = null;
            this.lastValue = null;
            this.uploadIndicators = [];
            this.controllerDirty = false;

            // Create dialog
            this.dialog = new Modal($('#library-container'));

            // Create uploader
            this.uploader = new Uploader($('#dropzone'), {
                selectButton : "#dropzone-select-files",
                uploadInput : "#dropzone-input",
                outputList : '#upload-list',
                enabled: false
            });

            this._disableList();

            this._initEvents();
        },
        // Initialize events
        _initEvents : function() {
            // Cache self
            var self = this;

            // Scrollers
            this.scroller.find('.library-modal-column-scroll').on('click', function() {
                // Check direction
                if($(this).hasClass('right')) {
                    self.scroller.addClass('scrolled');
                } else if($(this).hasClass('left')) {
                    self.scroller.removeClass('scrolled');
                }
            });

            // Stop propagation for the library-modal
            this.modal.on('click', function(e) {
                e.stopPropagation();
            });

            // Clear button
            this.clearButton.on('click', function(e) {
                self._clearGallery();

                e.preventDefault();
                e.stopPropagation();
            });

            // Remove button
            this.removeButton.on('click', function() {
                self._deselectFile();

                self.controller.setValue(null);

                self.close();
            });

            // Filter select
            this.filterForm.on('change', function() {
                if(!self.filterForm.hasClass('disabled') && self.masterFilter === null) {
                    self._filter(self.filterForm.val());
                }
            });

            // Search
            this.searchForm.on('submit', function(e) {
                e.preventDefault();
                e.stopPropagation();

                if(!$(this).hasClass('disabled')) {
                    var search = $(this).find('input[name="keywords"]');

                    var keywords = search.val();

                    self._search(keywords);
                }
            });

            // Search input keypress
            this.searchForm.find('input[type="search"]').bind('keydown', function(e) {
                if(e.keyCode === 27) {
                    e.stopPropagation();
                    if($(this).val() === '') {
                        $(this).blur();
                    } else {
                        self._search('');
                    }
                }
            });

            // Sortable
            this.gallerySortable.sortable({
                cursor : 'move',
                tolerance : 'pointer',
                placeholder : 'placeholder',
                opacity : 0.7,
                delay: 50,
                scroll : false
            }).disableSelection();

            // Sortable remove
            this.gallerySortable.on('click', '.library-modal-sortable-remove', function(e) {
                var parent = $(this).parent();

                self._deselectGallery($('#md_' + parent.data('id')));

                parent.remove();

                e.preventDefault();
                e.stopPropagation();
            });

            // Dragenter, dragover
            this.container.on("dragenter, dragover", function(e) {
                e.preventDefault();
                e.stopPropagation();

                self.dropzone.addClass('dragenter');
            });

            // Dragleave
            this.dropzone.on("dragleave", function() {
                $(this).removeClass('dragenter');
            });

            // Call upload handler
            this.dropzone.on("drop", function(e) {
                e.preventDefault();
                e.stopPropagation();

                self.uploader._queue(e.originalEvent.dataTransfer.files);

                $(this).removeClass('dragenter');
            });
        },
        // Initialize
        run : function(controller) {
            if(!this.isRetrieved) {
                // We do not store controller here since we don't want
                // conflicts when this mode runs again after retrieval
                this._setMode(controller.type);

                this._reset();

                this._retrieve(controller);
            } else {
                if(this.controller !== controller) {
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
        _initByMode : function() {
            if(this.mode === 'gallery') {
                this._initGallery();
            } else {
                this._initFile();
            }
        },
        // Init gallery
        _initGallery : function() {
            // Do this bit if the controller is not the same
            if(this.controllerDirty === true) {
                var self = this;

                this._setMasterFilter('image');

                this.mediaList.unbind('click').on('click', 'li', function() {
                    self._selectForGallery($(this));
                });

                this.insertButton.unbind('click').on('click', function() {
                    self.controller.setValue(self._parseForGallery());

                    self.close();
                });

                this.controllerDirty = false;
            }

            var mediaIds = this.controller.getValue();

            // If the last value has changed reinit
            if(this.isRetrieved && this.lastValue !== mediaIds) {
                this.lastValue = mediaIds;

                this._clearGallery();

                // Take action if not empty
                if(mediaIds !== '' && mediaIds.length > 0) {
                    mediaIds = JSON.parse(mediaIds);

                    for(var i = mediaIds.length - 1; i >= 0; i--) {
                        var media = $('#md_' + mediaIds[i]);

                        if(media.length > 0) {
                            this._selectGallery(media);
                        }
                    }
                }

                this._recalculateSelected();
            }
        },
        // Init file
        _initFile : function() {
            // Do this bit if the controller is not the same
            if(this.controllerDirty === true) {
                var self = this;

                if(typeof this.controller.filter !== 'undefined') {
                    this._setMasterFilter(this.controller.filter);
                }

                this.mediaList.unbind('click').on('click', 'li', function() {
                    self._selectForFile($(this));
                });

                this.insertButton.unbind('click').on('click', function() {
                    self.controller.setValue(self._parseForFile());

                    self.close();
                });

                this.controllerDirty = false;
            }

            var mediaId = this.controller.getValue();

            // If the last value has changed reinit
            if(this.isRetrieved && this.lastValue !== mediaId) {
                this.lastValue = mediaId;

                var media = $('#md_' + mediaId);

                if(media.length > 0) {
                    this._selectFile(media);
                } else {
                    this._deselectFile();
                }
            }
        },
        // Selects media depending on the mode
        selectMediaById : function(id) {
            var media = $('#md_' + id);

            if(media.length > 0) {
                // Select depending on mode
                if(this.mode === 'gallery') {
                    this._selectForGallery(media);
                } else {
                    this._selectForFile(media);
                }
            }
        },
        // Select media
        _selectForFile : function(media) {
            // Return if it has indicator
            if(media.hasClass('indicator')) { return false; }
            // Take action depending on the selected condition
            if(media.hasClass('selected')) {
                this._deselectFile();
            } else {
                this._selectFile(media);
            }
        },
        // Selects file
        _selectFile : function(media) {
            this.mediaList.children('li.selected').removeClass('selected');
            media.addClass('selected');
            this.mediaDetails.addClass('selected');

            this.mediaDetails.data('id', media.data('id'));

            var tag = this.mediaDetails.children('.library-modal-media-tag'),
                name = tag.children('.media-name'),
                detail = tag.children('.media-detail'),
                thumbnail = tag.find('.media-thumbnail'),
                fixed = tag.find('.media-fixed');

            name.text(media.data('name'));

            var details = media.data('type') + ' | ' + readable_size(media.data('size'));
            if(media.data('image') === true) { details += ' | ' + media.data('width') + ' x ' + media.data('height'); }
            detail.text(details);

            thumbnail.attr('src', media.find('img').attr('src'));

            fixed.attr('src', media.data('showpath'));
        },
        // Deselects file
        _deselectFile : function() {
            this.mediaList.children('li.selected').removeClass('selected');
            this.mediaDetails.removeClass('selected');

            this.mediaDetails.data('id', '');
        },
        // Select media for gallery
        _selectForGallery : function(media) {
            if(media.hasClass('indicator')) { return false; }

            if(media.hasClass('selected')) {
                this._deselectGallery(media);
            } else {
                this._selectGallery(media);
            }

            this._recalculateSelected();
        },
        // Selects media for gallery
        _selectGallery : function(media) {
            media.addClass('selected');

            var thumbnail = $('<li data-id="' + media.data('id') + '" id="gl_' + media.data('id') + '"></li>');

            $('<img src="' + media.find('img').attr('src') + '">').appendTo(thumbnail);

            $('<span class="icon icon-close library-modal-sortable-remove"></span>').appendTo(thumbnail);

            this.gallerySortable.prepend(thumbnail);
        },
        // Deselects media for gallery
        _deselectGallery : function(media) {
            media.removeClass('selected');

            this.gallerySortable.find('#gl_' + media.data('id')).remove();

            this._recalculateSelected();
        },
        _clearGallery : function() {
            this.mediaList.children('li.selected').removeClass('selected');

            this.gallerySortable.empty();

            this.numSelected.text(0);
        },
        // Recalculates the number of selected media
        _recalculateSelected : function() {
            var selected = this.gallerySortable.children('li').length;

            this.numSelected.text(selected);
        },
        // Parse media
        _parseMedia : function(id) {
            var media = $('#md_' + id);

            if(media.length > 0) {
                return {
                    'id' : id,
                    'name' : media.data('name'),
                    'thumbnail' : media.find('img').attr('src')
                };
            } else {
                return null;
            }
        },
        // Parse for file
        _parseForFile : function() {
            var id = this.mediaDetails.data('id');

            return this._parseMedia(id);
        },
        // Parse for gallery
        _parseForGallery : function() {
            var array = [];

            var gallery = this.gallerySortable.children('li');

            for(var i = 0; i < gallery.length; i++) {
                var id = gallery.eq(i).data('id');
                // Push into array
                array.push(this._parseMedia(id));
            }

            return array;
        },
        // Open
        open : function() {
            this.dialog.openDialog();
        },
        // Open
        close : function() {
            this.dialog.closeDialog();
        },
        _setMode : function(mode) {
            this.mode = mode;

            this.container.removeClass('library-modal-mode-gallery library-modal-mode-file');

            this.container.addClass('library-modal-mode-' + mode);
        },
        // Sets the master filter
        _setMasterFilter : function(key) {
            this.masterFilter = key;

            this.asideMenu.addClass('filtered');

            this._filter(key);
        },
        // Resets library modal
        _reset : function() {
            this.masterFilter = null;

            this.asideMenu.removeClass('filtered');

            this._deselectFile();

            this._clearGallery();

            this.mediaList.children('li').removeClass();
        },
        // Retrieves the media
        _retrieve : function(controller) {
            var self = this;

            $.getJSON( this.retrieveURL, function(data) {
                self._populateList(data);

                self.isRetrieved = true;

                self._enableList();

                self._enableUploader();

                self.run(controller);
            });
        },
        // Populates the media list
        _populateList : function(data) {
            for(var i = 0; i < data.length; i++) {
                var media = data[i];

                this.mediaList.prepend(this.createMediaThumbnail(media));
            }
        },
        createMediaThumbnail : function(media) {
            var thumbnail = $('<li data-id="' + media.id + '" id="md_' + media.id + '" data-name="' + html_entities(media.name) + '" data-flag="' + media.flag + '" data-showpath="' + media.showPath + '" data-size="' + media.value.size + '" data-type="' + media.value.type + '" data-image="' + media.isImage + '"></li>');

            $('<img src="' + media.thumbnailPath + '">').appendTo(thumbnail);

            if(media.isImage !== true) {
                $('<div class="library-modal-media-name-wrapper"><div class="library-modal-media-name"><p>' + html_entities(media.name) + '</p></div></div>').appendTo(thumbnail);
            } else {
                thumbnail.attr({
                    'data-width' : media.value.width,
                    'data-height' : media.value.height
                });
            }

            $('<div class="library-modal-media-overlay"><span class="icon icon-yes"></span></div>').appendTo(thumbnail);

            return thumbnail;
        },
        // Enables list
        _enableList : function() {
            this.disabler.removeClass('active');

            this.searchForm.removeClass('disabled');

            this.filterForm.removeClass('disabled');
        },
        // Disable list
        _disableList : function() {
            this.disabler.addClass('active');

            this.searchForm.addClass('disabled');

            this.filterForm.addClass('disabled');
        },
        // Filter items by key
        _filter : function(key) {
            if(key === 'all') {
                this.mediaList.children('li').removeClass('filtered');
            } else  {
                this.mediaList.children('li').addClass('filtered');
                this.mediaList.children('li[data-flag="' + key + '"]').removeClass('filtered');
            }

            this._anyResults();
        },
        // Makes a search
        _search : function(keywords) {
            if(keywords.trim() === "") {
                this.mediaList.children('li').removeClass('searched');

                this._anyResults();
            } else {
                var self = this;

                this._yesResults();

                var formData = new FormData();
                formData.append('keywords', keywords);

                this.mediaList.children('li').addClass('searched');

                this._disableList();

                $.ajax({
                    url : self.searchForm.attr('action'),
                    type : "POST",
                    contentType : false,
                    processData : false,
                    cache : false,
                    data : formData,
                    success : function(data) {
                        if(data !== '') {
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
        _anyResults : function() {
            if(this.isRetrieved) {
                if(this.mediaList.find('li').length === this.mediaList.find('.searched,.filtered').length) {
                    this.noResults.addClass('active');
                } else {
                    this.noResults.removeClass('active');
                }
            }
        },
        // Forces hide no results notification
        _yesResults : function() {
            this.noResults.removeClass('active');
        },
        // Enables uploader
        _enableUploader : function() {
            this.uploader.options.enabled = true;
        },
        // Creates an upload indicator
        createUploadIndicator : function() {
            // Create indicator
            var indicator = new GalleryIndicator(this);
            // Push to indicator queue
            this.uploadIndicators.push(indicator);
            // Set the output
            this.mediaList.prepend(indicator.container);
        }
    };

    // Register to window namespace
    window.Library = Library;


    // Gallery indicator constructor
    function GalleryIndicator(app) {
        this._init(app);
    }

    // Gallery indicator
    GalleryIndicator.prototype = {
        // Initialize
        _init : function(app) {
            // Set parent app
            this.app = app;
            // Create container
            this.createContainer();
        },
        // Creates container
        createContainer : function() {
            this.container = $('<li class="indicator"></li>');
            // Set progress container
            this.progressBar = $('<div class="library-modal-progressbar"></div>').appendTo(this.container);
        },
        // Sets progress
        setProgress : function(percentage) {
            percentage = percentage.toString() + '%';
            // Set height and width
            this.progressBar.height(percentage).width(percentage);
        },
        // Complete callback
        complete : function(data) {
            // Create gallery thumbnail if on success
            if(data.type === 'success') {
                // Make new thumbnail
                var thumbnail = this.app.createMediaThumbnail(data.data);
                // Create new media thumbnail
                this.container.replaceWith(thumbnail);
                // Select as default action
                this.app.selectMediaById(thumbnail.data('id'));
            } else {
                // Otherwise remove self
                this.container.remove();
            }
        }
    };

    // Register gallery indicator to the window namespace
    window.GalleryIndicator = GalleryIndicator;

})(window);

// Run when document is loaded
$(document).ready(function() {
    // Create new instance
    var library = new Library($('#library-container'), App);
});