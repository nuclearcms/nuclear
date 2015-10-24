;
(function (window) {
    'use strict';

    /**
     * ImageEditor constructor
     */
    function ImageEditor(el) {
        this.el = el;

        this.image = this.el.find('img.image-editable');
        this.form = this.el.find('form');
        this.actionInput = this.form.find('input[name="action"]');

        this._init();
    }

    // ImageEditor prototype
    ImageEditor.prototype = {
        // Initializes editor
        _init: function () {
            this.cropButton = $('#crop');
            this.rotateLeftButton = $('#rotate-left');
            this.rotateRightButton = $('#rotate-right');
            this.flipHorizontalButton = $('#flip-horizontal');
            this.flipVerticalButton = $('#flip-vertical');

            this._initEvents();
        },
        // Initializes events
        _initEvents: function () {
            var self = this;

            this.rotateLeftButton.bind('click', function () {
                self._rotateLeft();
            });

            this.rotateRightButton.bind('click', function () {
                self._rotateRight();
            });

            this.flipHorizontalButton.bind('click', function () {
                self._flipHorizontal();
            });

            this.flipVerticalButton.bind('click', function () {
                self._flipVertical();
            });

            this._initCropper();
        },
        // Initializes cropper
        _initCropper: function () {
            var self = this;

            this._cropEnabled = false;

            this.image.cropper({
                movable: false,
                zoomable: false,
                rotatable: false,
                scalable: false,
                autoCrop: false
            });

            this.image.on('cropend.cropper', function () {
                self.cropButton.removeClass('disabled');
                self._cropEnabled = true;
            });

            this.cropButton.bind('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                if (self._cropEnabled) {
                    self._crop();
                }
            });
        },
        //
        _crop: function () {
            var data = this.image.cropper('getData');

            this.actionInput.val('crop_' +
                Math.floor(data.width) + ',' +
                Math.floor(data.height) + ',' +
                Math.floor(data.x) + ',' +
                Math.floor(data.y)
            );

            this._submit();
        },
        _rotateLeft: function () {
            this.actionInput.val('rotate_90');
            this._submit();
        },
        _rotateRight: function () {
            this.actionInput.val('rotate_270');
            this._submit();
        },
        _flipHorizontal: function () {
            this.actionInput.val('flip_h');
            this._submit();
        },
        _flipVertical: function () {
            this.actionInput.val('flip_v');
            this._submit();
        },
        _submit: function()
        {
            this.form.submit();
        }
    };

    // Register meter to window namespace
    window.ImageEditor = ImageEditor;

})(window);

$(function () {
    return new ImageEditor($('.document-edit-container'));
});