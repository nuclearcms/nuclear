;(function (window) {
    'use strict';

    /**
     * Tags constructor
     */
    function Tags(el) {
        this.el = el;

        this._init();
    }

    inheritsFrom(Tags, Searcher);

    // Tags prototype
    Tags.prototype._init = function () {
        this.nodeid = this.el.data('nodeid');
        this.storeurl = this.el.data('storeurl');
        this.attachurl = this.el.data('attachurl');
        this.detachurl = this.el.data('detachurl');
        this.locale = this.el.data('locale');

        this.tagsList = this.el.find('ul.tags-list');
        this.tags = this.el.find('li.tag');

        this.initSearcher();

        this._initEvents();
    }

    Tags.prototype._extractItems = function () {
        this.itemKeys = this.tags.map(function () {
            return $(this).data('tagid');
        }).get();
    }

    Tags.prototype._initEvents = function () {
        var self = this;

        this.tagsList.on('click', '.tag__option--detach', function () {
            var tag = $(this).closest('li.tag');

            if (!tag.hasClass('tag--disabled')) {
                tag.addClass('tag--disabled');

                self._detachTag(tag);
            }
        });
    }

    Tags.prototype._searchPressReturn = function (title) {
        if (title == '') {
            return;
        }

        var placeholder = $('<li class="tag tag--disabled tag--placeholder"></li>').appendTo(this.tagsList),
            self = this;

        $.post(this.storeurl, {title: title}, function (response) {
            if (response.type === 'success' && self.itemKeys.indexOf(parseInt(response.tag.id)) == -1) {
                var tag = self._createTag(response.tag.id, response.tag.title, response.tag.translatable, response.tag.editurl, response.tag.translateurl);

                placeholder.replaceWith(tag);

                tag.removeClass('tag--disabled');

                self._finishAddingTag(response.tag.id, tag);

                return;
            }

            self._clearSearch();

            placeholder.remove();

            window.flash.addMessage(response.message, response.type);
        });
    }

    Tags.prototype._search = function (keywords) {
        var self = this;

        if (!self.searching) {
            $.post(this.searchurl, {q: keywords, locale: self.locale}, function (data) {
                self._populateResults(data);
            });
        }
    }

    Tags.prototype._addResult = function (id, item) {
        return $('<li class="related-search__result" data-translatable="' + item.translatable + '" data-editurl="' + item.editurl + '"data-translateurl="' + item.translateurl + '">' + item.title + '<input class="related-search__input" type="text" value="' + id + '"></li>');
    }

    Tags.prototype._addItem = function (item) {
        var id = parseInt(item.find('input').val());

        var tag = this._createTag(id, item.text(), item.data('translatable'), item.data('editurl'), item.data('translateurl'));

        this._attachTag(tag);

        this._finishAddingTag(id, tag)
    }

    Tags.prototype._finishAddingTag = function (id, tag) {
        this.tagsList.append(tag);

        this.itemKeys.push(id);

        this._clearSearch();

        this.search.focus();
    }

    Tags.prototype._createTag = function (id, title, translatable, editurl, translateurl) {
        var tag = $('<li class="tag tag--disabled" data-tagid="' + id + '"><span class="tag__option tag__option--detach"><i class="tag__icon icon-cancel"></i></span></li>');

        $('<span class="tag__text"><a href="' + editurl + '" target="_blank">' + title + '</a></span>').prependTo(tag);

        if (translatable === true) {
            $('<span class="tag__option"><a href="' + translateurl + '" target="_blank"><i class="tag__icon icon-language"></i></a></span>').appendTo(tag);
        }

        return tag;
    }

    Tags.prototype._attachTag = function (tag) {
        $.post(this.attachurl, {tagid: tag.data('tagid')}, function (response) {
            if (response.type === 'success') {
                tag.removeClass('tag--disabled');
            } else {
                tag.remove();

                window.flash.addMessage(response.message, response.type);
            }
        });
    }

    Tags.prototype._detachTag = function (tag) {
        var id = tag.data('tagid'),
            self = this;

        $.post(this.detachurl, {tagid: id}, function (response) {
            if (response.type === 'success') {
                var i = self.itemKeys.indexOf(id);
                delete self.itemKeys[i];

                tag.remove();
            } else {
                tag.removeClass('tag--disabled');

                window.flash.addMessage(response.message, response.type);
            }
        });
    }

    // Register tags to window namespace
    window.Tags = Tags;

})(window);

$(function () {
    return new Tags($('#nodesTags'));
});
//# sourceMappingURL=tags.js.map
