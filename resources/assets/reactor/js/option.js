;
(function (window) {
    'use strict';

    /**
     * OptionListsHelper constructor
     *
     * @param DOM Object
     * @param object
     */
    function OptionListsHelper(buttons, lists) {
        this.buttons = buttons;
        this.lists = lists;

        this._initEvents();
    }

    // OptionListsHelper prototype
    OptionListsHelper.prototype = {
        // Initialize events
        _initEvents: function () {
            var self = this;

            this.buttons.on('click.opt_h', function (e) {
                self._openListFor($(this));

                e.preventDefault();
                e.stopPropagation();
            });

            this.lists.on('click.opt_h', function (e) {
                e.stopPropagation();
            });
        },
        // Opens a list
        _openListFor: function (button) {
            this.closeLists();

            button.next().addClass('open');

            this._bindEscape();
            this._bindClick();
        },
        // Closes all lists
        closeLists: function () {
            this.lists.removeClass('open');

            this._unbindEscape();
            this._unbindClick();
        },
        // Dynamically binds escape key for closing lists
        _bindEscape: function () {
            var self = this;

            $(document).bind('keydown.opt_h', function (e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 27) {
                    self.closeLists();
                }
            });
        },
        // Dynamically unbinds escape key for closing lists
        _unbindEscape: function () {
            $(document).unbind('keydown.opt_h');
        },
        // Dynamically binds click event for closing lists
        _bindClick: function () {
            var self = this;

            $(document).unbind('click.opt_h').bind('click.opt_h', function () {
                self.closeLists();
            });
        },
        // Dynamically unbinds click event for closing lists
        _unbindClick: function () {
            $(document).unbind('click.opt_h');
        }
    };

    // Register to window namespace
    window.OptionListsHelper = OptionListsHelper;

})(window);

var optionListsHelper = new OptionListsHelper(
    $('.content-item-options-button'),
    $('.content-item-options-list')
);