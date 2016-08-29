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

    inheritsFrom(RelationField, Searcher);

    RelationField.prototype._init = function () {
        this.mode = this.el.data('mode');
        this.filter = this.el.data('filter');

        this.items = this.el.find('ul.related-items');
        this.value = this.el.find('input[type="hidden"]');

        this.initSearcher();

        this._initEvents();
    };

    RelationField.prototype._extractItems = function () {
        var items = this.value.val().trim();

        if (items == '') {
            return;
        }

        if (this.mode === 'single') {
            this.itemKeys.push(parseInt(items));
        } else {
            this.itemKeys = JSON.parse(items);
        }
    }

    RelationField.prototype._initEvents = function () {
        var self = this;

        // Remove item
        this.items.on('click', 'i.related-item__close', function (e) {
            e.stopPropagation();

            self._removeItem($(this).parent());
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
    }

    RelationField.prototype._search = function (keywords) {
        var self = this;

        if (!self.searching) {
            $.post(this.searchurl, {q: keywords, filter: self.filter}, function (data) {
                self._populateResults(data);
            });
        }
    }

    RelationField.prototype._addResult = function (id, title) {
        return $('<li class="related-search__result">' + title + '<input class="related-search__input" type="text" value="' + id + '"></li>');
    }

    RelationField.prototype._addItem = function(item) {
        var id = item.find('input').val();

        var item = $('<li class="related-item" data-id="' + id + '">' + item.text() + '<i class="icon-cancel related-item__close"></i></li>');

        if (this.mode === 'single') {
            this.items.empty();
            this.itemKeys = [];
        }

        this.items.append(item);

        this.itemKeys.push(id);

        this._regenerateValue();

        this._clearSearch();

        this.search.focus();
    }

    RelationField.prototype._removeItem = function(item) {
        var i = this.itemKeys.indexOf(item.data('id'));
        delete this.itemKeys[i];

        item.remove();

        this._regenerateValue();
    }

    RelationField.prototype._regenerateValue = function () {
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
    }

    window.RelationField = RelationField;

})(window);