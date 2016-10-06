;(function (window) {
    'use strict';

    /**
     * Flash Constructor
     *
     * @param DOM Object
     */
    function Flash(el) {
        this.el = el;

        this._init();
    }

    Flash.prototype = {
        _init: function() {
            var self = this;

            this.el.find('.flash-message').each(function() {
                self._hideMessage($(this));
            });
        },
        _hideMessage: function (message) {
            setTimeout(function() {
                message.addClass('flash-message--hidden');
            }, 2500);

            setTimeout(function () {
                message.remove();
            }, 5000);
        },
        addMessage: function(message, level) {
            var flash = $('<div class="flash-message flash-message--' + level + '">' +
                message + '<i class="flash-message__icon icon-status-' + (level === 'danger' ? 'withheld' : 'published') + '"></i></div>')
                .appendTo(this.el);

            this._hideMessage(flash);
        }
    };

    window.Flash = Flash;

})(window);

window.flash = new Flash($('#flashContainer'));