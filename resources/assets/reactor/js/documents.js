;(function (window) {
    'use strict';

    /**
     * Document constructor
     */
    function Document(el, library, documentsBag) {
        this.el = el;
        this.library = library;
        this.documentsBag = documentsBag;

        this._init();
    }

    // Prototype
    Document.prototype = {
        _init: function () {
            this.input = this.el.find('input[type="hidden"]');

            this.container = this.el.find('.form-group__document-container');
            this.libraryButton = this.el.find('.form-group__buttons > .button--library');
            this.clearButton = this.el.find('.form-group__buttons > .button--clear');

            this.document = this.el.find('figure.form-group__document');

            this.mode = 'document';
            this.filter = this.container.data('filter');

            this._populateDocumentsBag();

            this._initEvents();
        },
        _populateDocumentsBag: function () {
            if (this.document.data('id')) {
                window.documentsBag.addDocument(
                    this.document.data('id'),
                    this.document.data('summary'));

                this.document.attr('data-summary', '');
            }
        },
        _initEvents: function () {
            var self = this;

            this.clearButton.on('click', function (e) {
                self._clearDocument();

                e.preventDefault();
                e.stopPropagation();
            });

            this.libraryButton.on('click', function (e) {
                self.library.run(self);

                e.preventDefault();
                e.stopPropagation();
            });
        },
        _clearDocument: function () {
            this.input.val('');

            this.container.addClass('empty');
        },
        getValue: function () {
            return this.input.val();
        },
        setValue: function (document) {
            if (document !== null && document !== '') {
                this.container.removeClass('empty');

                this.input.val(document);

                var document = this.documentsBag.getDocument(document);

                this.container.children('figure').remove();

                var thumbnail = $('<figure class="form-group__document" data-id="' + document.id + '" data-type="' + document.type + '"></figure>');
                $('<span>' + document.thumbnail + '</span>').appendTo(thumbnail);
                $('<figcaption class="form-group__document-title">' + document.name + '</figcaption>').appendTo(thumbnail);

                this.container.prepend(thumbnail);
            } else {
                this._clearDocument();
            }
        }
    };

    window.Document = Document;

})(window);