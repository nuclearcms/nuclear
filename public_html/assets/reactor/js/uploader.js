;(function (window) {
    'use strict';

    // Uploader Constructor
    function Uploader(zone, options) {
        this.zone = zone;
        this._init(options);
    }

    // Uploader
    Uploader.prototype = {
        _init: function (options) {
            var defaults = {
                selectButton: false,
                uploadInput: false,
                focusClass: 'dropzone--enter',
                indicatorClass: 'UploadIndicator',
                outputList: false
            };

            this.options = $.extend(defaults, options);
            this.uploadurl = this.zone.attr('action');
            this.maxsize = this.zone.data('maxsize');

            this.fileQueue = [];
            this.statusUploadIndicators = [];
            this.currentFile = 0;
            this.inProcess = false;

            this._initEvents();
        },
        _initEvents: function () {
            var self = this;

            // Drag indication
            this.zone.on('dragenter, dragover', function (e) {
                e.preventDefault();
                e.stopPropagation();

                $(this).addClass('dropzone--focus');
            });

            this.zone.on('dragleave', function () {
                $(this).removeClass('dropzone--focus');
            });

            // Disable window drop
            $(window).on('drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
            });

            // Bind file drop
            this.zone.on('drop', function (e) {
                e.preventDefault();
                e.stopPropagation();

                self._queueFiles(e.originalEvent.dataTransfer.files);

                $(this).removeClass('dropzone--focus');
            });

            // Bind input change
            if (this.options.uploadInput) {
                $(this.options.uploadInput).on('change', function () {
                    self._queueFiles($(this)[0].files);
                });
            }

            // Bind optional select button if exists
            if (this.options.selectButton) {
                $(this.options.selectButton).on('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    $(self.options.uploadInput).click();
                });
            }
        },
        _queueFiles: function (files) {
            for (var i = 0; i < files.length; i++) {

                if (files[i].size < this.maxsize) {
                    this._pushFile(files[i]);
                    var indicator = this._createUploadIndicator(files[i]);

                    if (this.options.outputList !== false) {
                        $(this.options.outputList).append(indicator.getHtml());
                    }
                }

            }

            if (this.inProcess === false) {
                this._upload();
            }
        },
        _pushFile: function (file) {
            var fd = new FormData();
            fd.append('file', file);

            this.fileQueue.push(fd);
        },
        _createUploadIndicator: function (file) {
            var className = window[this.options.indicatorClass];

            var indicator = new className(file);

            this.statusUploadIndicators.push(indicator);

            return indicator;
        },
        _upload: function () {
            if (this.currentFile < this.fileQueue.length) {
                this.inProcess = true;

                this._uploadNextFile();
            } else {
                this.inProcess = false;
            }
        },
        _uploadNextFile: function () {
            var self = this;
            var fd = this.fileQueue[this.currentFile],
                indicator = this.statusUploadIndicators[this.currentFile];

            $.ajax({
                xhr: function () {
                    var xhrobj = $.ajaxSettings.xhr();
                    if (xhrobj.upload) {
                        xhrobj.upload.addEventListener('progress', function (e) {
                            indicator.setProgress(ajax_loaded(e));
                        });
                    }
                    return xhrobj;
                },
                url: self.uploadurl, type: 'POST',
                contentType: false, processData: false,
                cache: false, data: fd,
                success: function (data) {
                    indicator.complete(data);
                }
            })
            .always(function () {
                self.currentFile++;
                self._upload();
            });
        }
    };

    window.Uploader = Uploader;

    // UploadIndicator Constructor
    function UploadIndicator(file) {
        this._init(file);
    }

    // UploadIndicator
    UploadIndicator.prototype = {
        _init: function (file) {
            this.container = $('<li class="document upload"></li>');

            this.progress = $('<div class="upload__progress"></div>').appendTo(this.container);
            this.progressBar = $('<div class="upload__progress-bar"></div>').appendTo(this.progress);

            this.thumbnail = $('<div class="document-thumbnail"></div>').appendTo(this.container);

            this.filename = $('<p class="document__name upload__name">' + html_entities(file.name) + '</p>').appendTo(this.container);
        },
        getHtml: function () {
            return this.container;
        },
        setProgress: function (percent) {
            var size = percent.toString() + '%';
            this.progressBar.css({height: size, width: size});

            if (percent === 100) {
                this.progress.remove();
            }
        },
        complete: function (reply) {
            this.setProgress(100);

            if (reply.type === 'success') {
                this._success(reply.upload);
            } else if (reply.type === 'error') {
                this._error(reply.message);
            }
        },
        _success: function (upload) {
            this.thumbnail.remove();

            this.thumbnail = $(upload.thumbnail).prependTo(this.container);

            this.link = $('<a class="upload__link" href="' + upload.edit_url + '"> </a>').appendTo(this.container);

            this.filename.text(upload.name);
        },
        _error: function (message) {
            this.container.addClass('upload--danger');
            this.thumbnail.remove();

            $('<div class="upload__error"><div class="upload__error-message">' + message + '</div></div>').appendTo(this.container);
        }
    };

    window.UploadIndicator = UploadIndicator;

})(window);
//# sourceMappingURL=uploader.js.map
