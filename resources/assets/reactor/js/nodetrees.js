;
(function (window) {
    'use strict';

    /**
     * NodeTree constructor
     *
     * @param DOM Object
     * @param object
     */
    function NodeTree() {
        this._init();
    }

    // NodeTree prototype
    NodeTree.prototype = {
        _init: function () {
            this.flaps = $('.nodes-tabs__tab, .tabs__nodes-tab');
            this.tabs = $('.nodes-list-container');

            this.trees = $('ul.nodes-list');

            this.localeurl = $('#navigationNodesTree').data('localeurl');
            this.sorturl = $('#navigationNodesTree').data('sorturl');

            this.blackouts = $('#navigationNodesBlackout, #childTreeWhiteout');
            this.enabled = true;

            this._initEvents();
        },
        _initEvents: function () {
            var self = this;

            this.flaps.on('click', function () {
                self._changeTab($(this));
            });

            this._initSortables(this.trees);
        },
        _initSortables: function (items) {
            var self = this;

            items.each(function () {
                var sortable = $(this).sortable({
                    connectWith: '#' + $(this).attr('id') + ' ul:not(.dropdown-sub)',
                    items: '> li, .node-children > li',
                    handle: '.node-icon',
                    placeholder: 'placeholder',
                    toleranceElement: '> .nodes-list__label',
                    tolerance: 'pointer',
                    opacity: 0.7,
                    delay: 50,
                    start: function (e, ui) {
                        ui.placeholder.height(ui.item.outerHeight());

                        dropdowns.closeDropdowns();
                    },
                    stop: function (e, ui) {
                        self._moveNode(ui.item, sortable);
                    }
                });
            });
        },
        _changeTab: function (flap) {
            if (this.enabled && ! flap.hasClass('nodes-tabs__tab--active') && ! flap.hasClass('tabs__child-link--active')) {
                var locale = flap.data('locale');

                this.flaps.removeClass('nodes-tabs__tab--active tabs__child-link--active');
                this.tabs.removeClass('nodes-list-container--active');

                $('.nodes-tabs__tab--' + locale).addClass('nodes-tabs__tab--active');
                $('.tabs__nodes-tab--' + locale).addClass('tabs__child-link--active');
                this.tabs.siblings('.nodes-list-container--' + locale).addClass('nodes-list-container--active');

                this._changeTreeLocales(locale);
            }
        },
        _changeTreeLocales: function (locale) {
            var self = this;

            self._disable();

            $.post(this.localeurl, {'locale': locale}, function (data) {
                self._enable();
            });
        },
        _moveNode: function (node, sortable) {
            var movement = this._determineMovement(node),
                self = this;

            if (movement === false) return;

            var parent = sortable.closest('.node-trees-container');
            movement['parent'] = parent.data('parentid');

            this._disable();

            $.post(this.sorturl, movement, function (response) {
                if (response.type === 'danger') {
                    sortable.sortable('cancel');

                    window.flash.addMessage(
                        response.message,
                        response.type
                    );
                } else {
                    self._refreshTrees(parent, response.html);
                }

                self._enable();
            });
        },
        _determineMovement: function (node) {
            var next = node.next(),
                prev = node.prev();

            if (next.length === 1) {
                return {action: 'before', sibling: next.data('nodeid'), node: node.data('nodeid')}
            } else if (prev.length === 1) {
                return {action: 'after', sibling: prev.data('nodeid'), node: node.data('nodeid')}
            }

            return false;
        },
        _refreshTrees: function (parent, html) {
            parent.html(html);

            this.tabs = $('.nodes-list-container');

            window.dropdowns.refreshEvents();
            this._initSortables(parent.find('ul.nodes-list'));

            window.deleteModal.refreshTriggers($('.delete-form > .option-delete, .header__action--bulk .button--bulk-delete'));
        },
        _disable: function () {
            this.enabled = false;

            this.blackouts.addClass('navigation-nodes-blackout--active');
        },
        _enable: function () {
            this.enabled = true;

            this.blackouts.removeClass('navigation-nodes-blackout--active');
        },
    };

    // Register to window namespace
    window.NodeTree = NodeTree;

})(window);

new NodeTree();