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
            this._initDialog();

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
        _initDialog: function () {
            this.dialog = new MarkdownEditorDialog();
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
        markdown: function (plain) {
            // We need to do superscripts like this since
            // the ^ character is not received well by js
            var re = /[\^]((?:\\\\\^|[^\^\n\r])+?)[\^]/g, m;
            while ((m = re.exec(plain)) !== null) {
                if (m.index === re.lastIndex) {
                    re.lastIndex++;
                }

                plain = plain.replace(m[0], '<sup>' + m[1] + '</sup>');
            }

            // Next we switch to regular subscript adding
            // and before we let codemirror handle things
            // we just have to convert target="_blank" links
            plain = plain
                .replace(/[~]((?:\\\\\~|[^~\n\r])+?)[~](?![~])/g, '<sub>$1</sub>')
                .replace(/\[([^\]]+)\]\(([^)]+)\)\{blank\}/g, '<a href="$2" target="_blank">$1</a>');

            return this.mde.markdown(plain);
        },
        _initEditor: function () {
            var self = this;

            this.mde = new SimpleMDE({
                element: this.textarea,
                spellChecker: false,
                status: false,
                previewRender: function (plain) {
                    return self.markdown(plain);
                },
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
                            self.dialog.run('link', editor);
                        },
                    },
                    {
                        name: 'media',
                        className: 'icon-image',
                        title: window.editorTooltips.media,
                        action: function mdeImage(editor) {
                            self.dialog.run('media', editor);
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


    /**
     * MarkdownEditor Constructor
     */
    function MarkdownEditorDialog() {
        this._init();
    }

    // Prototype
    MarkdownEditorDialog.prototype = {
        _init: function () {
            var self = this;

            this.el = $('.modal--editor').first();
            this.modalInner = this.el.find('.modal__inner').first();

            this.link_url = this.modalInner.find('input[name="link_url"]').first();
            this.link_title = this.modalInner.find('input[name="link_title"]').first();
            this.link_blank = this.modalInner.find('input[name="link_blank"]').first();

            this.image_url = this.modalInner.find('input[name="image_url"]').first();
            this.image_alttext = this.modalInner.find('input[name="image_alttext"]').first();

            this.gallery_button = this.modalInner.find('button.button--gallery');
            this.document_button = this.modalInner.find('button.button--document');

            this.gallery_controller = new MarkdownEditorGallery(window.documentsLibrary);
            this.document_controller = new MarkdownEditorDocument(window.documentsLibrary);

            this.modal = new Modal(this.el, {
                onConfirmEvent: function (dialog) {
                    self._insert();
                }
            });

            this.mode = null;
            this.editor = null;

            this._initEvents();
        },
        _initEvents: function () {
            var self = this;

            this.gallery_button.on('click', function () {
                self.modal.closeModal();

                self.gallery_controller.run(self.editor);
            });

            this.document_button.on('click', function () {
                self.modal.closeModal();

                self.document_controller.run(self.editor);
            });
        },
        run: function (mode, editor) {
            this._reset();
            this._setMode(mode);

            this.editor = editor;

            this.modal.openModal();

            this._populateByMode();
        },
        _reset: function () {
            this.modalInner.removeClass('editor-modal--link editor-modal--media');

            this.link_url.val('');
            this.link_title.val('');
            this.link_blank.attr('checked', false);

            this.image_url.val('');
            this.image_alttext.val('');
        },
        _setMode: function (mode) {
            this.mode = mode;
            this.modalInner.addClass('editor-modal--' + mode);
        },
        _populateByMode: function () {
            var cm = this.editor.codemirror;

            if (this.mode === 'link') {
                this.link_title.val(cm.getSelection());

                this.link_url.focus();
            } else if (this.mode === 'media') {
                this.image_url.val(cm.getSelection());

                this.image_alttext.focus();
            }
        },
        _insert: function () {
            if (this.mode === 'link') {
                this._insertLink();
            } else if (this.mode === 'media') {
                this._insertImage();
            }
        },
        _insertLink: function () {
            var url = add_http(this.link_url.val());

            var text = (this.link_title.val().length > 0) ? this.link_title.val() : this.link_url.val();

            var link = '[' + text + '](' + url + ')';

            if (this.link_blank.is(':checked')) {
                link += '{blank}';
            }

            this.editor.codemirror.replaceSelection(link);
        },
        _insertImage: function () {
            this.editor.codemirror.replaceSelection('![' + this.image_alttext.val() + '](' + this.image_url.val() + ')');
        }
    };

    window.MarkdownEditorDialog = MarkdownEditorDialog;


    /**
     * MarkdownEditorGallery constructor
     */
    function MarkdownEditorGallery(library) {
        this._init(library);
    }

    // Prototype
    MarkdownEditorGallery.prototype = {
        _init: function (library) {
            this.library = library;
            this.editor = null;

            this.mode = 'gallery';
            this.filter = 'image';
        },
        run: function (editor) {
            this.editor = editor;

            this.library.run(this);
        },
        getValue: function () {
            return '';
        },
        setValue: function (images) {
            this.editor.codemirror.replaceSelection('\n[gallery ids="' + images.join(',') + '"]\n');
        }
    };

    // Register editor gallery to window namespace
    window.MarkdownEditorGallery = MarkdownEditorGallery;


    /**
     * MarkdownEditorDocument constructor
     */
    function MarkdownEditorDocument(library) {
        this._init(library);
    }

    // Prototype
    MarkdownEditorDocument.prototype = {
        _init: function (library) {
            this.library = library;
            this.editor = null;

            this.mode = 'document';
            this.filter = 'all';
        },
        run: function (editor) {
            this.editor = editor;

            this.library.run(this);
        },
        getValue: function () {
            return '';
        },
        setValue: function (document) {
            this.editor.codemirror.replaceSelection('\n[document id="' + document + '"]\n');
        }
    };

    // Register editor media to window namespace
    window.MarkdownEditorDocument = MarkdownEditorDocument;

})(window);