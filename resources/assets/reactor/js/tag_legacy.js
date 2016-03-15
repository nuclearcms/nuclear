// Strict definitions
;(function (window) {
    'use strict';

    // Tag field constructor
    function TagLegacy(el) {
        this.el = el;

        this._init();
    }

    // Tag prototype
    TagLegacy.prototype = {
        // Initialize
        _init: function () {
            this.list = this.el.find('ul.taglist');
            this.inputItem = this.el.find('div.tag-input');
            this.input = this.inputItem.find('input[name="_tag"]');
            this.valueInput = this.el.find('input[type="hidden"]');

            this.tags = [];

            this._extractValue();

            this._initEvents();
        },
        // Initialize events
        _initEvents: function () {
            var self = this;

            this.input.bind('keydown', function (e) {
                var input = $(this);

                if (e.which === 27) {
                    e.stopPropagation();

                    if (input.val() === '') {
                        input.blur();
                    } else {
                        input.val('');
                    }

                } else if (e.which === 9 || e.which === 13) {
                    e.preventDefault();

                    var val = input.val().trim();

                    if (val !== '') {
                        if (self._addTag(input.val())) {
                            input.val('');
                        }
                    }
                }
            });

            // Remove buttons
            this.list.on('click', '.icon-cancel', function () {
                self._removeTag($(this));
            });
        },
        // Extracts the current value, generates the list
        _extractValue: function () {
            var values = this.valueInput.val().trim();

            if (values !== '') {
                values = values.split(',');

                for (var i = 0; i < values.length; i++) {
                    this._addTag(values[i]);
                }
            }

            this._setListClass(this.tags);
        },
        // Removes an item
        _removeTag: function (tag) {
            var parent = tag.parents('.tag');

            delete this.tags[parent.data('id')];

            parent.remove();

            this._setValue();
        },
        // Adds an item
        _addTag: function (str) {
            var i = this.tags.indexOf(str);

            if (i > -1) {
                var duplicate = this.list.find('li[data-id="' + i + '"]');

                duplicate.addClass('flash');

                setTimeout(function () {
                    duplicate.removeClass('flash');
                }, 100);

                return false;
            } else {
                this.tags.push(str);

                i = this.tags.indexOf(str);

                this._createTag(i, str);

                this._setValue();

                return true;
            }
        },
        // Creates a tag and appends to list
        _createTag: function (id, str) {
            $('<li class="tag" data-id="' + id + '">' + html_entities(str) + '<i class="icon-cancel"></i></li>').appendTo(this.list);
        },
        // Sets the value input
        _setValue: function () {
            var clean = $.grep(this.tags, function (n) {
                return (n);
            });

            this.valueInput.val(clean.join(','));

            this._setListClass(clean);
        },
        // Sets the list class
        _setListClass: function (tags) {
            if (tags.length === 0) {
                this.list.addClass('empty');
            } else {
                this.list.removeClass('empty');
            }
        }
    };

    // Register to window namespace
    window.TagLegacy = TagLegacy;

})(window);