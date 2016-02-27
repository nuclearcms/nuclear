;( function(window) {
    'use strict';

    /**
     * Modal constructor
     *
     * @param DOM Object
     * @param object
     */
    function Modal(el, options, triggers) {
        this._init(el, options, triggers);
    }

    // Modal prototype
    Modal.prototype = {
        // Initialize the object
        _init : function(el, options, triggers)
        {
            this.el = el;
            this.triggers = triggers;
            this.current = null;

            this.options = $.extend({
                onCreateEvent : function() { return false; },
                onOpenEvent : function() { return false; },
                onCloseEvent : function() { return false; },
                onConfirmEvent : function() { return false; },
                onOptionEvent : function() { return false; }
            }, options);

            this.isOpen = false;

            this.options.onCreateEvent(this);

            this._initEvents();
        },

        // Initialize events
        _initEvents : function() {
            var el = this.el,
                self = this;

            if(typeof this.triggers != 'undefined' && this.triggers !== null) {
                this.triggers.on('click', function(e) {

                    self.current = $(this);

                    self.openModal(self);

                    e.stopPropagation();
                    e.preventDefault();
                });
            }

            // Confirm button bind
            el.find('.confirm-button').click(function(e) {
                self.options.onConfirmEvent(self);

                self.closeModal();

                e.stopPropagation();
                e.preventDefault();
            });
            // Option button bind
            el.find('.option-button').click(function(e) {
                self.options.onOptionEvent(self);

                self.closeModal();

                e.stopPropagation();
                e.preventDefault();
            });
            // Close button bind
            el.find('.close-button').click(function(e) {
                self.options.onCloseEvent(self);

                self.closeModal();

                e.stopPropagation();
                e.preventDefault();
            });
            // Blackout bind
            el.find('.blackout').click(function(e) {

                self.options.onCloseEvent(self);

                self.closeModal();

                e.stopPropagation();
                e.preventDefault();
            });

            el.find('.modal').click(function(e) {
                e.stopPropagation();
            });
        },
        // Open modal
        openModal : function() {
            var el = $(this.el),
                self = this;

            if(!this.isOpen) {
                el.addClass('open');
                $('body').addClass('disable-scroll');

                // Bind dynamically to avoid interference with other similar elements
                $(document).bind('keydown', function(e) {
                    var keyCode = e.keyCode || e.which;
                    if(keyCode === 27) { self.closeModal(); }
                });

                this.options.onOpenEvent(this);

                this.isOpen = true;
            }
        },
        // Close modal
        closeModal : function() {
            var el = $(this.el);

            if(this.isOpen) {
                el.removeClass('open');
                $('body').removeClass('disable-scroll');

                // Unbind dynamically to avoid interference with other similar elements
                $(document).unbind('keydown');

                this.options.onCloseEvent(this);

                this.isOpen = false;
            }
        }
    };

    // Register to window namespace
    window.Modal = Modal;

}) (window);