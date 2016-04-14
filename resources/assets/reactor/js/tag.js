// Strict definitions
;(function (window) {
    'use strict';

    // Tag field constructor
    function Tag(el) {
        this.el = el;

        this._init();
    }

    // Tag prototype
    Tag.prototype = {
        // Initialize
        _init: function () {
            this.list = this.el.find('ul.taglist');
            this.inputItem = this.el.find('div.tag-input');
            this.input = this.inputItem.find('input[name="name"]');
            this.results = this.el.find('ul.form-items-list-results');
            this.parent = this.el.closest('.form-group');

            this.urldetach = this.el.data('urldetach');
            this.urladd = this.el.data('urladd');
            this.urlsearch = this.el.data('urlsearch');

            this.tags = [];
            this.tempTags = [];

            this.searching = false;

            this._parseExistingTags();

            this._initEvents();
        },
        _parseExistingTags: function () {
            var tags = this.list.find('.tag'),
                self = this;

            tags.each(function () {
                var el = $(this);

                self._addToTagList(
                    el.data('id'),
                    el.find('span').text().toLowerCase()
                );
            });
        },
        _addToTagList: function (id, name) {
            this.tags[id] = name;
        },
        // Initialize events
        _initEvents: function () {
            var self = this;

            this.input.bind('keydown', function (e) {
                var input = $(this),
                    val = input.val().trim();

                if (e.which === 27) {
                    e.stopPropagation();

                    if (val === '') {
                        input.blur();
                    } else {
                        input.val('');
                    }

                    self._clearSearch();

                    // This blurs field, no need to go further
                    return;
                } else if (e.which === 9 || e.which === 13) {
                    e.preventDefault();

                    if (val !== '') {
                        self._addTag(val);
                        input.val('');
                    }

                    // This adds an item, no need to go further
                    return;
                }

                if (!self.searching && val.length > 0) {
                    self._search(val);
                }
            });

            // Remove buttons
            this.list.on('click', '.icon-cancel', function () {
                self._detachTag($(this));
            });

            this.results.on('click', 'li', function () {
                self._addTag($(this).text());

                self._clearSearch();
            });

            this.input.on('focus', function () {
                self._showResults();
            });

            // Hiding search
            $('body').click(function () {
                self._hideResults();
            });

            this.parent.click(function (e) {
                e.stopPropagation();
            });
        },
        _detachTag: function (tag) {
            var parent = tag.closest('.tag'),
                id = parent.data('id');
            // Quit if an action is already going on
            if (parent.hasClass('disabled')) {
                return;
            }

            parent.addClass('disabled');

            var self = this;

            $.ajax({
                type: "POST",
                url: self.urldetach,
                data: {
                    _method: "DELETE",
                    tag: id
                },
                success: function (data) {
                    self._removeTag(data.id);
                },
                error: function () {
                    self._enableTag(id)
                }
            });
        },
        // Removes an item
        _removeTag: function (id) {
            var tag = this.list.find('li[data-id="' + id + '"]');
            delete this.tags[id];
            tag.remove();
            this._setListClass();
        },
        // Removes a temporary item
        _removeTempTag: function (id) {
            var tag = this.list.find('li[data-tempid="' + id + '"]');
            delete this.tempTags[id];
            tag.remove();
            this._setListClass();
        },
        _enableTag: function (id) {
            this.list.find('li[data-id="' + id + '"]').removeClass('disabled');
        },
        _enableTempTag: function (tempid, id) {
            var tag = this.list.find('li[data-tempid="' + tempid + '"]');
            tag.removeClass('disabled');
            tag.removeData('tempid');
            tag.attr({'data-id': id});
        },
        // Adds an item
        _addTag: function (str) {
            var i = this.tags.indexOf(str.toLowerCase());

            if (i > -1) {
                this._flashTag(i);
            } else {
                this.tempTags.push(str);
                i = this.tempTags.indexOf(str);
                this._createTag(i, str);

                this._linkTag(i, str);

                this._setListClass();

                this._clearSearch();
            }
        },
        _linkTag: function (i, str) {
            var self = this;

            $.ajax({
                type: "POST",
                url: self.urladd,
                data: {
                    _method: "PUT",
                    name: str
                },
                success: function (data) {
                    if (!self._tagExists(data.id)) {
                        self._enableTempTag(i, data.id);
                        self._addToTagList(data.id, data.name);
                        delete self.tempTags[i];
                    } else {
                        self._removeTempTag(i);
                        self._flashTag(data.id);
                    }

                    self._clearSearch();

                    self._setListClass();
                },
                error: function () {
                    self._removeTempTag(i);

                    self._setListClass();
                }
            });
        },
        _tagExists: function (id) {
            return (typeof this.tags[id] != 'undefined') ? true : false;
        },
        // Creates a tag and appends to list
        _createTag: function (id, str) {
            $('<li class="tag disabled" data-id="" data-tempid="' + id + '">' + html_entities(str) + '<i class="icon-cancel"></i></li>').appendTo(this.list);
        },
        // Flashes a tag
        _flashTag: function (id) {
            var duplicate = this.list.find('li[data-id="' + id + '"]');

            duplicate.addClass('flash');

            setTimeout(function () {
                duplicate.removeClass('flash');
            }, 100);
        },
        // Sets the list class
        _setListClass: function () {
            if (count(this.tags) == 0) {
                this.list.addClass('empty');
            } else {
                this.list.removeClass('empty');
            }
        },
        // Search for tags
        _search: function (keywords) {
            var self = this;

            if(!self.searching) {
                $.post(this.urlsearch, {q: keywords}, function (data) {
                    self._populateResults(data);
                });
            }
        },
        // Populate the results list
        _populateResults: function (tags) {
            // Do not populate if empty
            // This is to prevent the results table reappearing after enter is pressed
            if(this.input.val().trim() == '')
            {
                return;
            }

            this.results.empty();

            for (var key in tags) {
                if (!this._tagExists(key)) {
                    var item = this._createListItem(key, tags[key]);

                    this.results.append(item);
                }
            }
        },
        // Creates an item in the results list
        _createListItem: function (id, name) {
            return $('<li data-id="' + id + '">' + name + '</li>');
        },
        _showResults: function () {
            this.results.removeClass('hidden');
        },
        _hideResults: function () {
            this.results.addClass('hidden');
        },
        _clearSearch: function () {
            this.results.empty();
            this.input.val('');
        },
    };

    // Register to window namespace
    window.Tag = Tag;

})(window);

// Tag fields
$('.form-group-tag').each(function () {
    new Tag($(this));
});

$('.form-group input').focus(function () {
    $(this).closest('.form-group').addClass('focus');
});
$('.form-group input').blur(function () {
    $(this).closest('.form-group').removeClass('focus');
});