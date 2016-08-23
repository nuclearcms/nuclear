;
(function (window) {
    'use strict';

    /**
     * Dropdown constructor
     *
     * @param object
     */
    function Dropdown() {
        this.dropdowns = $('.has-dropdown');
        this.activeClass = 'has-dropdown--active';

        this._initEvents();
    }

    // Dropdown prototype
    Dropdown.prototype = {
        _initEvents: function () {
            var self = this;

            this.dropdowns.on('click.dropdowns', function (e) {
                self._openDropdown($(this));

                e.preventDefault();
                e.stopPropagation();
            });

            this.dropdowns.on('mouseenter.dropdowns', function (e) {
                if ($(this).data('hover') === true) {
                    self._openDropdown($(this));

                    e.preventDefault();
                    e.stopPropagation();
                }
            });

            this.dropdowns.on('mouseleave.dropdowns', function (e) {
                if ($(this).data('hover') === true) {
                    self.closeDropdowns($(this));

                    e.preventDefault();
                    e.stopPropagation();
                }
            });

            this.dropdowns.find('a, button').on('click.dropdowns', function (e) {
                e.stopPropagation();

                return true;
            });
        },
        // Opens a dropdown
        _openDropdown: function (dropdown) {
            this.closeDropdowns();

            dropdown.addClass(this.activeClass);

            this._bindCloseEscape();
            this._bindCloseClick();
        },
        // Closes all dropdowns
        closeDropdowns: function()
        {
            this.dropdowns.removeClass(this.activeClass);

            this._unbindCloseEscape();
            this._unbindCloseClick();
        },
        // Dynamically binds escape key for closing dropdowns
        _bindCloseEscape: function () {
            var self = this;

            $(document).bind('keydown.dropdowns', function (e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 27) {
                    self.closeDropdowns();
                }
            });
        },
        // Dynamically unbinds escape key for closing dropdowns
        _unbindCloseEscape: function () {
            $(document).unbind('keydown.dropdowns');
        },
        // Dynamically binds click event for closing dropdowns
        _bindCloseClick: function () {
            var self = this;

            $(document).bind('click.dropdowns', function () {
                self.closeDropdowns();
            });
        },
        // Dynamically unbinds click event for closing dropdowns
        _unbindCloseClick: function () {
            $(document).unbind('click.dropdowns');
        },
        refreshEvents: function () {
            this.dropdowns.unbind('click.dropdowns, mouseenter.dropdowns, mouseleave.dropdowns');
            this.dropdowns.find('a, button').unbind('click.dropdowns');

            this.dropdowns = $('.has-dropdown');

            this._initEvents();
        }
    };

    // Register to window namespace
    window.Dropdown = Dropdown;

})(window);

window.dropdowns = new Dropdown();