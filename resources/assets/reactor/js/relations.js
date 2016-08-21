;(function (window) {
    'use strict';

    /**
     * RelationField Constructor
     *
     * @param DOM Object
     */
    function RelationField(el) {
        this.el = el;

        this._init();
    }

    RelationField.prototype = {
        _init: function () {
            this.searchurl = this.el.data('searchurl');
            this.mode = this.el.data('mode');

            this.items = this.el.find('ul.related-items');
            this.results = this.el.find('ul.related-search__results');
            this.search = this.el.find('input[name="_relatedsearch"]');
            this.value = this.el.find('input[type="hidden"]');

            this.searching = false;

            this.itemKeys = [];
            this._extractItems();

            this._initEvents();
        },
        _extractItems: function () {
            var items = this.value.val().trim();

            if (items == '') {
                return;
            }

            if (this.mode === 'single') {
                this.itemKeys.push(parseInt(items));
            } else {
                this.itemKeys = JSON.parse(items);
            }
        },
        _initEvents: function () {
            var self = this;

            // Search input
            this.search.on('keydown', function (e) {
                var q = $(this).val().trim(),
                    input = $(this);

                // Press escape
                if (e.which == 27) {
                    e.stopPropagation();

                    (q === '') ? input.blur() : input.val('');

                    self._clearSearch();

                    return;

                    // Press down
                } else if (e.which == 40) {
                    e.stopPropagation();

                    if (self._hasResults()) {
                        self._focusResult(0);
                    }

                    return;

                    // Press enter
                } else if (e.which == 13) {
                    e.preventDefault();
                }

                if (!self.searching && q.length > 0) {
                    self._search(q);
                }

                if (q == '') {
                    self._clearSearch();
                }
            });

            this.search.on('focus', function () {
                self._showResults();
            });

            // Hiding search
            $('body').click(function () {
                self._hideResults();
            });

            this.el.click(function (e) {
                e.stopPropagation();
            });

            // Toggle between results
            this.results.on('keydown', 'input.related-search__input', function (e) {
                e.stopPropagation();
                e.preventDefault();

                var parent = $(this).closest('li');

                // Press down
                if (e.which == 40) {
                    if ( ! parent.is(':last-child')) {
                        self._focusResult(parent.index() + 1);
                    }
                // Press up
                } else if (e.which == 38) {
                    if (parent.is(':first-child')) {
                        self._focusSearch();
                    } else {
                        self._focusResult(parent.index() - 1);
                    }

                // Press enter
                } else if (e.which == 13) {
                    self._addItem(parent);
                }
            });

            // Add item
            this.results.on('click', 'li.related-search__result', function () {
                self._addItem($(this));
            });

            // Remove item
            this.items.on('click', 'i.related-item__close', function (e) {
                e.stopPropagation();

                self._removeItem($(this).parent());
            });

            // Hover result
            this.results.on('mouseenter', 'li.related-search__result', function () {
                self._focusResult($(this).index());
            });

            // Sortable
            if (this.mode !== 'single') {
                this.items.sortable({
                    tolerance: 'pointer',
                    placeholder: 'placeholder',
                    opacity: 0.7,
                    delay: 50,
                    stop: function () {
                        self._regenerateValue();
                    }
                });
            }
        },
        _search: function (keywords) {
            var self = this;

            if (!self.searching) {
                $.post(this.searchurl, {q: keywords}, function (data) {
                    self._populateResults(data);
                });
            }
        },
        _hasResults: function () {
            return (this.results.find('li.related-search__result').length > 0);
        },
        _focusResult: function (i) {
            var results = $(this.results).find('li.related-search__result'),
                result = results.eq(i);

            results.removeClass('related-search__result--selected');
            result.addClass('related-search__result--selected');

            result.find('input').focus();
        },
        _focusSearch: function() {
            $(this.results).find('li.related-search__result').removeClass('related-search__result--selected');

            this.search.focus();
        },
        _populateResults: function (items) {
            this.results.empty();

            for (var key in items) {
                if (this.itemKeys.indexOf(parseInt(key)) == -1) {
                    var item = this._addResult(key, items[key]);

                    this.results.append(item);
                }
            }
        },
        _addResult: function (id, title) {
            return $('<li class="related-search__result">' + title + '<input class="related-search__input" type="text" value="' + id + '"></li>');
        },
        _addItem: function(item) {
            var id = item.find('input').val();

            var item = $('<li class="related-item" data-id="' + id + '">' + item.text() + '<i class="icon-cancel related-item__close"></i></li>');

            if (this.mode === 'single') {
                this.items.empty();
                this.itemKeys = [];
            }

            this.items.append(item);

            this.itemKeys.push(item.data('id'));

            this._regenerateValue();

            this._clearSearch();

            this.search.focus();
        },
        _removeItem: function(item) {
            var i = this.itemKeys.indexOf(item.data('id'));
            delete this.itemKeys[i];

            item.remove();

            this._regenerateValue();
        },
        _regenerateValue: function () {
            var val = '';

            if (this.mode === 'single') {
                var item = this.items.find('li.related-item:first-child');

                if (item.length == 1) {
                    val = item.data('id');
                }
            } else {
                var array = [],
                    items = this.items.find('li.related-item');

                for (var i = 0; i < items.length; i++) {
                    array.push($(items[i]).data('id'));
                }

                val = JSON.stringify(array);
            }

            this.value.val(val);
        },
        _clearSearch: function () {
            this.results.empty();
            this.search.val('');
        },
        _showResults: function () {
            this.results.removeClass('related-search__results--hidden');
        },
        _hideResults: function () {
            this.results.addClass('related-search__results--hidden');
        }
    };

    window.RelationField = RelationField;

})(window);