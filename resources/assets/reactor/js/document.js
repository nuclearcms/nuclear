;(function (window) {
    'use strict';

    /**
     * Document constructor
     *
     * @param DOM Object
     */
    function Document(el, library) {
        this.type = 'file';

        this.el = el;
        this.library = library;

        this.container = this.el.find('.form-media-container');

        this.input = this.el.find('input[type="hidden"]');

        this.addButton = this.el.find('.button-add');
        this.removeButton = this.el.find('.button-clear');

        this.thumbnail = this.el.find('.form-document-thumbnail img');
        this.fileName = this.el.find('.form-document-name');

        this.filter = this.el.data('filter');

        this._initEvents();
    }

    // Prototype
    Document.prototype = {
        // Bind events
        _initEvents: function () {
            var self = this;

            this.removeButton.on('click', function (e) {
                self._removeDocument();

                e.preventDefault();
                e.stopPropagation();
            });

            // Bind open
            this.addButton.on('click', function (e) {
                self.library.run(self);

                e.preventDefault();
                e.stopPropagation();
            });
        },
        // Remove file
        _removeDocument: function () {
            this.input.val('');

            this.thumbnail.attr('src', '');

            this.fileName.text('');

            this.container.addClass('empty');
        },
        // Returns the current value
        getValue: function () {
            return this.input.val();
        },
        // Sets the value
        setValue: function (media) {
            if (media !== null) {
                this.container.removeClass('empty');

                this.input.val(media.id);

                this.fileName.text(media.name);

                this.thumbnail.attr('src', media.thumbnail);
            } else {
                this._removeDocument();
            }
        }
    };

    // Register to window namespace
    window.Document = Document;

})(window);