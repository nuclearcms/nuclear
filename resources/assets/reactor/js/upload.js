;( function(window) {
    'use strict';

    // Uploader Constructor
    function Uploader(zone, options) {
        this._init(zone, options);
    }

    // Uploader
    Uploader.prototype = {
        /**
         * Constructor
         *
         * @param DOM Object
         * @param array
         */
        _init : function(self, options) {
            this.zone = self;

            var defaults = {
                selectButton : '#dropzone-select-button',
                uploadInput : '#dropzone-file',
                outputList: '#upload-list',
                enabled: true
            };

            this.options = $.extend(defaults, options);
            this.action = $(this.zone).attr('action');

            this.fileQueue = [];
            this.statusIndicators = [];
            this.current = 0;
            this.inProcess = false;

            this.maxsize = this.zone.data('maxsize');
            window.editRoute = this.zone.data('editroute');

            this._initEvents();
        },
        /**
         * Binds events
         */
        _initEvents : function () {
            var self = this;

            // Class binds
            this.zone.bind("dragenter, dragover", function(e) {
                e.preventDefault();
                e.stopPropagation();

                $(this).addClass('dragenter');
            });

            this.zone.bind("dragleave", function() {
                $(this).removeClass('dragenter');
            });

            // Disable window drop
            $(window).bind('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
            });

            // Bind file drop
            this.zone.bind("drop", function(e) {
                e.preventDefault();
                e.stopPropagation();

                self._queue(e.originalEvent.dataTransfer.files);

                $(this).removeClass('dragenter');
            });

            // Bind input change
            $(this.options.uploadInput).bind("change", function() {
                self._queue($(this)[0].files);
            });

            // Bind optional select button if exists
            if(this.options.selectButton !== false) {
                $(this.options.selectButton).bind("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    $(self.options.uploadInput).click();
                });
            }
        },
        /**
         * Adds new files to the queue
         *
         * @param array
         */
        _queue : function(files) {
            if(!this.options.enabled) { return false; }

            for(var i=0; i < files.length; i++) {
                if(files[i].size < this.maxsize) {

                    var fd = new FormData();
                    fd.append('file', files[i]);

                    this.fileQueue.push(fd);

                    // Escape the file name in order to prevent XSS
                    var indicator = new Indicator(html_entities(files[i].name), files[i].size);

                    this.statusIndicators.push(indicator);

                    if(this.options.outputList !== false) {
                        $(this.options.outputList).append(indicator.parent);
                    }
                }
            }

            if(this.inProcess === false) {
                this._upload();
            }
        },
        /**
         * Iterates through queue and uploads files
         */
        _upload : function() {
            var self = this;

            if(this.current < this.fileQueue.length) {
                this.inProcess = true;

                var fd = this.fileQueue[this.current],
                    indicator = this.statusIndicators[this.current];

                $.ajax({
                    xhr : function() {
                        var xhrobj = $.ajaxSettings.xhr();

                        if(xhrobj.upload) {
                            xhrobj.upload.addEventListener('progress', function(e) {
                                indicator.setProgress(loaded(e));
                            });
                        }

                        return xhrobj;
                    },

                    url : self.action,
                    type : 'POST',
                    contentType : false,
                    processData : false,
                    cache : false,
                    data : fd,

                    success : function(data) {
                        indicator.complete(data);
                    }
                })
                .always(function() {
                    self.current++;
                    self._upload();
                });

            } else {
                this.inProcess = false;
            }
        }
    };

    window.Uploader = Uploader;


    // Indicator Constructor
    function Indicator(name, size) {
        this._init(name, size);
    }

    // Indicator
    Indicator.prototype = {
        /**
         * Constructor
         *
         * @param string
         * @param int
         */
        _init : function(name, size) {
            name = html_entities(name);

            // Parent
            this.parent = $('<li class="material-light"></li>');
            // Progress bar
            this.progressContainer = $('<div class="upload-progress-container"></div>').appendTo(this.parent);
            this.progressBar = $('<div class="upload-progress-bar"></div>').appendTo(this.progressContainer);

            // Indicator wrapper
            this.messageWrapper = $('<div class="upload-message-wrapper"></div>').appendTo(this.parent);

            // Icon
            this.thumbnail = $('<span class="upload-thumbnail"></span>').appendTo(this.messageWrapper);
            // Container
            this.container = $('<p></p>').appendTo(this.messageWrapper);
            // File name
            this.filename = $('<span class="upload-text">' + name + '</span>').appendTo(this.container);
            // File size / Message
            this.message = $('<span class="upload-text muted">' + readable_size(size) + '</span>').appendTo(this.container);

            // Clone filename and message
            this.container.clone().appendTo(this.progressContainer);
        },
        /**
         * Set the progressbar width
         *
         * @param int
         */
        setProgress : function(percent) {
            this.progressBar.width(percent.toString() + "%");
        },
        /**
         * Takes action on the completed upload
         *
         * @param json
         */
        complete : function(reply) {
            this.setProgress(100);

            if(reply.type === 'success') {
                this._success(reply.response);
            } else if(reply.type === 'error') {
                this._error(reply);
            }
        },
        /**
         * Makes the UI changes when upload is completed
         *
         * @param json string
         */
        _success : function(data) {
            $(this.parent).addClass('complete');

            this.thumbnail.html(data.thumbnail);

            this.message.html(data.mimetype + ' | ' + this.message.text());
        },
        /**
         * Makes the UI changes when upload returns error
         *
         * @param json string
         */
        _error : function(data) {
            $(this.parent).addClass('error');

            $(this.thumbnail).html('<i class="icon-cancel"></i>');

            $(this.message).html(data.response);
        }
    };

    // Register indicator to the window namespace
    window.Indicator = Indicator;

}) ( window );

var Uploader = new Uploader($('#dropzone'));