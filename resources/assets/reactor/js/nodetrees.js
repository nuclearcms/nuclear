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
        _init: function()
        {
            this.flaps = $('.nodes-tabs__tab');
            this.tabs = $('.nodes-list-container');

            this.localeurl = $('#navigationNodesTree').data('localeurl');

            this.blackout = $('#navigationNodesBlackout');
            this.enabled = true;

            this._initEvents();
        },
        _initEvents:function()
        {
            var self = this;

            this.flaps.on('click', function () {
                self._changeTab($(this));
            });
        },
        _changeTab: function(flap)
        {
            if (this.enabled) {
                var locale = flap.data('locale');

                this.flaps.removeClass('nodes-tabs__tab--active');
                this.tabs.removeClass('nodes-list-container--active');

                this.flaps.siblings('.nodes-tabs__tab--' + locale).addClass('nodes-tabs__tab--active');
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
        _disable: function () {
            this.enabled = false;

            this.blackout.addClass('navigation-nodes-blackout--active');
        },
        _enable: function () {
            this.enabled = true;

            this.blackout.removeClass('navigation-nodes-blackout--active');
        },
    };

    // Register to window namespace
    window.NodeTree = NodeTree;

})(window);

new NodeTree();