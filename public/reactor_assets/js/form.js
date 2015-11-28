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
;(function (window) {
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
        _init: function (self, options) {
            this.zone = self;

            var defaults = {
                selectButton: '#dropzone-select-button',
                uploadInput: '#dropzone-file',
                outputList: '#upload-list',
                indicator: null,
                enabled: true,
                append: true
            };

            this.options = $.extend(defaults, options);
            this.action = $(this.zone).attr('action');

            this.fileQueue = [];
            this.statusIndicators = [];
            this.current = 0;
            this.inProcess = false;

            this.maxsize = this.zone.data('maxsize');

            this._initEvents();
        },
        /**
         * Binds events
         */
        _initEvents: function () {
            var self = this;

            // Class binds
            this.zone.bind("dragenter, dragover", function (e) {
                e.preventDefault();
                e.stopPropagation();

                $(this).addClass('dragenter');
            });

            this.zone.bind("dragleave", function () {
                $(this).removeClass('dragenter');
            });

            // Disable window drop
            $(window).bind('drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
            });

            // Bind file drop
            this.zone.bind("drop", function (e) {
                e.preventDefault();
                e.stopPropagation();

                self.queue(e.originalEvent.dataTransfer.files);

                $(this).removeClass('dragenter');
            });

            // Bind input change
            $(this.options.uploadInput).bind("change", function () {
                self.queue($(this)[0].files);
            });

            // Bind optional select button if exists
            if (this.options.selectButton !== false) {
                $(this.options.selectButton).bind("click", function (e) {
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
        queue: function (files) {
            if (!this.options.enabled) {
                return false;
            }

            for (var i = 0; i < files.length; i++) {
                if (files[i].size < this.maxsize) {

                    var fd = new FormData();
                    fd.append('file', files[i]);

                    this.fileQueue.push(fd);

                    // Escape the file name in order to prevent XSS
                    var indicator = this._createIndicator(html_entities(files[i].name), files[i].size);

                    this.statusIndicators.push(indicator);

                    if (this.options.outputList !== false) {
                        if (this.options.append === true) {
                            $(this.options.outputList).append(indicator.parent);
                        } else {
                            $(this.options.outputList).prepend(indicator.parent);
                        }

                    }
                }
            }

            if (this.inProcess === false) {
                this._upload();
            }
        },
        /**
         * Creates an upload indicator
         */
        _createIndicator: function(name, size)
        {
            var className = (!this.options.indicator) ? 'Indicator' : this.options.indicator;

            className = window[className];

            return new className(name, size);
        },
        /**
         * Iterates through queue and uploads files
         */
        _upload: function () {
            var self = this;

            if (this.current < this.fileQueue.length) {
                this.inProcess = true;

                var fd = this.fileQueue[this.current],
                    indicator = this.statusIndicators[this.current];

                $.ajax({
                        xhr: function () {
                            var xhrobj = $.ajaxSettings.xhr();

                            if (xhrobj.upload) {
                                xhrobj.upload.addEventListener('progress', function (e) {
                                    indicator.setProgress(loaded(e));
                                });
                            }

                            return xhrobj;
                        },

                        url: self.action,
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        cache: false,
                        data: fd,

                        success: function (data) {
                            indicator.complete(data);
                        }
                    })
                    .always(function () {
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
        _init: function (name, size) {
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
        setProgress: function (percent) {
            this.progressBar.width(percent.toString() + "%");
        },
        /**
         * Takes action on the completed upload
         *
         * @param json
         */
        complete: function (reply) {
            this.setProgress(100);

            if (reply.type === 'success') {
                this._success(reply.response);
            } else if (reply.type === 'error') {
                this._error(reply);
            }
        },
        /**
         * Makes the UI changes when upload is completed
         *
         * @param json string
         */
        _success: function (data) {
            $(this.parent).addClass('complete');

            this.thumbnail.html(data.thumbnail);

            this.message.html(data.mimetype + ' | ' + this.message.text());
        },
        /**
         * Makes the UI changes when upload returns error
         *
         * @param json string
         */
        _error: function (data) {
            $(this.parent).addClass('error');

            $(this.thumbnail).html('<i class="icon-cancel"></i>');

            $(this.message).html(data.response);
        }
    };

    // Register indicator to the window namespace
    window.Indicator = Indicator;

})(window);
;(function (window) {
    'use strict';

    /**
     * Library constructor
     *
     * @param DOM Object
     */
    function Library(el) {
        this.container = el;

        this._init();
    }

    // Prototype
    Library.prototype = {
        // Initialize
        _init: function () {
            this.retrieveURL = this.container.data('retrieveurl');

            this.modal = this.container.find('#library-modal');
            this.scroller = this.modal.find('#library-modal-columns');
            this.mediaList = $('#library-modal-media-list');

            this.searchForm = this.modal.find('#library-modal-search');
            this.noResults = this.modal.find('#library-modal-noresults');
            this.disabler = this.modal.find('#library-modal-disabler');

            this.mediaDetails = this.modal.find('#library-modal-media-detail');
            this.gallerySortable = this.modal.find('#library-modal-gallery-sortable');
            this.numSelected = this.modal.find('#library-modal-gallery-selected > span');

            this.clearButton = this.modal.find('#library-modal-clear');
            this.removeButton = this.modal.find('#library-modal-remove');
            this.insertButton = this.modal.find('#library-modal-insert');
            this.closeButton = this.modal.find('#library-modal-close');

            this.dropzone = this.container.find('#library-modal-dropzone');

            this.controller = null;
            this.isOpen = false;
            this.isRetrieved = false;
            this.mode = null;
            this.masterFilter = null;
            this.lastValue = null;
            this.uploadIndicators = [];
            this.controllerDirty = false;

            // Create dialog
            this.dialog = new Modal($('#library-modal-container'));

            // Create uploader
            this.uploader = new Uploader($('#library-modal-dropzone'), {
                outputList: this.mediaList,
                enabled: false,
                append: false,
                indicator: 'LibraryIndicator'
            });

            this._disableList();

            this._initEvents();
        },
        // Initialize events
        _initEvents: function () {
            // Cache self
            var self = this;

            // Scrollers
            this.scroller.find('.library-modal-scroll-button').on('click', function () {
                // Check direction
                if ($(this).hasClass('right')) {
                    self.scroller.addClass('scrolled');
                } else if ($(this).hasClass('left')) {
                    self.scroller.removeClass('scrolled');
                }
            });

            // Stop propagation for the library-modal
            this.modal.on('click', function (e) {
                e.stopPropagation();
            });

            // Clear button
            this.clearButton.on('click', function (e) {
                self._clearGallery();

                e.preventDefault();
                e.stopPropagation();
            });

            // Remove button
            this.removeButton.on('click', function () {
                self._deselectDocument();

                self.controller.setValue(null);

                self.close();
            });

            // Search
            this.searchForm.on('submit', function (e) {
                e.preventDefault();
                e.stopPropagation();

                if (!$(this).hasClass('disabled')) {
                    var search = $(this).find('input[name="q"]');

                    var keywords = search.val();

                    self._search(keywords);
                }
            });

            // Search input keypress
            this.searchForm.find('input[type="search"]').bind('keydown', function (e) {
                if (e.keyCode === 27) {
                    e.stopPropagation();
                    if ($(this).val() === '') {
                        $(this).blur();
                    } else {
                        self._search('');
                    }
                }
            });

            // Sortable
            this.gallerySortable.sortable({
                cursor: 'move',
                tolerance: 'pointer',
                placeholder: 'placeholder',
                opacity: 0.7,
                delay: 50,
                scroll: false
            }).disableSelection();

            // Sortable remove
            this.gallerySortable.on('click', '.library-modal-sortable-remove', function (e) {
                var parent = $(this).parent();

                self._deselectGallery($('#md_' + parent.data('id')));

                parent.remove();

                e.preventDefault();
                e.stopPropagation();
            });

            // Dragenter, dragover
            this.container.on("dragenter, dragover", function (e) {
                e.preventDefault();
                e.stopPropagation();

                self.dropzone.addClass('dragenter');
            });

            // Dragleave
            this.dropzone.on("dragleave", function () {
                $(this).removeClass('dragenter');
            });

            // Call upload handler
            this.dropzone.on("drop", function (e) {
                e.preventDefault();

                $(this).removeClass('dragenter');
            });

            // Close button
            this.closeButton.on("click", function () {
                self.close();
            });
        },
        // Initialize
        run: function (controller) {
            if (!this.isRetrieved) {
                // We do not store controller here since we don't want
                // conflicts when this mode runs again after retrieval
                this._setMode(controller.type);

                this._reset();

                this._retrieve(controller);
            } else {
                if (this.controller !== controller) {
                    this.controller = controller;

                    this._setMode(controller.type);

                    this.controllerDirty = true;

                    this._reset();
                }

                this._initByMode();
            }

            this.open();
        },
        // Displays by controller value/options
        _initByMode: function () {
            if (this.mode === 'gallery') {
                this._initGallery();
            } else {
                this._initDocument();
            }
        },
        // Init gallery
        _initGallery: function () {
            // Do this bit if the controller is not the same
            if (this.controllerDirty === true) {
                var self = this;

                this._setMasterFilter('image');

                this.mediaList.unbind('click').on('click', 'li', function () {
                    self._selectForGallery($(this));
                });

                this.insertButton.unbind('click').on('click', function () {
                    self.controller.setValue(self._parseForGallery());

                    self.close();
                });

                this.controllerDirty = false;
            }

            var mediaIds = this.controller.getValue();

            // If the last value has changed reinit
            if (this.isRetrieved && this.lastValue !== mediaIds) {
                this.lastValue = mediaIds;

                this._clearGallery();

                // Take action if not empty
                if (mediaIds !== '' && mediaIds.length > 0) {
                    mediaIds = JSON.parse(mediaIds);

                    for (var i = mediaIds.length - 1; i >= 0; i--) {
                        var media = $('#md_' + mediaIds[i]);

                        if (media.length > 0) {
                            this._selectGallery(media);
                        }
                    }
                }

                this._recalculateSelected();
            }
        },
        // Init document
        _initDocument: function () {
            // Do this bit if the controller is not the same
            if (this.controllerDirty === true) {
                var self = this;

                if (typeof this.controller.filter !== 'undefined') {
                    this._setMasterFilter(this.controller.filter);
                }

                this.mediaList.unbind('click').on('click', 'li', function () {
                    self._selectForDocument($(this));
                });

                this.insertButton.unbind('click').on('click', function () {
                    self.controller.setValue(self._parseForDocument());

                    self.close();
                });

                this.controllerDirty = false;
            }

            var mediaId = this.controller.getValue();

            // If the last value has changed reinit
            if (this.isRetrieved && this.lastValue !== mediaId) {
                this.lastValue = mediaId;

                var media = $('#md_' + mediaId);

                if (media.length > 0) {
                    this._selectDocument(media);
                } else {
                    this._deselectDocument();
                }
            }
        },
        // Selects media depending on the mode
        selectMediaById: function (id) {
            var media = $('#md_' + id);

            if (media.length > 0) {
                // Select depending on mode
                if (this.mode === 'gallery') {
                    this._selectForGallery(media);
                } else {
                    this._selectForDocument(media);
                }
            }
        },
        // Select media
        _selectForDocument: function (media) {
            // Return if it has indicator
            if (media.hasClass('indicator')) {
                return false;
            }

            // Take action depending on the selected condition
            if (media.hasClass('selected')) {
                this._deselectDocument();
            } else {
                this._selectDocument(media);
            }
        },
        // Selects document
        _selectDocument: function (media) {
            this.mediaList.children('li.selected').removeClass('selected');
            media.addClass('selected');
            this.mediaDetails.addClass('selected');

            this.mediaDetails.data('id', media.data('id'));

            var tag = this.mediaDetails.children('.library-modal-media-tag'),
                name = tag.find('.media-name'),
                detail = tag.find('.media-detail'),
                thumbnail = tag.find('.media-thumbnail');

            name.text(media.data('name'));

            if (isNaN(media.data('size')) || media.data('size') == '0') {
                var details = media.data('mimetype');
            } else {
                var details = media.data('mimetype') + ' | ' + readable_size(media.data('size'));
            }

            detail.text(details);

            thumbnail.html(media.find('.document-thumbnail').clone());
        },
        // Deselects document
        _deselectDocument: function () {
            this.mediaList.children('li.selected').removeClass('selected');
            this.mediaDetails.removeClass('selected');

            this.mediaDetails.data('id', '');
        },
        // Select media for gallery
        _selectForGallery: function (media) {
            if (media.hasClass('indicator') || media.hasClass('filtered')) {
                return false;
            }

            if (media.hasClass('selected')) {
                this._deselectGallery(media);
            } else {
                this._selectGallery(media);
            }

            this._recalculateSelected();
        },
        // Selects media for gallery
        _selectGallery: function (media) {
            media.addClass('selected');

            var thumbnail = $('<li data-id="' + media.data('id') + '" id="gl_' + media.data('id') + '"></li>');

            $('<img src="' + media.find('img').attr('src') + '">').appendTo(thumbnail);

            $('<i class="icon-cancel library-modal-sortable-remove"></i>').appendTo(thumbnail);

            this.gallerySortable.prepend(thumbnail);
        },
        // Deselects media for gallery
        _deselectGallery: function (media) {
            media.removeClass('selected');

            this.gallerySortable.find('#gl_' + media.data('id')).remove();

            this._recalculateSelected();
        },
        _clearGallery: function () {
            this.mediaList.children('li.selected').removeClass('selected');

            this.gallerySortable.empty();

            this.numSelected.text(0);
        },
        // Recalculates the number of selected media
        _recalculateSelected: function () {
            var selected = this.gallerySortable.children('li').length;

            this.numSelected.text(selected);
        },
        // Parse media
        _parseMedia: function (id) {
            var media = $('#md_' + id);

            if (media.length > 0) {
                return {
                    'id': id,
                    'name': media.data('name'),
                    'thumbnail': media.find('.document-thumbnail').children('img,i').clone()
                };
            } else {
                return null;
            }
        },
        // Parse for document
        _parseForDocument: function () {
            var id = this.mediaDetails.data('id');

            return this._parseMedia(id);
        },
        // Parse for gallery
        _parseForGallery: function () {
            var array = [];

            var gallery = this.gallerySortable.children('li');

            for (var i = 0; i < gallery.length; i++) {
                var id = gallery.eq(i).data('id');
                // Push into array
                array.push(this._parseMedia(id));
            }

            return array;
        },
        // Open
        open: function () {
            this.dialog.openModal();
        },
        // Open
        close: function () {
            this.dialog.closeModal();
        },
        _setMode: function (mode) {
            this.mode = mode;

            this.container.removeClass('library-modal-mode-gallery library-modal-mode-document');

            this.container.addClass('library-modal-mode-' + mode);
        },
        // Sets the master filter
        _setMasterFilter: function (key) {
            this.masterFilter = key;

            this._filter(key);
        },
        // Refilter (useful when new uploaded files arrive)
        refilter: function () {
            this._filter(
                this.masterFilter
            );
        },
        // Resets library modal
        _reset: function () {
            this.masterFilter = null;

            this._deselectDocument();

            this._clearGallery();

            this.mediaList.children('li').removeClass();
        },
        // Retrieves the media
        _retrieve: function (controller) {
            var self = this;

            $.getJSON(this.retrieveURL, function (data) {
                self._populateList(data);

                self.isRetrieved = true;

                self._enableList();

                self._enableUploader();

                self.run(controller);
            });
        },
        // Populates the media list
        _populateList: function (data) {
            for (var i = 0; i < data.length; i++) {
                var media = data[i];

                this.mediaList.prepend(this.createMediaThumbnail(media));
            }
        },
        createMediaThumbnail: function (media) {
            var thumbnail = $('<li data-id="' + media.id + '" ' +
                'id="md_' + media.id + '" data-name="' + html_entities(media.name) + '" ' +
                'data-flag="' + media.type + '" data-size="' + media.size + '" ' +
                'data-mimetype="' + media.mimetype + '">');

            $('<div class="document-thumbnail">' + media.thumbnail + '</div>').appendTo(thumbnail);

            $('<p>' + html_entities(media.name) + '</p>').appendTo(thumbnail);

            $('<i class="icon-check"></i>').appendTo(thumbnail);

            return thumbnail;
        },
        // Enables list
        _enableList: function () {
            this.disabler.removeClass('active');

            this.searchForm.removeClass('disabled');
        },
        // Disable list
        _disableList: function () {
            this.disabler.addClass('active');

            this.searchForm.addClass('disabled');
        },
        // Filter items by key
        _filter: function (key) {
            if (!key || key === 'all') {
                this.mediaList.children('li').removeClass('filtered');
            } else {
                this.mediaList.children('li').addClass('filtered');
                this.mediaList.children('li[data-flag="' + key + '"]').removeClass('filtered');
            }

            this._anyResults();
        },
        // Makes a search
        _search: function (keywords) {
            if (keywords.trim() === "") {
                this.mediaList.children('li').removeClass('searched');

                this._anyResults();
            } else {
                var self = this;

                this._yesResults();

                var formData = new FormData();
                formData.append('q', keywords);

                this.mediaList.children('li').addClass('searched');

                this._disableList();

                $.ajax({
                    url: self.searchForm.attr('action'),
                    type: "POST",
                    contentType: false,
                    processData: false,
                    cache: false,
                    data: formData,
                    success: function (data) {
                        if (data !== '') {
                            var selector = '#md_' + data.join(',#md_');

                            $(selector).removeClass('searched');
                        }

                        self._enableList();

                        self._anyResults();
                    }
                });
            }
        },
        // Displays no results notification if there are no results
        _anyResults: function () {
            if (this.isRetrieved) {
                if (this.mediaList.find('li').length === this.mediaList.find('.searched,.filtered').length) {
                    this.noResults.addClass('active');
                } else {
                    this.noResults.removeClass('active');
                }
            }
        },
        // Forces hide no results notification
        _yesResults: function () {
            this.noResults.removeClass('active');
        },
        // Enables uploader
        _enableUploader: function () {
            this.uploader.options.enabled = true;
        }
    };

    // Register to window namespace
    window.Library = Library;

    // LibraryIndicator Constructor
    function LibraryIndicator(name, size) {
        this._init(name);

        this.app = window.documentsLibrary;
    }

    // Inherit from Indicator
    LibraryIndicator.prototype = Indicator.prototype;

    // Overload Indicator _init
    LibraryIndicator.prototype._init = function (name) {
        this.parent = $('<li class="indicator"></li>');

        this.thumbnail = $('<div class="document-thumbnail"></div>');
        this.thumbnail.appendTo(this.parent);

        this.name = $('<p>' + name + '</p>');
        this.name.appendTo(this.parent);

        $('<i class="icon-check"></i>').appendTo(this.parent);

        this.progressBar = $('<div class="progress"></div>');
        this.progressBar.appendTo(this.thumbnail);
    };

    // Overload Indicator _error
    LibraryIndicator.prototype._error = function (data) {
        this.parent.remove();
    };

    // Overload Indicator _success
    LibraryIndicator.prototype._success = function (data) {
        this.parent.removeClass('indicator');

        this.parent.attr('data-id', data.id);
        this.parent.attr('id', 'md_' + data.id);
        this.parent.attr('data-name', html_entities(data.name));
        this.parent.attr('data-flag', data.type);
        this.parent.attr('data-size', data.size);
        this.parent.attr('data-mimetype', data.mimetype);

        this.thumbnail.html(data.thumbnail);

        // Refilter the app
        this.app.refilter();

        // Select new uploaded media
        this.app.selectMediaById(data.id);
    };

    // Overload Indicator setProgress
    LibraryIndicator.prototype.setProgress = function (percentage) {
        percentage = percentage.toString() + '%';

        this.progressBar.height(percentage).width(percentage);
    };

    // Register indicator to the window namespace
    window.LibraryIndicator = LibraryIndicator;

})(window);
;( function(window) {
    'use strict';

    /**
     * Gallery constructor
     *
     * @param DOM Object
     */
    function Gallery(el, library) {
        this.type = 'gallery';

        this.el = el;
        this.library = library;

        this.container = this.el.find('.form-media-container');

        this.input = this.el.find('input[type="hidden"]');

        this.addButton = this.el.find('.button-add');
        this.clearButton = this.el.find('.button-clear');

        this.mediaGallery = this.el.find('.form-media-gallery');

        this._initEvents();
    }

    // Prototype
    Gallery.prototype = {
        // Bind events
        _initEvents : function() {
            var self = this;

            $(this.mediaGallery).sortable({
                cursor : 'move',
                tolerance : 'pointer',
                placeholder : 'placeholder',
                opacity : 0.7,
                delay: 50,
                stop : function() { self._setGallery(); }
            }).disableSelection();

            // Bind events for non touch screens
            if(!Modernizr.touch) {
                this.mediaGallery.find('.icon-cancel').on('click', function() {
                    var parent = $(this).parent();

                    $(parent).remove();

                    self._setGallery();
                });
            }

            this.clearButton.on('click', function(e) {
                self._clearGallery();

                e.preventDefault();
                e.stopPropagation();
            });

            this.addButton.on('click', function(e) {
                self.library.run(self);

                e.preventDefault();
                e.stopPropagation();
            });
        },
        _clearGallery: function() {
            this.input.val('');

            this.mediaGallery.html('');

            this.container.addClass('empty');
        },
        // Parses gallery string
        _parseGallery : function() {
            var array = $(this.mediaGallery).sortable('toArray', {attribute: 'data-id'});

            return JSON.stringify(array);
        },
        // Sets gallery string
        _setGallery : function() {
            this.input.val(this._parseGallery());
        },
        // Returns the current value
        getValue : function() {
            return this.input.val();
        },
        // Sets the value
        setValue : function(gallery) {
            this._clearGallery();
            // Check length
            if(gallery.length > 0) {
                this.container.removeClass('empty');

                this.mediaGallery.html('');

                var array = [];

                for(var i = 0; i < gallery.length; i++) {
                    array.push(gallery[i].id);

                    this._createThumbnail(gallery[i]);
                }

                this.input.val(JSON.stringify(array));
            }
        },
        // Create a new thumbnail
        _createThumbnail : function(media) {
            var thumbnail = $('<li data-id="' + media.id + '"><i class="icon-cancel"></i></li>');

            $('<img src="' + media.thumbnail.attr('src') + '" alt="' + html_entities(media.name) + '">').appendTo(thumbnail);

            this.mediaGallery.append(thumbnail);
        }
    };

    window.Gallery = Gallery;

})(window);

// Run when document is loaded
$(document).ready(function() {

    // Run for all
    $('.nc-form-gallery').each(function() {
        var gallery = new Gallery($(this), App);
    });

});
;(function (window) {
    'use strict';

    /**
     * Document constructor
     *
     * @param DOM Object
     */
    function Document(el, library) {
        this.type = 'document';

        this.el = el;
        this.library = library;

        this.container = this.el.find('.form-media-container');

        this.input = this.el.find('input[type="hidden"]');

        this.addButton = this.el.find('.button-add');
        this.removeButton = this.el.find('.button-clear');

        this.thumbnail = this.el.find('.form-document-thumbnail span');
        this.fileName = this.el.find('.form-document-name');

        this.filter = this.el.data('filter');

        this._initEvents();
    }

    // Prototype
    Document.prototype = {
        // Bind events
        _initEvents: function () {
            var self = this;

            this.removeButton.on('click', function (e) {
                self._removeDocument();

                e.preventDefault();
                e.stopPropagation();
            });

            // Bind open
            this.addButton.on('click', function (e) {
                self.library.run(self);

                e.preventDefault();
                e.stopPropagation();
            });
        },
        // Remove file
        _removeDocument: function () {
            this.input.val('');

            this.thumbnail.attr('src', '');

            this.fileName.text('');

            this.container.addClass('empty');
        },
        // Returns the current value
        getValue: function () {
            return this.input.val();
        },
        // Sets the value
        setValue: function (media) {
            if (media !== null) {
                this.container.removeClass('empty');

                this.input.val(media.id);

                this.fileName.text(media.name);

                this.thumbnail.html(media.thumbnail);
            } else {
                this._removeDocument();
            }
        }
    };

    // Register to window namespace
    window.Document = Document;

})(window);
;(function (window) {
    'use strict';

    // Editor constructor
    function Editor(el, library, dialog) {
        this._init(el, library, dialog);
    }

    // Editor app
    Editor.prototype = {

        /**
         * Initialises app
         *
         * @param DOM
         */
        _init: function (el, library, dialog) {
            this.el = el;
            this.text = this.el.find('textarea');
            this.library = library;
            this.dialog = dialog;

            this.toolbar = this.el.find('.markdown-editor-toolbar');

            this._controls();

            this._initEvents();
        },

        /**
         * Initialises the events for the editor
         */
        _initEvents: function () {
            var self = this;

            // Resize the textarea
            this.text.height('auto');
            this.text.height(this.text.prop('scrollHeight') + 'px');

            // Bind resize events
            this.text.on('change', function (e) {
                self.resize(e);
            });
            this.text.on('cut paste drop keydown', function (e) {
                self.delayedResize(e);
            });
            $(window).resize(function (e) {
                self.delayedResize(e);
            });

            // Bind tabbing
            this.text.on('keydown', function (e) {
                if (e.keyCode === 9) {
                    e.stopPropagation();
                    e.preventDefault();

                    if (e.shiftKey && e.keyCode === 9) {
                        self.flush(e);
                    } else {
                        self.indent(e);
                    }
                }
            });

            // Set tool clicks
            this.toolbar.on('click', '.toolset li', function (e) {
                var method = $(this).data('method');

                if (self.controls[method]) {
                    self.controls[method]();
                }

                self.delayedResize(e);

                return false;
            });
        },

        /**
         * Returns the gallery controller
         */
        _getGalleryController: function () {
            return new EditorGallery(this, this.library);
        },

        /*
         * Returns the document controller
         */
        _getDocumentController: function () {
            return new EditorDocument(this, this.library);
        },

        /**
         * Resizes the textarea for each line
         */
        resize: function (e) {
            var bodyScrollPos = $('body').prop('scrollTop');
            this.text.height('auto');
            this.text.height(this.text.prop('scrollHeight') + 'px');
            $('body').prop('scrollTop', bodyScrollPos);
        },

        /* 0-timeout to get the already changed text */
        delayedResize: function (e) {
            var self = this;
            var timeout = setTimeout(function () {
                self.resize(e);
            }, 0);
        },

        /**
         * Inserts string at the cursor
         *
         * @param string
         */
        insert: function (str) {
            var element = this.text[0];

            var start = element.selectionStart;
            var value = element.value;

            element.value = value.substring(0, start) + str + value.substring(start);

            element.selectionStart = element.selectionEnd = start + str.length;
        },

        /**
         * Removes selected string
         */
        deleteSelection: function () {
            var element = this.text[0];

            var start = element.selectionStart, end = element.selectionEnd;
            var value = element.value;

            element.value = value.substring(0, start) + value.substring(end);
        },

        /**
         * Wraps selection with given params
         */
        wrap: function (left, right) {
            var element = this.text[0];

            var start = element.selectionStart, end = element.selectionEnd;
            var value = element.value;

            element.value = value.substring(0, start) + left + value.substring(start, end) + right + value.substring(end);

            element.selectionStart = end + left.length + right.length;
        },

        /**
         * Tabs all lines in the selection
         */
        indent: function (e) {
            var element = this.text[0];

            var start = element.selectionStart, end = element.selectionEnd;
            var value = element.value;

            var selections = value.substring(start, end).split("\n");

            for (var i = 0; i < selections.length; i++) {
                selections[i] = "\t" + selections[i];
            }

            element.value = value.substring(0, start) + selections.join("\n") + value.substring(end);

            if (end > start) {
                element.selectionStart = start;
                element.selectionEnd = end + selections.length;
            } else {
                element.selectionStart = element.selectionEnd = start + 1;
            }
        },
        /**
         * Untabs all lines in the selection
         */
        flush: function (e) {
            var element = this.text[0];

            var start = element.selectionStart, end = element.selectionEnd;
            var value = element.value;

            var pattern = new RegExp(/^[\t]{1}/);

            var edits = 0;

            if (start === end) {
                while (start > 0) {
                    if (value.charAt(start) === "\n") {
                        start++;
                        break;
                    }

                    start--;
                }

                var portion = value.substring(start, end);
                var matches = portion.match(pattern);

                if (matches) {
                    element.value = value.substring(0, start) + portion.replace(pattern, '') + value.substring(end);
                    end--;
                }

                element.selectionStart = element.selectionEnd = end;
            } else {
                var selections = value.substring(start, end).split("\n");

                for (var i = 0; i < selections.length; i++) {
                    if (selections[i].match(pattern)) {
                        edits++;
                        selections[i] = selections[i].replace(pattern, '');
                    }
                }

                element.value = value.substring(0, start) + selections.join("\n") + value.substring(end);

                element.selectionStart = start;
                element.selectionEnd = end - edits;
            }
        },

        /**
         * Sets the editor controls
         */
        _controls: function () {
            var self = this;

            this.controls = {
                bold: function () {
                    self.wrap('**', '**');
                },
                italic: function () {
                    self.wrap('*', '*');
                },
                code: function () {
                    self.wrap('`', '`');
                },
                link: function () {
                    var element = self.text[0];

                    var start = element.selectionStart, end = element.selectionEnd;
                    var value = element.value;

                    var selection = value.substring(start, end);

                    self.dialog.run(self, 'link');

                    self.dialog.urlInput.val(selection);
                },
                list: function () {
                    var element = self.text[0];

                    var start = element.selectionStart, end = element.selectionEnd;
                    var value = element.value;

                    var selections = value.substring(start, end).split("\n");

                    for (var i = 0; i < selections.length; i++) {
                        selections[i] = '* ' + selections[i];
                    }

                    element.value = value.substring(0, start) + "\n" + selections.join("\n") + "\n" + value.substring(end);
                },
                quote: function () {
                    var element = self.text[0];

                    var start = element.selectionStart, end = element.selectionEnd;
                    var value = element.value;

                    var selections = value.substring(start, end).split("\n");

                    for (var i = 0; i < selections.length; i++) {
                        selections[i] = '> ' + selections[i];
                    }

                    element.value = value.substring(0, start) + selections.join("\n") + value.substring(end);
                },
                heading: function () {
                    self.wrap('###', '');
                },
                hrule: function () {
                    var element = self.text[0];

                    var start = element.selectionStart, end = element.selectionEnd;
                    var value = element.value;

                    var ruler = '\n***\n';

                    element.value = value.substring(0, start) + ruler + value.substring(end);

                    element.selectionStart = element.selectionEnd = end + ruler.length;
                },
                readmore: function () {
                    var element = self.text[0];

                    var start = element.selectionStart, end = element.selectionEnd;
                    var value = element.value;

                    var readmore = '\n![READMORE]!\n';

                    element.value = value.substring(0, start) + readmore + value.substring(end);

                    element.selectionStart = element.selectionEnd = end + readmore.length;
                },
                media: function () {
                    var element = self.text[0];

                    var start = element.selectionStart, end = element.selectionEnd;
                    var value = element.value;

                    var selection = value.substring(start, end);

                    self.dialog.run(self, 'library');

                    self.dialog.sourceInput.val(selection);
                }
            };
        }

    };

    // Register Editor to window namespace
    window.Editor = Editor;


    // Editor dialog constructor
    function EditorDialog() {
        this._init();
    }

    // Editor dialog prototype
    EditorDialog.prototype = {
        // Initialize
        _init: function () {
            var self = this;

            // Create a new dialog
            this.dialog = new Modal($('.modal-editor'), {
                onConfirmEvent: function (dialog) {
                    self._setValue();
                }
            });

            this.controller = null;

            this.mode = null;

            this.container = this.dialog.el.find('.modal');
            this.libraryDialog = this.container.find('.editor-modal-library');
            this.linkDialog = this.container.find('.editor-modal-link');

            this.galleryButton = this.libraryDialog.find('.editor-modal-gallery-button');
            this.mediaButton = this.libraryDialog.find('.editor-modal-document-button');

            this.sourceInput = this.libraryDialog.find('input[name="_src"]');
            this.alttextInput = this.libraryDialog.find('input[name="_alt"]');

            this.urlInput = this.linkDialog.find('input[name="_link"]');
            this.textInput = this.linkDialog.find('input[name="_text"]');

            this._initEvents();
        },
        // Initializes events
        _initEvents: function () {
            // Cache self
            var self = this;

            // Gallery button
            this.galleryButton.on('click', function (e) {
                self.dialog.closeModal();

                var controller = self.controller._getGalleryController();

                controller.run();

                e.preventDefault();
                e.stopPropagation();
            });

            // Document button
            this.mediaButton.on('click', function (e) {
                self.dialog.closeModal();

                var controller = self.controller._getDocumentController();

                controller.run();

                e.preventDefault();
                e.stopPropagation();
            });
        },
        // Runs the dialog
        run: function (controller, mode) {
            this.setMode(mode);

            this.controller = controller;

            this._reset();

            this.dialog.openModal();
        },
        // Sets the mode
        setMode: function (mode) {
            this.mode = mode;

            this.container.removeClass('library link');
            this.container.addClass(mode);
        },
        // Resets the dialog
        _reset: function () {
            this.sourceInput.val('');
            this.alttextInput.val('');

            this.urlInput.val('');
            this.textInput.val('');
        },
        // Inserts a value depending on mode
        _setValue: function () {
            this.controller.deleteSelection();

            if (this.mode === 'library') {
                this._setValueLibrary();
            } else if (this.mode === 'link') {
                this._setValueLink();
            }
        },
        // Set value as link
        _setValueLink: function () {
            var url = this.urlInput.val();

            if (url.slice(0, 1) !== '#') {
                url = add_http(url);
            }

            var text = (this.textInput.val().length > 0) ? this.textInput.val() : this.urlInput.val();

            var str = '[' + text + '](' + url + ')';

            this.controller.insert(str);
        },
        // Set value as image
        _setValueLibrary: function () {
            this.controller.insert('![' + this.alttextInput.val() + '](' + this.sourceInput.val() + ')');
        }
    };

    // Register editor dialog to window namespace
    window.EditorDialog = EditorDialog;


    // Editor gallery constructor
    function EditorGallery(controller, library) {
        this._init(controller, library);
    }

    // Editor media app
    EditorGallery.prototype = {
        // Initialize
        _init: function (controller, library) {
            this.library = library;

            this.type = 'gallery';

            this.controller = controller;
        },
        // Runs the app
        run: function () {
            this.library.run(this);
        },
        // Get value
        getValue: function () {
            return '';
        },
        // Set value
        setValue: function (media) {
            var array = [];

            for (var i = 0; i < media.length; i++) {
                array.push(media[i].id);
            }

            this.controller.insert('\n[gallery ids="' + array.join(',') + '"]\n');
        }
    };

    // Register editor gallery to window namespace
    window.EditorGallery = EditorGallery;


    // Editor gallery constructor
    function EditorDocument(controller, library) {
        this._init(controller, library);
    }

    // Editor media app
    EditorDocument.prototype = {
        // Initialize
        _init: function (controller, library) {
            this.library = library;

            this.type = 'document';

            this.controller = controller;
        },
        // Runs the app
        run: function () {
            this.library.run(this);
        },
        // Get value
        getValue: function () {
            return '';
        },
        // Set value
        setValue: function (media) {
            this.controller.insert('\n[document id="' + media.id + '"]\n');
        }
    };

    // Register editor media to window namespace
    window.EditorDocument = EditorDocument;

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

window.documentsLibrary = new Library($('#library-modal-container'));

// Initialize gallery fields
$('.form-group-gallery').each(function () {
    var gallery = new Gallery($(this), window.documentsLibrary);
});

// Initialize document fields
$('.form-group-document').each(function () {
    var document = new Document($(this), window.documentsLibrary);
});

window.editorDialog = new EditorDialog();

// Editors
$('.form-group-markdown').each(function () {
    var editor = new Editor($(this), window.documentsLibrary, window.editorDialog);
});
//# sourceMappingURL=form.js.map