;(function (window) {
    'use strict';

    /**
     * Gallery constructor
     */
    function Gallery(el, library, documentsBag) {
        this.el = el;
        this.library = library;
        this.documentsBag = documentsBag;

        this._init();
    }

    // Prototype
    Gallery.prototype = {
        _init: function () {
            this.input = this.el.find('input[type="hidden"]');

            this.container = this.el.find('.form-group__gallery-container');
            this.libraryButton = this.el.find('.form-group__buttons > .button--library');
            this.clearButton = this.el.find('.form-group__buttons > .button--clear');

            this.gallery = this.el.find('ul.form-group__gallery');

            this.mode = 'gallery';
            this.filter = 'image';

            this._populateDocumentsBag();

            this._initUploader();

            this._initEvents();
        },
        _initUploader: function () {
            var self = this;

            this.dropzone = this.container.find('div.dropzone');

            this.container.on("dragenter dragover", function (e) {
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
                outputList: this.gallery,
                indicatorClass: 'GalleryIndicator',
                isDropzoneForm: false
            });

            this.uploader.controller = this;
        },
        _populateDocumentsBag: function () {
            var slides = this.gallery.find('li.form-group__slide');

            for (var i = 0; i < slides.length; i++) {
                var slide = slides.eq(i);

                this.documentsBag.addDocument(slide.data('id'), slide.data('summary'));

                slide.attr('data-summary', '');
            }
        },
        _initEvents: function () {
            var self = this;

            this.gallery.sortable({
                cursor: 'move',
                tolerance: 'pointer',
                placeholder: 'placeholder',
                opacity: 0.7,
                delay: 50,
                stop: function () {
                    self.refreshInput();
                }
            });

            // Bind events for non touch screens
            if (!Modernizr.touch) {
                this.gallery.on('click', '.icon-cancel', function () {
                    var parent = $(this).parent();

                    $(parent).remove();

                    self.refreshInput();
                });
            }

            this.clearButton.on('click', function (e) {
                self._clearGallery();

                e.preventDefault();
                e.stopPropagation();
            });

            this.libraryButton.on('click', function (e) {
                self.library.run(self);

                e.preventDefault();
                e.stopPropagation();
            });
        },
        _clearGallery: function () {
            this.input.val('');

            this.gallery.html('');

            this.container.addClass('empty');
        },
        refreshInput: function () {
            var array = this.gallery.sortable('toArray', {attribute: 'data-id'});

            this.input.val(JSON.stringify(array));

            if (this.gallery.children('li').length === 0) {
                this.container.addClass('empty');
            } else {
                this.container.removeClass('empty');
            }
        },
        getValue: function () {
            return this.input.val();
        },
        setValue: function (gallery) {
            this._clearGallery();

            if (gallery.length > 0) {
                this.container.removeClass('empty');

                this.gallery.html('');

                for (var i = 0; i < gallery.length; i++) {
                    this._createSlide(gallery[i]);
                }

                this.input.val(JSON.stringify(gallery));
            }
        },
        // Create a new thumbnail
        _createSlide: function (document) {
            var document = this.documentsBag.getDocument(document);

            var thumbnail = $('<li class="form-group__slide" data-id="' + document.id + '" data-type="image" title="' + html_entities(document.name) + '"><i class="icon-cancel"></i></li>');

            $(document.thumbnail).prependTo(thumbnail);

            this.gallery.append(thumbnail);
        }
    };

    window.Gallery = Gallery;


    // GalleryIndicator Constructor
    function GalleryIndicator(file, uploader) {
        this.uploader = uploader;

        this._init(file);
    }

    inheritsFrom(GalleryIndicator, UploadIndicator);

    GalleryIndicator.prototype._init = function (file) {
        this.container = $('<li class="form-group__slide"></li>');

        this.progress = $('<div class="upload__progress"></div>').appendTo(this.container);
        this.progressBar = $('<div class="upload__progress-bar"></div>').appendTo(this.progress);

        this.thumbnail = $('<div class="document-thumbnail"></div>').appendTo(this.container);
    };

    GalleryIndicator.prototype._success = function (upload) {
        upload = upload.summary;

        window.documentsBag.addDocument(upload.id, upload);
        window.documentsLibrary.createDocument(upload.id, upload.name, upload.type, upload.thumbnail, true);

        if (upload.type !== 'image') {
            this.container.remove();

            return;
        }

        this.container.attr('data-id', upload.id);
        this.container.attr('data-type', upload.type);
        this.container.attr('title', html_entities(upload.name));
        this.container.append($('<i class="icon-cancel"></i>'));
        this.thumbnail.replaceWith(upload.thumbnail);

        this.uploader.controller.refreshInput();
    };

    GalleryIndicator.prototype._error = function (message) {
        this.container.remove();
    };

    window.GalleryIndicator = GalleryIndicator;

})(window);