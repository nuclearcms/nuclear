;
(function (window) {
    'use strict';

    /**
     * ImageEditor constructor
     */
    function ImageEditor(el) {
        this.el = el;

        this.image = this.el.find('.image-editable');
        this.cropFrame = this.el.find('document-crop-frame');

        this._init();
    }

    // ImageEditor prototype
    ImageEditor.prototype = {
        // Initializes meter
        _init: function () {
            this.el.bind('click', function (e) {
                var posX = $(this).offset().left, posY = $(this).offset().top;
                alert((e.pageX - posX) + ' , ' + (e.pageY - posY));
            });
        }
    };

    // Register meter to window namespace
    window.ImageEditor = ImageEditor;

})(window);

var imageEditor = new ImageEditor($('.document-edit-image'));