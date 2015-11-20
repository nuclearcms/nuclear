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
            this.container = $('#navigation-nodes-content')

            this.localeURL = this.container.data('localeurl')

            this._initEvents();
        },
        _initEvents: function () {
            var self = this;

            this.flaps.on('click', function () {
                self._changeTab($(this));
            });
        },
        _changeTab: function (flap) {
            this.flaps.removeClass('active');
            this.tabs.removeClass('active');

            flap.addClass('active');
            $('.nodes-list-' + flap.data('for')).addClass('active');

            this._changeTreeLocale(
                flap.data('for')
            );
        },
        _changeTreeLocale: function (locale) {
            $.post(this.localeURL, {'locale': locale});
        }
    };

    // Register to window namespace
    window.NodesNavigation = NodesNavigation;

})(window);

var nodesNavigation = new NodesNavigation();