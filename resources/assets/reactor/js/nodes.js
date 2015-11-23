;
(function (window) {
    'use strict';

    /**
     * NodesNavigation constructor
     */
    function NodesNavigation() {
        this._init();
    }

    // NodesNavigation prototype
    NodesNavigation.prototype = {
        _init: function () {
            this.tabs = $('.nodes-list-tab');
            this.flaps = $('.node-tabs > li');
            this.container = $('#navigation-nodes-content');
            this.trees = this.container.find('ul.nodes-list');
            this.whiteout = $('#navigation-nodes-whiteout');

            this.sortableTrees = [];

            this.localeURL = this.container.data('localeurl');
            this.sortURL = this.container.data('sorturl');

            this.enabled = true;

            this._initEvents();
        },
        _initEvents: function () {
            var self = this;

            this.flaps.on('click', function () {
                self._changeTab($(this));
            });

            this.trees.each(function () {
                var treeID = $(this).attr('id');

                var sortable = $('#' + treeID).sortable({
                    connectWith: '#' + treeID + ' ul:not(.content-item-options-list)',
                    items: '> li, .node-children > li',
                    handle: '.drag-handle',
                    placeholder: 'placeholder',
                    toleranceElement: '> .node-label',
                    tolerance: 'pointer',
                    opacity: 0.7,
                    delay: 50,
                    start: function (e, ui) {
                        ui.placeholder.height(ui.item.height());

                        optionListsHelper.closeLists();
                    },
                    stop: function (e, ui) {
                        self._move(ui.item);
                    }
                });

                self.sortableTrees.push(sortable);
            });
        },
        _changeTab: function (flap) {
            if (this.enabled) {
                this.flaps.removeClass('active');
                this.tabs.removeClass('active');

                flap.addClass('active');
                $('.nodes-list-' + flap.data('for')).addClass('active');

                this._changeTreeLocale(
                    flap.data('for')
                );
            }

        },
        _changeTreeLocale: function (locale) {
            $.post(this.localeURL, {'locale': locale});
        },
        _move: function (item) {
            var movement = this._determineMovement(item),
                self = this;

            this._disable();

            $.post(this.sortURL, movement, function (data) {
                self._refreshAllTrees(movement);

                self._enable();
            });
        },
        _determineMovement: function (item) {
            var next = item.next();

            if (next.length === 1) {
                return {action: 'before', sibling: next.data('nodeid'), node: item.data('nodeid')}
            } else {
                return {action: 'after', sibling: item.prev().data('nodeid'), node: item.data('nodeid')}
            }
        },
        _disable: function () {
            this.enabled = false;

            this._disableSortables();

            this._disableView();
        },
        _enable: function () {
            this.enabled = true;

            this._enableView();

            this._enableSortables();
        },
        _disableSortables: function () {
            for (var i = 0; i < this.sortableTrees.length; i++) {
                this.sortableTrees[i].sortable('disable');
            }
        },
        _enableSortables: function () {
            for (var i = 0; i < this.sortableTrees.length; i++) {
                this.sortableTrees[i].sortable('enable');
            }
        },
        _disableView: function () {
            this.whiteout.addClass('active');
        },
        _enableView: function () {
            this.whiteout.removeClass('active');
        },
        _refreshAllTrees: function (movement) {
            if (movement.action === 'before') {
                this._insertBefore(movement.node, movement.sibling);
            } else {
                this._insertAfter(movement.node, movement.sibling);
            }
        },
        _insertBefore: function (node, sibling) {
            for (var i = 0; i < this.sortableTrees.length; i++) {
                var treeNode = this.sortableTrees[i].find('[data-nodeid="' + node + '"]'),
                    treeSibling = this.sortableTrees[i].find('[data-nodeid="' + sibling + '"]');

                treeNode.insertBefore(treeSibling);
            }
        },
        _insertAfter: function (node, sibling) {
            for (var i = 0; i < this.sortableTrees.length; i++) {
                var treeNode = this.sortableTrees[i].find('[data-nodeid="' + node + '"]'),
                    treeSibling = this.sortableTrees[i].find('[data-nodeid="' + sibling + '"]');

                treeNode.insertAfter(treeSibling);
            }
        }
    };

    // Register to window namespace
    window.NodesNavigation = NodesNavigation;

})(window);

$(document).ready(function () {
    var nodesNavigation = new NodesNavigation();
});
