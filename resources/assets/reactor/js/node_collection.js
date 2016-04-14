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
            this.sortable = this.container.find('ul.form-items-list-sortable');
            this.results = this.container.find('ul.form-items-list-results');
            this.search = this.container.find('input[name="_nodesearch"]');
            this.valueInput = this.container.find('input[type="hidden"]');
            this.parent = this.el.closest('.form-group');

            this.searchurl = this.el.find('.form-items-search').data('searchurl');

            this.searching = false;

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

                if (!self.searching && q.length > 0) {
                    self._search(q);
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

            // Hiding search
            $('body').click(function () {
                self._hideResults();
            });

            this.parent.click(function (e) {
                e.stopPropagation();
            });

            $(this.sortable).sortable({
                tolerance : 'pointer',
                placeholder : 'placeholder',
                opacity : 0.7,
                delay: 50,
                stop : function() { self._regenerateValue(); }
            }).disableSelection();
        },
        _search: function (keywords) {
            var self = this;

            if(!self.searching) {
                $.post(this.searchurl, {q: keywords}, function (data) {
                    self._populateResults(data);
                });
            }
        },
        _populateResults: function (nodes) {
            this.results.empty();

            for (var key in nodes) {
                // For some reason there are null results coming from PHP
                if (this.nodes.indexOf(key) == -1 && nodes[key] !== null) {
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