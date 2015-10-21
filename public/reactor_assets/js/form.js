;( function(window) {
    'use strict';

    /**
     * Meter constructor
     *
     * @param DOM Object el
     * @param string field
     */
    function Meter(el, field, meter) {
        this.el = el;

        field = field || 'input[type="password"]';
        meter = meter || '.strength-meter > div';

        this.field = this.el.find(field);
        this.meter = this.el.find(meter);
        this._init();
    }

    // Meter prototype
    Meter.prototype = {
        // Initializes meter
        _init : function() {
            this.characters = 0;
            this.capitalletters = 0;
            this.lowerletters = 0;
            this.number = 0;
            this.special = 0;

            this.upperCase = new RegExp('[A-Z]');
            this.lowerCase = new RegExp('[a-z]');
            this.numbers = new RegExp('[0-9]');
            this.specialchars = new RegExp('([!,%,&,@,#,$,^,*,?,_,~,/])');

            var self = this;

            this.field.on('keyup keydown', function() {
                self._checkStrength($(this).val());
            });
        },
        // Sets meter percentage
        _setPercentage : function(percentage) {
            this.meter.css({ 'width' : percentage + '%' });
        },
        // Sets meter class
        _setClass : function(total) {
            if(total <= 1) {
                this.meter.removeClass();
                this.meter.addClass('veryweak');
            } else if(total === 2) {
                this.meter.removeClass();
                this.meter.addClass('weak');
            } else if(total === 3) {
                this.meter.removeClass();
                this.meter.addClass('medium');
            } else {
                this.meter.removeClass();
                this.meter.addClass('strong');
            }
        },
        // Checks strength
        _checkStrength : function(value) {
            if (value.length >= 8) { this.characters = 1; } else { this.characters = 0; }
            if (value.match(this.upperCase)) { this.capitalletters = 1; } else { this.capitalletters = 0; }
            if (value.match(this.lowerCase)) { this.lowerletters = 1; }  else { this.lowerletters = 0; }
            if (value.match(this.numbers)) { this.number = 1; }  else { this.number = 0; }
            if (value.match(this.specialchars)) { this.special = 1; }  else { this.special = 0; }


            var total = this._getTotal();
            var percentage = this._getPercentage(5, total);

            this._setPercentage(percentage);

            this._setClass(total);
        },
        // Percentage helper
        _getPercentage : function(a, b) {
            return ((b / a) * 100);
        },
        // Gets total
        _getTotal : function() {
            return this.characters + this.capitalletters + this.lowerletters + this.number + this.special;
        }
    };

    // Register meter to window namespace
    window.Meter = Meter;

})(window);
// General highlighters
$('.form-group input, .form-group textarea').focus(function () {
    $(this).closest('.form-group').addClass('focus');
});

$('.form-group input, .form-group textarea').blur(function () {
    $(this).closest('.form-group').removeClass('focus');
});

// Password strength meter
$('.form-group-password').each(function () {
    new Meter($(this));
});
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
        _init : function(self, options, app, external) {
            this.zone = self;

            var defaults = {
                selectButton : '#dropzone-select-button',
                uploadInput : '#dropzone-file',
                outputList: '#upload-list',
                enabled: true
            };

            this.options = $.extend(defaults, options);
            this.token = this.zone.find("input[name='_token']").first().val();
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

                    beforeSend: function(request) {
                        return request.setRequestHeader('X-CSRF-Token', self.token);
                    },

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
//# sourceMappingURL=form.js.map