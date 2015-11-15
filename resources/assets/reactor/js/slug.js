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