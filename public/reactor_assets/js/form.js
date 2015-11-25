/*
 * jQuery MiniColors: A tiny color picker built on jQuery
 *
 * Copyright: Cory LaViska for A Beautiful Site, LLC: http://www.abeautifulsite.net/
 *
 * Contribute: https://github.com/claviska/jquery-minicolors
 *
 * @license: http://opensource.org/licenses/MIT
 *
 */
(function (factory) {
    /* jshint ignore:start */
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals
        factory(jQuery);
    }
    /* jshint ignore:end */
}(function ($) {

    // Defaults
    $.minicolors = {
        defaults: {
            animationSpeed: 50,
            animationEasing: 'swing',
            change: null,
            changeDelay: 0,
            control: 'hue',
            dataUris: true,
            defaultValue: '',
            format: 'hex',
            hide: null,
            hideSpeed: 100,
            inline: false,
            keywords: '',
            letterCase: 'lowercase',
            opacity: false,
            position: 'bottom left',
            show: null,
            showSpeed: 100,
            theme: 'default'
        }
    };

    // Public methods
    $.extend($.fn, {
        minicolors: function(method, data) {

            switch(method) {

                // Destroy the control
                case 'destroy':
                    $(this).each( function() {
                        destroy($(this));
                    });
                    return $(this);

                // Hide the color picker
                case 'hide':
                    hide();
                    return $(this);

                // Get/set opacity
                case 'opacity':
                    // Getter
                    if( data === undefined ) {
                        // Getter
                        return $(this).attr('data-opacity');
                    } else {
                        // Setter
                        $(this).each( function() {
                            updateFromInput($(this).attr('data-opacity', data));
                        });
                    }
                    return $(this);

                // Get an RGB(A) object based on the current color/opacity
                case 'rgbObject':
                    return rgbObject($(this), method === 'rgbaObject');

                // Get an RGB(A) string based on the current color/opacity
                case 'rgbString':
                case 'rgbaString':
                    return rgbString($(this), method === 'rgbaString');

                // Get/set settings on the fly
                case 'settings':
                    if( data === undefined ) {
                        return $(this).data('minicolors-settings');
                    } else {
                        // Setter
                        $(this).each( function() {
                            var settings = $(this).data('minicolors-settings') || {};
                            destroy($(this));
                            $(this).minicolors($.extend(true, settings, data));
                        });
                    }
                    return $(this);

                // Show the color picker
                case 'show':
                    show( $(this).eq(0) );
                    return $(this);

                // Get/set the hex color value
                case 'value':
                    if( data === undefined ) {
                        // Getter
                        return $(this).val();
                    } else {
                        // Setter
                        $(this).each( function() {
                            if( typeof(data) === 'object' ) {
                                if( data.opacity ) {
                                    $(this).attr('data-opacity', keepWithin(data.opacity, 0, 1));
                                }
                                if( data.color ) {
                                    $(this).val(data.color);
                                }
                            } else {
                                $(this).val(data);
                            }
                            updateFromInput($(this));
                        });
                    }
                    return $(this);

                // Initializes the control
                default:
                    if( method !== 'create' ) data = method;
                    $(this).each( function() {
                        init($(this), data);
                    });
                    return $(this);

            }

        }
    });

    // Initialize input elements
    function init(input, settings) {

        var minicolors = $('<div class="minicolors" />'),
            defaults = $.minicolors.defaults,
            format = input.attr('data-format'),
            keywords = input.attr('data-keywords'),
            opacity = input.attr('data-opacity');

        // Do nothing if already initialized
        if( input.data('minicolors-initialized') ) return;

        // Handle settings
        settings = $.extend(true, {}, defaults, settings);

        // The wrapper
        minicolors
            .addClass('minicolors-theme-' + settings.theme)
            .toggleClass('minicolors-with-opacity', settings.opacity)
            .toggleClass('minicolors-no-data-uris', settings.dataUris !== true);

        // Custom positioning
        if( settings.position !== undefined ) {
            $.each(settings.position.split(' '), function() {
                minicolors.addClass('minicolors-position-' + this);
            });
        }

        // Input size
        if( format === 'rgb' ) {
            $input_size = opacity ? '25' : '20';
        } else {
            $input_size = keywords ? '11' : '7';
        }

        // The input
        input
            .addClass('minicolors-input')
            .data('minicolors-initialized', false)
            .data('minicolors-settings', settings)
            .prop('size', $input_size)
            .wrap(minicolors)
            .after(
                '<div class="minicolors-panel minicolors-slider-' + settings.control + '">' +
                    '<div class="minicolors-slider minicolors-sprite">' +
                        '<div class="minicolors-picker"></div>' +
                    '</div>' +
                    '<div class="minicolors-opacity-slider minicolors-sprite">' +
                        '<div class="minicolors-picker"></div>' +
                    '</div>' +
                    '<div class="minicolors-grid minicolors-sprite">' +
                        '<div class="minicolors-grid-inner"></div>' +
                        '<div class="minicolors-picker"><div></div></div>' +
                    '</div>' +
                '</div>'
            );

        // The swatch
        if( !settings.inline ) {
            input.after('<span class="minicolors-swatch minicolors-sprite"><span class="minicolors-swatch-color"></span></span>');
            input.next('.minicolors-swatch').on('click', function(event) {
                event.preventDefault();
                input.focus();
            });
        }

        // Prevent text selection in IE
        input.parent().find('.minicolors-panel').on('selectstart', function() { return false; }).end();

        // Inline controls
        if( settings.inline ) input.parent().addClass('minicolors-inline');

        updateFromInput(input, false);

        input.data('minicolors-initialized', true);

    }

    // Returns the input back to its original state
    function destroy(input) {

        var minicolors = input.parent();

        // Revert the input element
        input
            .removeData('minicolors-initialized')
            .removeData('minicolors-settings')
            .removeProp('size')
            .removeClass('minicolors-input');

        // Remove the wrap and destroy whatever remains
        minicolors.before(input).remove();

    }

    // Shows the specified dropdown panel
    function show(input) {

        var minicolors = input.parent(),
            panel = minicolors.find('.minicolors-panel'),
            settings = input.data('minicolors-settings');

        // Do nothing if uninitialized, disabled, inline, or already open
        if( !input.data('minicolors-initialized') ||
            input.prop('disabled') ||
            minicolors.hasClass('minicolors-inline') ||
            minicolors.hasClass('minicolors-focus')
        ) return;

        hide();

        minicolors.addClass('minicolors-focus');
        panel
            .stop(true, true)
            .fadeIn(settings.showSpeed, function() {
                if( settings.show ) settings.show.call(input.get(0));
            });

    }

    // Hides all dropdown panels
    function hide() {

        $('.minicolors-focus').each( function() {

            var minicolors = $(this),
                input = minicolors.find('.minicolors-input'),
                panel = minicolors.find('.minicolors-panel'),
                settings = input.data('minicolors-settings');

            panel.fadeOut(settings.hideSpeed, function() {
                if( settings.hide ) settings.hide.call(input.get(0));
                minicolors.removeClass('minicolors-focus');
            });

        });
    }

    // Moves the selected picker
    function move(target, event, animate) {

        var input = target.parents('.minicolors').find('.minicolors-input'),
            settings = input.data('minicolors-settings'),
            picker = target.find('[class$=-picker]'),
            offsetX = target.offset().left,
            offsetY = target.offset().top,
            x = Math.round(event.pageX - offsetX),
            y = Math.round(event.pageY - offsetY),
            duration = animate ? settings.animationSpeed : 0,
            wx, wy, r, phi;

        // Touch support
        if( event.originalEvent.changedTouches ) {
            x = event.originalEvent.changedTouches[0].pageX - offsetX;
            y = event.originalEvent.changedTouches[0].pageY - offsetY;
        }

        // Constrain picker to its container
        if( x < 0 ) x = 0;
        if( y < 0 ) y = 0;
        if( x > target.width() ) x = target.width();
        if( y > target.height() ) y = target.height();

        // Constrain color wheel values to the wheel
        if( target.parent().is('.minicolors-slider-wheel') && picker.parent().is('.minicolors-grid') ) {
            wx = 75 - x;
            wy = 75 - y;
            r = Math.sqrt(wx * wx + wy * wy);
            phi = Math.atan2(wy, wx);
            if( phi < 0 ) phi += Math.PI * 2;
            if( r > 75 ) {
                r = 75;
                x = 75 - (75 * Math.cos(phi));
                y = 75 - (75 * Math.sin(phi));
            }
            x = Math.round(x);
            y = Math.round(y);
        }

        // Move the picker
        if( target.is('.minicolors-grid') ) {
            picker
                .stop(true)
                .animate({
                    top: y + 'px',
                    left: x + 'px'
                }, duration, settings.animationEasing, function() {
                    updateFromControl(input, target);
                });
        } else {
            picker
                .stop(true)
                .animate({
                    top: y + 'px'
                }, duration, settings.animationEasing, function() {
                    updateFromControl(input, target);
                });
        }

    }

    // Sets the input based on the color picker values
    function updateFromControl(input, target) {

        function getCoords(picker, container) {

            var left, top;
            if( !picker.length || !container ) return null;
            left = picker.offset().left;
            top = picker.offset().top;

            return {
                x: left - container.offset().left + (picker.outerWidth() / 2),
                y: top - container.offset().top + (picker.outerHeight() / 2)
            };

        }

        var hue, saturation, brightness, x, y, r, phi,

            hex = input.val(),
            format = input.attr('data-format'),
            keywords = input.attr('data-keywords'),
            opacity = input.attr('data-opacity'),

            // Helpful references
            minicolors = input.parent(),
            settings = input.data('minicolors-settings'),
            swatch = minicolors.find('.minicolors-swatch'),

            // Panel objects
            grid = minicolors.find('.minicolors-grid'),
            slider = minicolors.find('.minicolors-slider'),
            opacitySlider = minicolors.find('.minicolors-opacity-slider'),

            // Picker objects
            gridPicker = grid.find('[class$=-picker]'),
            sliderPicker = slider.find('[class$=-picker]'),
            opacityPicker = opacitySlider.find('[class$=-picker]'),

            // Picker positions
            gridPos = getCoords(gridPicker, grid),
            sliderPos = getCoords(sliderPicker, slider),
            opacityPos = getCoords(opacityPicker, opacitySlider);

        // Handle colors
        if( target.is('.minicolors-grid, .minicolors-slider, .minicolors-opacity-slider') ) {

            // Determine HSB values
            switch(settings.control) {

                case 'wheel':
                    // Calculate hue, saturation, and brightness
                    x = (grid.width() / 2) - gridPos.x;
                    y = (grid.height() / 2) - gridPos.y;
                    r = Math.sqrt(x * x + y * y);
                    phi = Math.atan2(y, x);
                    if( phi < 0 ) phi += Math.PI * 2;
                    if( r > 75 ) {
                        r = 75;
                        gridPos.x = 69 - (75 * Math.cos(phi));
                        gridPos.y = 69 - (75 * Math.sin(phi));
                    }
                    saturation = keepWithin(r / 0.75, 0, 100);
                    hue = keepWithin(phi * 180 / Math.PI, 0, 360);
                    brightness = keepWithin(100 - Math.floor(sliderPos.y * (100 / slider.height())), 0, 100);
                    hex = hsb2hex({
                        h: hue,
                        s: saturation,
                        b: brightness
                    });

                    // Update UI
                    slider.css('backgroundColor', hsb2hex({ h: hue, s: saturation, b: 100 }));
                    break;

                case 'saturation':
                    // Calculate hue, saturation, and brightness
                    hue = keepWithin(parseInt(gridPos.x * (360 / grid.width()), 10), 0, 360);
                    saturation = keepWithin(100 - Math.floor(sliderPos.y * (100 / slider.height())), 0, 100);
                    brightness = keepWithin(100 - Math.floor(gridPos.y * (100 / grid.height())), 0, 100);
                    hex = hsb2hex({
                        h: hue,
                        s: saturation,
                        b: brightness
                    });

                    // Update UI
                    slider.css('backgroundColor', hsb2hex({ h: hue, s: 100, b: brightness }));
                    minicolors.find('.minicolors-grid-inner').css('opacity', saturation / 100);
                    break;

                case 'brightness':
                    // Calculate hue, saturation, and brightness
                    hue = keepWithin(parseInt(gridPos.x * (360 / grid.width()), 10), 0, 360);
                    saturation = keepWithin(100 - Math.floor(gridPos.y * (100 / grid.height())), 0, 100);
                    brightness = keepWithin(100 - Math.floor(sliderPos.y * (100 / slider.height())), 0, 100);
                    hex = hsb2hex({
                        h: hue,
                        s: saturation,
                        b: brightness
                    });

                    // Update UI
                    slider.css('backgroundColor', hsb2hex({ h: hue, s: saturation, b: 100 }));
                    minicolors.find('.minicolors-grid-inner').css('opacity', 1 - (brightness / 100));
                    break;

                default:
                    // Calculate hue, saturation, and brightness
                    hue = keepWithin(360 - parseInt(sliderPos.y * (360 / slider.height()), 10), 0, 360);
                    saturation = keepWithin(Math.floor(gridPos.x * (100 / grid.width())), 0, 100);
                    brightness = keepWithin(100 - Math.floor(gridPos.y * (100 / grid.height())), 0, 100);
                    hex = hsb2hex({
                        h: hue,
                        s: saturation,
                        b: brightness
                    });

                    // Update UI
                    grid.css('backgroundColor', hsb2hex({ h: hue, s: 100, b: 100 }));
                    break;

            }

            // Handle opacity
            if( settings.opacity ) {
                opacity = parseFloat(1 - (opacityPos.y / opacitySlider.height())).toFixed(2);
            } else {
                opacity = 1;
            }
            if( settings.opacity ) input.attr('data-opacity', opacity);

            // Set color string
            if( format === 'rgb' ) {
                // Returns RGB(A) string
                var rgb = hex2rgb(hex),
                    opacity = input.attr('data-opacity') === '' ? 1 : keepWithin( parseFloat( input.attr('data-opacity') ).toFixed(2), 0, 1 );
                if( isNaN( opacity ) || !settings.opacity ) opacity = 1;

                if( input.minicolors('rgbObject').a <= 1 && rgb && settings.opacity) {
                    // Set RGBA string if alpha
                    value = 'rgba(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', ' + parseFloat( opacity ) + ')';
                } else {
                    // Set RGB string (alpha = 1)
                    value = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ')';
                }
            } else {
                // Returns hex color
                value = convertCase( hex, settings.letterCase );
            }

            // Update value from picker
            input.val( value );
        }

        // Set swatch color
        swatch.find('span').css({
            backgroundColor: hex,
            opacity: opacity
        });

        // Handle change event
        doChange(input, value, opacity);

    }

    // Sets the color picker values from the input
    function updateFromInput(input, preserveInputValue) {

        var hex,
            hsb,
            format = input.attr('data-format'),
            keywords = input.attr('data-keywords'),
            opacity,
            x, y, r, phi,

            // Helpful references
            minicolors = input.parent(),
            settings = input.data('minicolors-settings'),
            swatch = minicolors.find('.minicolors-swatch'),

            // Panel objects
            grid = minicolors.find('.minicolors-grid'),
            slider = minicolors.find('.minicolors-slider'),
            opacitySlider = minicolors.find('.minicolors-opacity-slider'),

            // Picker objects
            gridPicker = grid.find('[class$=-picker]'),
            sliderPicker = slider.find('[class$=-picker]'),
            opacityPicker = opacitySlider.find('[class$=-picker]');

        // Determine hex/HSB values
        if( isRgb(input.val()) ) {
            // If input value is a rgb(a) string, convert it to hex color and update opacity
            hex = rgbString2hex(input.val());
            alpha = keepWithin(parseFloat(getAlpha(input.val())).toFixed(2), 0, 1);
            if( alpha ) {
                input.attr('data-opacity', alpha);
            }
        } else {
            hex = convertCase(parseHex(input.val(), true), settings.letterCase);
        }

        if( !hex ){
            hex = convertCase(parseInput(settings.defaultValue, true), settings.letterCase);
        }
        hsb = hex2hsb(hex);

        // Get array of lowercase keywords
        keywords = !keywords ? [] : $.map(keywords.split(','), function(a) {
            return $.trim(a.toLowerCase());
        });

        // Set color string
        if( input.val() !== '' && $.inArray(input.val().toLowerCase(), keywords) > -1 ) {
            value = convertCase(input.val());
        } else {
            value = isRgb(input.val()) ? parseRgb(input.val()) : hex;
        }

        // Update input value
        if( !preserveInputValue ) input.val(value);

        // Determine opacity value
        if( settings.opacity ) {
            // Get from data-opacity attribute and keep within 0-1 range
            opacity = input.attr('data-opacity') === '' ? 1 : keepWithin(parseFloat(input.attr('data-opacity')).toFixed(2), 0, 1);
            if( isNaN(opacity) ) opacity = 1;
            input.attr('data-opacity', opacity);
            swatch.find('span').css('opacity', opacity);

            // Set opacity picker position
            y = keepWithin(opacitySlider.height() - (opacitySlider.height() * opacity), 0, opacitySlider.height());
            opacityPicker.css('top', y + 'px');
        }

        // Set opacity to zero if input value is transparent
        if( input.val().toLowerCase() === 'transparent' ) {
            swatch.find('span').css('opacity', 0);
        }

        // Update swatch
        swatch.find('span').css('backgroundColor', hex);

        // Determine picker locations
        switch(settings.control) {

            case 'wheel':
                // Set grid position
                r = keepWithin(Math.ceil(hsb.s * 0.75), 0, grid.height() / 2);
                phi = hsb.h * Math.PI / 180;
                x = keepWithin(75 - Math.cos(phi) * r, 0, grid.width());
                y = keepWithin(75 - Math.sin(phi) * r, 0, grid.height());
                gridPicker.css({
                    top: y + 'px',
                    left: x + 'px'
                });

                // Set slider position
                y = 150 - (hsb.b / (100 / grid.height()));
                if( hex === '' ) y = 0;
                sliderPicker.css('top', y + 'px');

                // Update panel color
                slider.css('backgroundColor', hsb2hex({ h: hsb.h, s: hsb.s, b: 100 }));
                break;

            case 'saturation':
                // Set grid position
                x = keepWithin((5 * hsb.h) / 12, 0, 150);
                y = keepWithin(grid.height() - Math.ceil(hsb.b / (100 / grid.height())), 0, grid.height());
                gridPicker.css({
                    top: y + 'px',
                    left: x + 'px'
                });

                // Set slider position
                y = keepWithin(slider.height() - (hsb.s * (slider.height() / 100)), 0, slider.height());
                sliderPicker.css('top', y + 'px');

                // Update UI
                slider.css('backgroundColor', hsb2hex({ h: hsb.h, s: 100, b: hsb.b }));
                minicolors.find('.minicolors-grid-inner').css('opacity', hsb.s / 100);
                break;

            case 'brightness':
                // Set grid position
                x = keepWithin((5 * hsb.h) / 12, 0, 150);
                y = keepWithin(grid.height() - Math.ceil(hsb.s / (100 / grid.height())), 0, grid.height());
                gridPicker.css({
                    top: y + 'px',
                    left: x + 'px'
                });

                // Set slider position
                y = keepWithin(slider.height() - (hsb.b * (slider.height() / 100)), 0, slider.height());
                sliderPicker.css('top', y + 'px');

                // Update UI
                slider.css('backgroundColor', hsb2hex({ h: hsb.h, s: hsb.s, b: 100 }));
                minicolors.find('.minicolors-grid-inner').css('opacity', 1 - (hsb.b / 100));
                break;

            default:
                // Set grid position
                x = keepWithin(Math.ceil(hsb.s / (100 / grid.width())), 0, grid.width());
                y = keepWithin(grid.height() - Math.ceil(hsb.b / (100 / grid.height())), 0, grid.height());
                gridPicker.css({
                    top: y + 'px',
                    left: x + 'px'
                });

                // Set slider position
                y = keepWithin(slider.height() - (hsb.h / (360 / slider.height())), 0, slider.height());
                sliderPicker.css('top', y + 'px');

                // Update panel color
                grid.css('backgroundColor', hsb2hex({ h: hsb.h, s: 100, b: 100 }));
                break;

        }

        // Fire change event, but only if minicolors is fully initialized
        if( input.data('minicolors-initialized') ) {
            doChange(input, value, opacity);
        }

    }

    // Runs the change and changeDelay callbacks
    function doChange(input, value, opacity) {

        var settings = input.data('minicolors-settings'),
            lastChange = input.data('minicolors-lastChange');

        // Only run if it actually changed
        if( !lastChange || lastChange.value !== value || lastChange.opacity !== opacity ) {

            // Remember last-changed value
            input.data('minicolors-lastChange', {
                value: value,
                opacity: opacity
            });

            // Fire change event
            if( settings.change ) {
                if( settings.changeDelay ) {
                    // Call after a delay
                    clearTimeout(input.data('minicolors-changeTimeout'));
                    input.data('minicolors-changeTimeout', setTimeout( function() {
                        settings.change.call(input.get(0), value, opacity);
                    }, settings.changeDelay));
                } else {
                    // Call immediately
                    settings.change.call(input.get(0), value, opacity);
                }
            }
            input.trigger('change').trigger('input');
        }

    }

    // Generates an RGB(A) object based on the input's value
    function rgbObject(input) {
        var hex = parseHex($(input).val(), true),
            rgb = hex2rgb(hex),
            opacity = $(input).attr('data-opacity');
        if( !rgb ) return null;
        if( opacity !== undefined ) $.extend(rgb, { a: parseFloat(opacity) });
        return rgb;
    }

    // Generates an RGB(A) string based on the input's value
    function rgbString(input, alpha) {
        var hex = parseHex($(input).val(), true),
            rgb = hex2rgb(hex),
            opacity = $(input).attr('data-opacity');
        if( !rgb ) return null;
        if( opacity === undefined ) opacity = 1;
        if( alpha ) {
            return 'rgba(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', ' + parseFloat(opacity) + ')';
        } else {
            return 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ')';
        }
    }

    // Converts to the letter case specified in settings
    function convertCase(string, letterCase) {
        return letterCase === 'uppercase' ? string.toUpperCase() : string.toLowerCase();
    }

    // Parses a string and returns a valid hex string when possible
    function parseHex(string, expand) {
        string = string.replace(/^#/g, '');
        if( !string.match(/^[A-F0-9]{3,6}/ig) ) return '';
        if( string.length !== 3 && string.length !== 6 ) return '';
        if( string.length === 3 && expand ) {
            string = string[0] + string[0] + string[1] + string[1] + string[2] + string[2];
        }
        return '#' + string;
    }

    // Parses a string and returns a valid RGB(A) string when possible
    function parseRgb(string, obj) {

        var values = string.replace(/[^\d,.]/g, ''),
            rgba = values.split(','),
            output;

        rgba[0] = keepWithin(parseInt(rgba[0], 10), 0, 255);
        rgba[1] = keepWithin(parseInt(rgba[1], 10), 0, 255);
        rgba[2] = keepWithin(parseInt(rgba[2], 10), 0, 255);
        if( rgba[3] ) {
            rgba[3] = keepWithin(parseFloat(rgba[3], 10), 0, 1);
        }

        // Return RGBA object
        if( obj ) {
            return {
                r: rgba[0],
                g: rgba[1],
                b: rgba[2],
                a: rgba[3] ? rgba[3] : null
            };
        }

        // Return RGBA string
        if( typeof(rgba[3]) !== 'undefined' && rgba[3] <= 1 ) {
            return 'rgba(' + rgba[0] + ', ' + rgba[1] + ', ' + rgba[2] + ', ' + rgba[3] + ')';
        } else {
            return 'rgb(' + rgba[0] + ', ' + rgba[1] + ', ' + rgba[2] + ')';
        }

    }

    // Parses a string and returns a valid color string when possible
    function parseInput(string, expand) {
        if( isRgb(string) ) {
            // Returns a valid rgb(a) string
            return parseRgb(string);
        } else {
            return parseHex(string, expand);
        }
    }

    // Keeps value within min and max
    function keepWithin(value, min, max) {
        if( value < min ) value = min;
        if( value > max ) value = max;
        return value;
    }

    // Checks if a string is a valid RGB(A) string
    function isRgb(string) {
        rgb = string.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
        return (rgb && rgb.length === 4) ? true : false;
    }

    // Function to get alpha from a RGB(A) string
    function getAlpha(rgba) {
        rgba = rgba.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+(\.\d{1,2})?|\.\d{1,2})[\s+]?/i);
        return (rgba && rgba.length === 6) ? rgba[4] : '1';
    }

   // Converts an HSB object to an RGB object
    function hsb2rgb(hsb) {
        var rgb = {};
        var h = Math.round(hsb.h);
        var s = Math.round(hsb.s * 255 / 100);
        var v = Math.round(hsb.b * 255 / 100);
        if(s === 0) {
            rgb.r = rgb.g = rgb.b = v;
        } else {
            var t1 = v;
            var t2 = (255 - s) * v / 255;
            var t3 = (t1 - t2) * (h % 60) / 60;
            if( h === 360 ) h = 0;
            if( h < 60 ) { rgb.r = t1; rgb.b = t2; rgb.g = t2 + t3; }
            else if( h < 120 ) {rgb.g = t1; rgb.b = t2; rgb.r = t1 - t3; }
            else if( h < 180 ) {rgb.g = t1; rgb.r = t2; rgb.b = t2 + t3; }
            else if( h < 240 ) {rgb.b = t1; rgb.r = t2; rgb.g = t1 - t3; }
            else if( h < 300 ) {rgb.b = t1; rgb.g = t2; rgb.r = t2 + t3; }
            else if( h < 360 ) {rgb.r = t1; rgb.g = t2; rgb.b = t1 - t3; }
            else { rgb.r = 0; rgb.g = 0; rgb.b = 0; }
        }
        return {
            r: Math.round(rgb.r),
            g: Math.round(rgb.g),
            b: Math.round(rgb.b)
        };
    }

    // Converts an RGB string to a hex string
    function rgbString2hex(rgb){
        rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
        return (rgb && rgb.length === 4) ? '#' +
        ('0' + parseInt(rgb[1],10).toString(16)).slice(-2) +
        ('0' + parseInt(rgb[2],10).toString(16)).slice(-2) +
        ('0' + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
    }

    // Converts an RGB object to a hex string
    function rgb2hex(rgb) {
        var hex = [
            rgb.r.toString(16),
            rgb.g.toString(16),
            rgb.b.toString(16)
        ];
        $.each(hex, function(nr, val) {
            if (val.length === 1) hex[nr] = '0' + val;
        });
        return '#' + hex.join('');
    }

    // Converts an HSB object to a hex string
    function hsb2hex(hsb) {
        return rgb2hex(hsb2rgb(hsb));
    }

    // Converts a hex string to an HSB object
    function hex2hsb(hex) {
        var hsb = rgb2hsb(hex2rgb(hex));
        if( hsb.s === 0 ) hsb.h = 360;
        return hsb;
    }

    // Converts an RGB object to an HSB object
    function rgb2hsb(rgb) {
        var hsb = { h: 0, s: 0, b: 0 };
        var min = Math.min(rgb.r, rgb.g, rgb.b);
        var max = Math.max(rgb.r, rgb.g, rgb.b);
        var delta = max - min;
        hsb.b = max;
        hsb.s = max !== 0 ? 255 * delta / max : 0;
        if( hsb.s !== 0 ) {
            if( rgb.r === max ) {
                hsb.h = (rgb.g - rgb.b) / delta;
            } else if( rgb.g === max ) {
                hsb.h = 2 + (rgb.b - rgb.r) / delta;
            } else {
                hsb.h = 4 + (rgb.r - rgb.g) / delta;
            }
        } else {
            hsb.h = -1;
        }
        hsb.h *= 60;
        if( hsb.h < 0 ) {
            hsb.h += 360;
        }
        hsb.s *= 100/255;
        hsb.b *= 100/255;
        return hsb;
    }

    // Converts a hex string to an RGB object
    function hex2rgb(hex) {
        hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
        return {
            /* jshint ignore:start */
            r: hex >> 16,
            g: (hex & 0x00FF00) >> 8,
            b: (hex & 0x0000FF)
            /* jshint ignore:end */
        };
    }

    // Handle events
    $(document)
        // Hide on clicks outside of the control
        .on('mousedown.minicolors touchstart.minicolors', function(event) {
            if( !$(event.target).parents().add(event.target).hasClass('minicolors') ) {
                hide();
            }
        })
        // Start moving
        .on('mousedown.minicolors touchstart.minicolors', '.minicolors-grid, .minicolors-slider, .minicolors-opacity-slider', function(event) {
            var target = $(this);
            event.preventDefault();
            $(document).data('minicolors-target', target);
            move(target, event, true);
        })
        // Move pickers
        .on('mousemove.minicolors touchmove.minicolors', function(event) {
            var target = $(document).data('minicolors-target');
            if( target ) move(target, event);
        })
        // Stop moving
        .on('mouseup.minicolors touchend.minicolors', function() {
            $(this).removeData('minicolors-target');
        })
        // Show panel when swatch is clicked
        .on('mousedown.minicolors touchstart.minicolors', '.minicolors-swatch', function(event) {
            var input = $(this).parent().find('.minicolors-input');
            event.preventDefault();
            show(input);
        })
        // Show on focus
        .on('focus.minicolors', '.minicolors-input', function() {
            var input = $(this);
            if( !input.data('minicolors-initialized') ) return;
            show(input);
        })
        // Update value on blur
        .on('blur.minicolors', '.minicolors-input', function() {
            var input = $(this),
                keywords = input.attr('data-keywords'),
                settings = input.data('minicolors-settings'),
                hex,
                rgba,
                swatchOpacity;

            if( !input.data('minicolors-initialized') ) return;

            // Get array of lowercase keywords
            keywords = !keywords ? [] : $.map(keywords.split(','), function(a) {
                return $.trim(a.toLowerCase());
            });

            // Set color string
            if( input.val() !== '' && $.inArray(input.val().toLowerCase(), keywords) > -1 ) {
                value = input.val();
            } else {
                // Get RGBA values for easy conversion
                if( isRgb(input.val()) ) {
                    rgba = parseRgb(input.val(), true);
                } else {
                    hex = parseHex(input.val(), true);
                    rgba = hex ? hex2rgb(hex) : null;
                }

                // Convert to format
                if( rgba === null ) {
                    value = settings.defaultValue;
                } else if( settings.format === 'rgb' ) {
                    value = settings.opacity ?
                        parseRgb('rgba(' + rgba.r + ',' + rgba.g + ',' + rgba.b + ',' + input.attr('data-opacity') + ')') :
                        parseRgb('rgb(' + rgba.r + ',' + rgba.g + ',' + rgba.b + ')');
                } else {
                    value = rgb2hex(rgba);
                }
            }

            // Update swatch opacity
            swatchOpacity = settings.opacity ? input.attr('data-opacity') : 1;
            if( value.toLowerCase() === 'transparent' ) swatchOpacity = 0;
            input
                .closest('.minicolors')
                .find('.minicolors-swatch > span')
                .css('opacity', swatchOpacity);

            // Set input value
            input.val(value);

            // Is it blank?
            if( input.val() === '' ) input.val(parseInput(settings.defaultValue, true));

            // Adjust case
            input.val( convertCase(input.val(), settings.letterCase) );

        })
        // Handle keypresses
        .on('keydown.minicolors', '.minicolors-input', function(event) {
            var input = $(this);
            if( !input.data('minicolors-initialized') ) return;
            switch(event.keyCode) {
                case 9: // tab
                    hide();
                    break;
                case 13: // enter
                case 27: // esc
                    hide();
                    input.blur();
                    break;
            }
        })
        // Update on keyup
        .on('keyup.minicolors', '.minicolors-input', function() {
            var input = $(this);
            if( !input.data('minicolors-initialized') ) return;
            updateFromInput(input, true);
        })
        // Update on paste
        .on('paste.minicolors', '.minicolors-input', function() {
            var input = $(this);
            if( !input.data('minicolors-initialized') ) return;
            setTimeout( function() {
                updateFromInput(input, true);
            }, 1);
        });

}));

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
;( function(window) {
    'use strict';

    // Constructor
    function Slug(el) {
        this.el = el;

        this._init();
    }

    // Slug prototype
    Slug.prototype = {
        // Initialize
        _init : function() {
            this.input = this.el.find('input[type="text"]');

            var follow = typeof this.input.data('follows') !== 'undefined' ?
                this.input.data('follows') :
                '#title';

            this.follow = $(follow);

            this.dirty = (this.input.val() !== '') ? true : false;

            this._initEvents();
        },
        _initEvents : function() {
            var self = this;

            this.input.on('keyup', function() {
                self.dirty = true;
            });

            this.follow.on('keyup', function() {
                if(!self.dirty) { self._setSlug(); }
            });

            this.input.on('blur', function() {
                if(self.input.val() === '') {
                    self.changed = false;
                    self._setSlug();
                }
            });
        },
        // Set slug
        _setSlug : function() {
            var slug = this._slugify(this.follow.val());

            this.input.val(slug);
        },
        _slugify : function(str) {
            str = str.replace(/^\s+|\s+$/g, '').toLowerCase();

            // Remove accents
            var from = "àáäâèéëêıìíïîòóöôùúüûñçğş·/_,:;", to = "aaaaeeeeiiiiioooouuuuncgs------";

            for(var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            return str.replace(/[^a-z0-9 -]/g, '') // Remove invalid chars
                .replace(/\s+/g, '-') // Collapse whitespace and replace by -
                .replace(/-+/g, '-'); // Collapse dashes
        }
    };

    window.Slug = Slug;

}) (window);
// Strict definitions
;(function (window) {
    'use strict';

    // Tag field constructor
    function Tag(el) {
        this.el = el;

        this._init();
    }

    // Tag prototype
    Tag.prototype = {
        // Initialize
        _init: function () {
            this.list = this.el.find('ul.taglist');
            this.inputItem = this.list.find('li.tag-input');
            this.input = this.inputItem.find('input[name="_tag"]');
            this.valueInput = this.el.find('input[type="hidden"]');

            this.tags = [];

            this._extractValue();

            this._initEvents();
        },
        // Initialize events
        _initEvents: function () {
            var self = this;

            this.input.bind('keydown', function (e) {
                var input = $(this);

                if (e.which === 27) {
                    e.stopPropagation();

                    if (input.val() === '') {
                        input.blur();
                    } else {
                        input.val('');
                    }

                } else if (e.which === 9 || e.which === 13 || e.which === 188) {
                    e.preventDefault();

                    var val = input.val().trim();

                    if (val !== '') {
                        if (self._addTag(input.val())) {
                            input.val('');
                        }
                    }
                }
            });

            // Remove buttons
            this.list.on('click', '.icon-cancel', function () {
                self._removeTag($(this));
            });
        },
        // Extracts the current value, generates the list
        _extractValue: function () {
            var values = this.valueInput.val().trim();

            if (values !== '') {
                values = values.split(',');

                for (var i = 0; i < values.length; i++) {
                    this._addTag(values[i]);
                }
            }

            this._setListClass(this.tags);
        },
        // Removes an item
        _removeTag: function (tag) {
            var parent = tag.parents('.tag');

            delete this.tags[parent.data('id')];

            parent.remove();

            this._setValue();
        },
        // Adds an item
        _addTag: function (str) {
            var i = this.tags.indexOf(str);

            if (i > -1) {
                var duplicate = this.list.find('li[data-id="' + i + '"]');

                duplicate.addClass('flash');

                setTimeout(function () {
                    duplicate.removeClass('flash');
                }, 100);

                return false;
            } else {
                this.tags.push(str);

                i = this.tags.indexOf(str);

                this._createTag(i, str);

                this._setValue();

                return true;
            }
        },
        // Creates a tag and appends to list
        _createTag: function (id, str) {
            $('<li class="tag" data-id="' + id + '">' + html_entities(str) + '<i class="icon-cancel"></i></li>').insertBefore(this.inputItem);
        },
        // Sets the value input
        _setValue: function () {
            var clean = $.grep(this.tags, function (n) {
                return (n);
            });

            this.valueInput.val(clean.join(','));

            this._setListClass(clean);
        },
        // Sets the list class
        _setListClass: function (tags) {
            if (tags.length === 0) {
                this.list.addClass('empty');
            } else {
                this.list.removeClass('empty');
            }
        }
    };

    // Register to window namespace
    window.Tag = Tag;

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

// Slug fields
$('.form-group-slug').each(function () {
    new Slug($(this));
});

// Slug fields
$('.form-group-tag').each(function () {
    new Tag($(this));
});

// Initialize color pickers
$('input.minicolors').minicolors();
//# sourceMappingURL=form.js.map