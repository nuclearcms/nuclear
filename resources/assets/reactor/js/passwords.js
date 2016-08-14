;( function(window) {
    'use strict';

    /**
     * PasswordMeter constructor
     *
     * @param DOM Object el
     * @param string field
     */
    function PasswordMeter(el, field, meter) {
        this.el = el;

        field = field || 'input[type="password"]';
        meter = meter || '.form-group__password > .password-strength';

        this.field = this.el.find(field);
        this.meter = this.el.find(meter);
        this._init();
    }

    // PasswordMeter prototype
    PasswordMeter.prototype = {
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
                this.meter.addClass('password-strength password-strength--veryweak');
            } else if(total === 2) {
                this.meter.removeClass();
                this.meter.addClass('password-strength password-strength--weak');
            } else if(total === 3) {
                this.meter.removeClass();
                this.meter.addClass('password-strength password-strength--medium');
            } else {
                this.meter.removeClass();
                this.meter.addClass('password-strength password-strength--strong');
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
    window.PasswordMeter = PasswordMeter;

})(window);