;(function (window) {
    'use strict';

    /**
     * Collection constructor
     *
     * @param DOM Object
     */
    function NodeCollection(el, single) {
        this.el = el;

        this.single = (typeof single == 'undefined') ? false : single;

        this._init();
    }

    // Prototype
    NodeCollection.prototype = {
        _init: function () {
            this.container = this.el.find('.form-nodes-container');
            this.sortable = this.container.find('ul.form-items-list-sortable');
            this.results = this.container.find('ul.form-items-list-results');
            this.search = this.container.find('input[name="_nodesearch"]');
            this.valueInput = this.container.find('input[type="hidden"]');
            this.parent = this.el.closest('.form-group');

            this.searchurl = this.el.find('.form-items-search').data('searchurl');
            this.filter = this.el.find('.form-items-search').data('nodetype');

            this.searching = false;

            this._extractValue();

            this.initEvents();
        },
        _extractValue: function () {
            var nodes = this.valueInput.val().trim();

            this.nodes = [];

            if (nodes.trim() == '') {
                return;
            }

            if (this.single) {
                this.nodes.push(parseInt(nodes));
            } else {
                this.nodes = JSON.parse(nodes);
            }
        },
        initEvents: function () {
            var self = this;

            this.search.bind('keydown', function (e) {
                var q = $(this).val().trim(),
                    input = $(this);

                if (e.which == 27) {
                    e.stopPropagation();

                    if (q === '') {
                        input.blur();
                    } else {
                        input.val('');
                    }

                    self._clearSearch();

                    // This blurs field, no need to go further
                    return;
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

            this.results.on('click', 'li', function () {
                self._addToSortable($(this));
            });

            this.sortable.on('click', 'i.icon-cancel', function (e) {
                e.stopPropagation();

                self._removeNode($(this).parent());
            });

            // Hiding search
            $('body').click(function () {
                self._hideResults();
            });

            this.parent.click(function (e) {
                e.stopPropagation();
            });

            // Not sortable if single
            if (!this.single) {
                $(this.sortable).sortable({
                    tolerance: 'pointer',
                    placeholder: 'placeholder',
                    opacity: 0.7,
                    delay: 50,
                    stop: function () {
                        self._regenerateValue();
                    }
                }).disableSelection();
            }
        },
        _search: function (keywords) {
            var self = this;

            if (!self.searching) {
                $.post(this.searchurl, {q: keywords, filter: self.filter}, function (data) {
                    self._populateResults(data);
                });
            }
        },
        _populateResults: function (nodes) {
            this.results.empty();

            for (var key in nodes) {
                if (this.nodes.indexOf(parseInt(key)) == -1) {
                    var item = this._createListItem(key, nodes[key]);

                    this.results.append(item);
                }
            }
        },
        _createListItem: function (id, title) {
            return $('<li data-id="' + id + '">' + title + '</li>');
        },
        _addToSortable: function (item) {
            item.append('<i class="icon-cancel"></i>');

            // Clear for single item
            if (this.single) {
                this.sortable.empty();
                this.nodes = [];
            }

            this.sortable.append(item);

            this.nodes.push(item.data('id'));

            this._regenerateValue();

            this._clearSearch();
        },
        _removeNode: function (item) {
            var i = this.nodes.indexOf(item.data('id'));
            delete this.nodes[i];

            item.remove();

            this._regenerateValue();
        },
        _regenerateValue: function () {
            this.container.removeClass('empty');

            if (count(this.nodes) == 0) {
                this.container.addClass('empty');
            }

            var val = '';

            if (this.single) {
                var node = this.sortable.find('li:first-child');

                if (node.length == 1) {
                    val = node.data('id');
                }
            } else {
                var array = [],
                    nodes = this.sortable.find('li');

                for (var i = 0; i < nodes.length; i++) {
                    array.push($(nodes[i]).data('id'));
                }

                val = JSON.stringify(array);
            }

            this.valueInput.val(val);
        },
        _clearSearch: function () {
            this.results.empty();
            this.search.val('');
        },
        _showResults: function () {
            this.results.removeClass('hidden');
        },
        _hideResults: function () {
            this.results.addClass('hidden');
        }
    };

    window.NodeCollection = NodeCollection;

})(window);