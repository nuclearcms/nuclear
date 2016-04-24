;
(function (window) {
    'use strict';

    /**
     * NavigationModulesHelper constructor
     *
     * @param DOM Object
     * @param object
     */
    function NavigationModulesHelper(modules) {
        this.modules = modules;

        this._initEvents();
    }

    // NavigationModulesHelper prototype
    NavigationModulesHelper.prototype = {
        // Initialize events
        _initEvents: function () {
            var self = this;

            this.modules.on('click.nav_h mouseenter.nav_h', function (e) {
                self._openModuleFor($(this));

                e.preventDefault();
                e.stopPropagation();
            });

            this.modules.on('mouseleave.nav_h', function (e) {
                self.closeModules();
            });

            this.modules.find('a').on('click', function(e)
            {
                e.stopPropagation();

                return true;
            });
        },
        // Opens a list
        _openModuleFor: function (module) {
            this.closeModules();

            module.addClass('active');

            this._bindEscape();
            this._bindClick();
        },
        // Closes all lists
        closeModules: function () {
            this.modules.removeClass('active');

            this._unbindEscape();
            this._unbindClick();
        },
        // Dynamically binds escape key for closing lists
        _bindEscape: function () {
            var self = this;

            $(document).bind('keydown.nav_h', function (e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 27) {
                    self.closeModules();
                }
            });
        },
        // Dynamically unbinds escape key for closing lists
        _unbindEscape: function () {
            $(document).unbind('keydown.nav_h');
        },
        // Dynamically binds click event for closing lists
        _bindClick: function () {
            var self = this;

            $(document).bind('click.nav_h', function () {
                self.closeModules();
            });
        },
        // Dynamically unbinds click event for closing lists
        _unbindClick: function () {
            $(document).unbind('click.nav_h');
        }
    };

    // Register to window namespace
    window.NavigationModulesHelper = NavigationModulesHelper;

})(window);

var navigationModulesHelper = new NavigationModulesHelper(
    $('.navigation-module')
);