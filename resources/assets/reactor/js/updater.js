;(function (window) {
    'use strict';

    // Uploader Constructor
    function Updater() {
        this._init();
    }

    // Updater
    Updater.prototype = {
        _init: function () {
            this.el = $('#updateIndicator');
            this.progressBar = $('#updateProgress');
            this.progressMessage = $('#updateMessage');

            this.starturl = this.el.data('starturl');
            this.completeurl = this.el.data('completeurl');

            this._start();
        },
        _start: function () {
            this._request(this.starturl);
        },
        _next: function (data) {
            this.progressMessage.text(data.message);

            if (data.next) {
                this._request(data.next);
            } else {
                this._complete();
            }
        },
        _request: function (requestURL) {
            var self = this;

            $.post(requestURL, function (response) {
                self._setProgress(response.progress);

                self._next(response);
            });
        },
        _setProgress: function (percent) {
            this.progressBar.width(percent.toString() + "%");
        },
        _complete: function () {
            window.location = this.completeurl;
        }
    };

    // Register updater to the window namespace
    window.Updater = Updater;

})(window);

var updater = new Updater();