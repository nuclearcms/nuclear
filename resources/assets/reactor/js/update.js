;(function (window) {
    'use strict';

    // Uploader Constructor
    function Updater(el) {
        this._init(el);
    }

    // Updater
    Updater.prototype = {
        _init: function (el) {
            this.el = el;

            this.progressBar = $('#progress-bar');
            this.progressMessage = $('#progress-message');

            this.startRoute = this.el.data('startroute');

            this._start();
        },
        // Starts the updater
        _start: function () {
            this._request(this.startRoute);
        },
        _next: function (data) {
            this.progressMessage.text(data.message);

            if (data.next) {
                this._request(data.next);
            } else {
                this._setComplete();
            }

        },
        // Makes an ajax request
        _request: function (requestURL) {
            var self = this;

            $.post(requestURL, [], function(data)
            {
                self._setProgress(data.progress);

                self._next(data);
            });
        },
        // Sets the width of progress bar
        _setProgress: function (percent) {
            this.progressBar.width(percent.toString() + "%");
        },
        // Sets the update status to complete
        _setComplete: function()
        {
            this.progressBar.addClass('complete');
        }
    };

    // Register updater to the window namespace
    window.Updater = Updater;

})(window);

var updater = new Updater($('#updater-progress-indicator'));