;
(function (window) {
    'use strict';

    /**
     * ImageEditor constructor
     */
    function ImageEditor(el) {
        this.el = el;

        this.image = this.el.find('img.image-editor__image');
        this.form = this.el.find('form');
        this.actionInput = this.form.find('input[name="action"]');

        this._init();
    }

    // ImageEditor prototype
    ImageEditor.prototype = {
        // Initializes editor
        _init: function () {
            this.cropButton = $('#toolCrop');
            this.rotateCCWButton = $('#toolRotateCCW');
            this.rotateCWButton = $('#toolRotateCW');
            this.flipHorizontalButton = $('#toolFlipHorizontal');
            this.flipVerticalButton = $('#toolFlipVertical');
            this.grayscaleButton = $('#toolGrayscale');
            this.sharpenButton = $('#toolSharpen');
            this.blurButton = $('#toolBlur');

            this._initEvents();
        },
        // Initializes events
        _initEvents: function () {
            var self = this;

            this.rotateCCWButton.bind('click', function () {
                self.actionInput.val('rotate_90');
                self._submit();
            });

            this.rotateCWButton.bind('click', function () {
                self.actionInput.val('rotate_270');
                self._submit();
            });

            this.flipHorizontalButton.bind('click', function () {
                self.actionInput.val('flip_h');
                self._submit();
            });

            this.flipVerticalButton.bind('click', function () {
                self.actionInput.val('flip_v');
                self._submit();
            });

            this.grayscaleButton.bind('click', function () {
                self.actionInput.val('greyscale');
                self._submit();
            });

            this.sharpenButton.bind('click', function () {
                self.actionInput.val('sharpen_10');
                self._submit();
            });

            this.blurButton.bind('click', function () {
                self.actionInput.val('blur_10');
                self._submit();
            });

            this._initCropper();
        },
        _submit: function()
        {
            this.form.submit();
        },
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
                self.cropButton.removeClass('button--disabled-plain');
                self._cropEnabled = true;
            });

            this.cropButton.on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                if (self._cropEnabled) {
                    self._crop();
                }
            });
        },
        _crop: function () {
            var data = this.image.cropper('getData');

            this.actionInput.val('crop_' +
                Math.floor(data.width) + ',' +
                Math.floor(data.height) + ',' +
                Math.max(Math.floor(data.x), 0) + ',' +
                Math.max(Math.floor(data.y), 0)
            );

            this._submit();
        }
    };

    // Register image editor to window namespace
    window.ImageEditor = ImageEditor;

})(window);

$(function () {
    return new ImageEditor($('#imageEditor'));
});