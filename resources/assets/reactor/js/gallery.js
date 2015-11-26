;( function(window) {
    'use strict';

    /**
     * Gallery constructor
     *
     * @param DOM Object
     */
    function Gallery(el, library) {
        this.type = 'gallery';

        this.el = el;
        this.library = library;

        this.container = this.el.find('.form-media-container');

        this.input = this.el.find('input[type="hidden"]');

        this.addButton = this.el.find('.button-add');
        this.clearButton = this.el.find('.button-clear');

        this.mediaGallery = this.el.find('.form-media-gallery');

        this._initEvents();
    }

    // Prototype
    Gallery.prototype = {
        // Bind events
        _initEvents : function() {
            var self = this;

            $(this.mediaGallery).sortable({
                cursor : 'move',
                tolerance : 'pointer',
                placeholder : 'placeholder',
                opacity : 0.7,
                delay: 50,
                stop : function() { self._setGallery(); }
            }).disableSelection();

            // Bind events for non touch screens
            if(!Modernizr.touch) {
                this.mediaGallery.find('.icon-cancel').on('click', function() {
                    var parent = $(this).parent();

                    $(parent).remove();

                    self._setGallery();
                });
            }

            this.clearButton.on('click', function(e) {
                self._clearGallery();

                e.preventDefault();
                e.stopPropagation();
            });

            this.addButton.on('click', function(e) {
                self.library.run(self);

                e.preventDefault();
                e.stopPropagation();
            });
        },
        _clearGallery: function() {
            this.input.val('');

            this.mediaGallery.html('');

            this.container.addClass('empty');
        },
        // Parses gallery string
        _parseGallery : function() {
            var array = $(this.mediaGallery).sortable('toArray', {attribute: 'data-id'});

            return JSON.stringify(array);
        },
        // Sets gallery string
        _setGallery : function() {
            this.input.val(this._parseGallery());
        },
        // Returns the current value
        getValue : function() {
            return this.input.val();
        },
        // Sets the value
        setValue : function(gallery) {
            this._clearGallery();
            // Check length
            if(gallery.length > 0) {
                this.container.removeClass('empty');

                this.mediaGallery.html('');

                var array = [];

                for(var i = 0; i < gallery.length; i++) {
                    array.push(gallery[i].id);

                    this._createThumbnail(gallery[i]);
                }

                this.input.val(JSON.stringify(array));
            }
        },
        // Create a new thumbnail
        _createThumbnail : function(media) {
            var thumbnail = $('<li data-id="' + media.id + '"><i class="icon-cancel"></i></li>');

            $('<img src="' + media.thumbnail + '" alt="' + html_entities(media.name) + '">').appendTo(thumbnail);

            this.mediaGallery.append(thumbnail);
        }
    };

    window.Gallery = Gallery;

})(window);

// Run when document is loaded
$(document).ready(function() {

    // Run for all
    $('.nc-form-gallery').each(function() {
        var gallery = new Gallery($(this), App);
    });

});