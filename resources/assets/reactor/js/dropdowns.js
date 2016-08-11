;
(function (window) {
    'use strict';

    /**
     * Dropdown constructor
     *
     * @param DOM Object
     * @param object
     */
    function Dropdown(dropdowns) {
        this.dropdowns = dropdowns;
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
                    self._closeDropdowns($(this));

                    e.preventDefault();
                    e.stopPropagation();
                }
            });

            this.dropdowns.find('a').on('click', function (e) {
                e.stopPropagation();

                return true;
            });
        },
        // Opens a dropdown
        _openDropdown: function (dropdown) {
            this._closeDropdowns();

            dropdown.addClass(this.activeClass);

            this._bindCloseEscape();
            this._bindCloseClick();
        },
        // Closes all dropdowns
        _closeDropdowns: function()
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
                    self._closeDropdowns();
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
                self._closeDropdowns();
            });
        },
        // Dynamically unbinds click event for closing dropdowns
        _unbindCloseClick: function () {
            $(document).unbind('click.dropdowns');
        }
    };

    // Register to window namespace
    window.Dropdown = Dropdown;

})(window);

new Dropdown($('.has-dropdown'));