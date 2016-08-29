;(function (window) {
    'use strict';

    function Searcher() {
    }

    Searcher.prototype = {
        initSearcher: function () {
            this.searchurl = this.el.data('searchurl');

            this.results = this.el.find('ul.related-search__results');
            this.search = this.el.find('input[name="_relatedsearch"]');

            this.searching = false;

            this.itemKeys = [];
            this._extractItems();

            this._initSearcherEvents();
        },
        _initSearcherEvents: function () {
            var self = this;

            // Search input
            this.search.on('keydown.searchable', function (e) {
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

                    self._searchPressReturn(q);
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
            this.results.on('keydown.searchable', 'input.related-search__input', function (e) {
                e.stopPropagation();
                e.preventDefault();

                var parent = $(this).closest('li');

                // Press down
                if (e.which == 40) {
                    if (!parent.is(':last-child')) {
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
            this.results.on('click.searchable', 'li.related-search__result', function () {
                self._addItem($(this));
            });

            // Hover result
            this.results.on('mouseenter.searchable', 'li.related-search__result', function () {
                self._focusResult($(this).index());
            });
        },
        _searchPressReturn: function (q) {
            return;
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
        _focusSearch: function () {
            $(this.results).find('li.related-search__result').removeClass('related-search__result--selected');

            this.search.focus();
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

    window.Searcher = Searcher;

})(window);