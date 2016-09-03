;(function (window) {
    'use strict';

    /**
     * MarkdownEditor Constructor
     */
    function MarkdownEditor(el) {
        this.el = el;

        this._init();
    }

    // Prototype
    MarkdownEditor.prototype = {
        _init: function () {
            this.textarea = this.el.children('textarea')[0];

            this._initEditor();

            this.toolbar = this.el.children('.editor-toolbar');

            this._initEvents();
        },
        _initEvents: function () {
            var self = this;

            $(window).on('scroll.editor', function () {
                self._locateToolbar();
            });

            $(document).on('keydown.mde_' + $(this.textarea).attr('name'), function (e) {
                e.stopPropagation();

                if (e.which === 27) {
                    setTimeout(function () {
                        self._locateToolbar();
                    }, 0);
                }
            });
        },
        _locateToolbar: function () {
            if (this.toolbar.hasClass('fullscreen')) {
                this.toolbar.css('top', 0);

                return;
            }

            var st = $(window).scrollTop(),
                ot = this.el.offset().top;

            if (ot < st && st < (ot + this.el.outerHeight() - 30)) {
                this.toolbar.css('top', String(st - ot) + 'px');
            } else {
                this.toolbar.css('top', 0);
            }
        },
        _initEditor: function () {
            var self = this;

            this.mde = new SimpleMDE({
                element: this.textarea,
                spellChecker: false,
                status: false,
                toolbar: [
                    {
                        name: 'bold',
                        className: 'icon-bold',
                        title: window.editorTooltips.bold,
                        action: SimpleMDE.toggleBold,
                    },
                    {
                        name: 'italic',
                        className: 'icon-italic',
                        title: window.editorTooltips.italic,
                        action: SimpleMDE.toggleItalic,
                    },
                    {
                        name: 'strikethrough',
                        className: 'icon-strikethrough',
                        title: window.editorTooltips.strikethrough,
                        action: SimpleMDE.toggleStrikethrough,
                    },
                    {
                        name: 'heading-3',
                        className: 'icon-heading',
                        title: window.editorTooltips.heading,
                        action: SimpleMDE.toggleHeading3,
                    },
                    "|",
                    {
                        name: 'link',
                        className: 'icon-anchor',
                        title: window.editorTooltips.link,
                        action: function mdeLink(editor) {
                            alert('special link');
                        },
                    },
                    {
                        name: 'image',
                        className: 'icon-image',
                        title: window.editorTooltips.image,
                        action: function mdeImage(editor) {
                            alert('special document, separate with gallery?');
                        },
                    },
                    "|",
                    {
                        name: 'quote',
                        className: 'icon-quote',
                        title: window.editorTooltips.quote,
                        action: SimpleMDE.toggleBlockquote,
                    },
                    {
                        name: 'unordered-list',
                        className: 'icon-list-bullet',
                        title: window.editorTooltips.list_unordered,
                        action: SimpleMDE.toggleUnorderedList,
                    },
                    {
                        name: 'ordered-list',
                        className: 'icon-list-number',
                        title: window.editorTooltips.list_ordered,
                        action: SimpleMDE.toggleOrderedList,
                    },
                    {
                        name: 'code',
                        className: 'icon-code',
                        title: window.editorTooltips.code,
                        action: SimpleMDE.toggleCodeBlock,
                    },
                    "|",
                    {
                        name: 'subscript',
                        className: 'icon-subscript',
                        title: window.editorTooltips.subscript,
                        action: function mdeSubscript(editor) {
                            var cm = editor.codemirror,
                                selection = cm.getSelection();
                            cm.replaceSelection('~' + selection + '~');
                        },
                    },
                    {
                        name: 'superscript',
                        className: 'icon-superscript',
                        title: window.editorTooltips.superscript,
                        action: function mdeSubscript(editor) {
                            var cm = editor.codemirror,
                                selection = cm.getSelection();
                            cm.replaceSelection('^' + selection + '^');
                        },
                    },
                    {
                        name: 'table',
                        className: 'icon-table',
                        title: window.editorTooltips.table,
                        action: SimpleMDE.drawTable,
                    },
                    {
                        name: 'horizontal-rule',
                        className: 'icon-minus',
                        title: window.editorTooltips.horizontal_rule,
                        action: SimpleMDE.drawHorizontalRule,
                    },
                    {
                        name: 'readmore',
                        className: 'icon-ellipsis-horizontal',
                        title: window.editorTooltips.readmore,
                        action: function mdeReadmore(editor) {
                            var cm = editor.codemirror;
                            cm.replaceSelection('\n\n![READMORE]!\n\n');
                        },
                    },
                    "|",
                    {
                        name: 'preview',
                        className: 'icon-eye no-disable',
                        title: window.editorTooltips.preview,
                        action: SimpleMDE.togglePreview,
                    },
                    {
                        name: 'side-by-side',
                        className: 'icon-columns no-disable no-mobile',
                        title: window.editorTooltips.side_by_side,
                        action: function mdeToggleSideBySide(editor) {
                            self.mde.toggleSideBySide(editor);
                            setTimeout(function () {
                                self._locateToolbar();
                            }, 0);
                        }
                    },
                    {
                        name: 'fullscreen',
                        className: 'icon-expand no-disable no-mobile',
                        title: window.editorTooltips.fullscreen,
                        action: function mdeToggleFullScreen(editor) {
                            self.mde.toggleFullScreen(editor);
                            setTimeout(function () {
                                self._locateToolbar();
                            }, 0);
                        }
                    },
                    {
                        name: 'guide',
                        className: 'icon-status-info',
                        title: window.editorTooltips.markdown,
                        action: 'https://simplemde.com/markdown-guide',
                    },
                ]
            });
        }
    };

    window.MarkdownEditor = MarkdownEditor;

})(window);