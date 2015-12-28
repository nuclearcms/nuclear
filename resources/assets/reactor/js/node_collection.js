;(function (window) {
    'use strict';

    /**
     * Collection constructor
     *
     * @param DOM Object
     */
    function NodeCollection(el) {
        this.el = el;

        this._init();
    }

    // Prototype
    NodeCollection.prototype = {
        _init: function () {
            this.container = this.el.find('.form-nodes-container');
            this.sortable = this.container.find('ul.form-nodes-list-sortable');
            this.results = this.container.find('ul.form-nodes-list-results');
            this.search = this.container.find('input[name="_nodesearch"]');
            this.valueInput = this.container.find('input[type="hidden"]');

            this.searchurl = this.el.find('.form-nodes-search').data('searchurl');

            this.searchCountdown = null;

            this._extractValue();

            this.initEvents();
        },
        _extractValue: function () {
            var nodes = this.valueInput.val().trim();

            if (nodes !== '') {
                this.nodes = JSON.parse(nodes);
            } else {
                this.nodes = [];
            }
        },
        initEvents: function () {
            var self = this;

            this.search.bind('keydown', function (e) {
                var q = $(this).val().trim();

                if (e.keyCode == 27) {
                    self._escapeInput();
                }

                if (e.keyCode == 13) {
                    e.preventDefault();
                }

                if (self.searchCountdown === null) {
                    if (q !== '') {
                        self._search(q);
                    }
                }
            });

            this.search.on('focus', function () {
                self._showResults();
            });

            this.results.on('click', 'li', function () {
                self._addToSortable($(this));
            });

            this.sortable.on('click', 'i.icon-cancel', function(e) {
                e.stopPropagation();

                self._removeNode($(this).parent());
            });

            $(this.sortable).sortable({
                tolerance : 'pointer',
                placeholder : 'placeholder',
                opacity : 0.7,
                delay: 50,
                stop : function() { self._regenerateValue(); }
            }).disableSelection();
        },
        _setSearchCountdown: function (keywords) {
            var self = this;

            this.searchCountdown = setTimeout(function () {
                self.searchCountdown = null;

                self._search(keywords, true);
            }, 1000);
        },
        _search: function (keywords, withoutCountdown) {
            var self = this;

            $.post(this.searchurl, {q: keywords}, function (data) {
                self._populateResults(data);
            });

            if(typeof withoutCountdown !== 'undefined' && withoutCountdown !== true)
            {
                this._setSearchCountdown(keywords);
            }
        },
        _populateResults: function (nodes) {
            this.results.empty();

            for (var key in nodes) {
                if (this.nodes.indexOf(key) == -1) {
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

            this.sortable.append(item);

            this.nodes[item.data('id')] = item.data('id');

            this._regenerateValue();

            this._clearSearch();
        },
        _removeNode: function(item)
        {
            delete this.nodes[item.data('id')];

            item.remove();

            this._regenerateValue();
        },
        _regenerateValue: function () {
            this.container.removeClass('empty');

            if (this._getNodesCount() == 0) {
                this.container.addClass('empty');
            }

            var array = $(this.sortable).sortable('toArray', {attribute: 'data-id'});

            this.valueInput.val(JSON.stringify(array));
        },
        _clearSearch: function()
        {
            this.results.empty();
            this.search.val('');
        },
        _escapeInput: function () {
            this.search.blur();

            this._hideResults();
        },
        _showResults: function () {
            this.results.removeClass('hidden');
        },
        _hideResults: function () {
            this.results.addClass('hidden');
        },
        _getNodesCount: function()
        {
            var i = 0;

            for(var j in this.nodes) {i++;}

            return i;
        }
    };

    window.NodeCollection = NodeCollection;

})(window);