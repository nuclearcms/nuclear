$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// SCROLLERS
$('.scroller').perfectScrollbar();

$(window).on('resize.scroller', function () {
    $('.scroller').perfectScrollbar('update');
});

// PAGINATION SELECTORS
$('.pagination__selector').on('change', function () {
    window.location = $(this).val();
});

// LOCATE FORM BUTTONS
var formContainer = $('#content'),
    formButtons = $('#formButtons');

function locateFormButtons() {
    var wH = $(window).height(),
        fcH = formContainer.outerHeight();

    // This 12px thing is because of the content container needs to have an
    // extra of 12px bottom padding in order to ensure scrollbar not showing
    if ((wH + 12) > fcH) {
        formButtons.css('bottom', (wH - fcH + 28) + 'px');
    } else {
        formButtons.css('bottom', '');
    }
}

locateFormButtons();
$(window).on('resize.formbuttons', function () {
    locateFormButtons();
});

// CONTENT FILTERS
$('#contentFilter').on('change', function () {
    window.location = $(this).find('option:selected').data('filterurl');
});

// CONTENT CHECKBOXES & BULK ACTIONS
var headerBulkActions = $('.header__action--bulk'),
    bulkSelectedInput = headerBulkActions.find('input[name="_bulkSelected"]');

$('.content-list__checkbox').on('change', function () {
    if ($('.content-list__checkbox:checked').length > 0) {
        headerBulkActions.removeClass('header__action--hidden');
    } else {
        headerBulkActions.addClass('header__action--hidden');
    }

    compileSelectedForBulkAction();
});

headerBulkActions.find('.button--select-none').click(function () {
    $('.content-list__checkbox:checked').prop('checked', false);
    headerBulkActions.addClass('header__action--hidden');

    compileSelectedForBulkAction();
});

headerBulkActions.find('.button--select-all').click(function () {
    $('.content-list__checkbox').prop('checked', true);

    compileSelectedForBulkAction();
});

function compileSelectedForBulkAction() {
    var compiled = [],
        checked = $('.content-list__checkbox:checked');

    for (var i = 0; i < checked.length; i++) {
        compiled.push(checked.eq(i).val());
    }

    bulkSelectedInput.val(JSON.stringify(compiled));
}

// FLASH MESSAGE HIDING
$('.flash-message').addClass('flash-message--hidden');

// DOCUMENTS HOVER BIND
if (Modernizr.touch) {
    $('.document').click(function () {
        $(this).find('.document__options').toggleClass('document__options--focus');
    });
} else {
    $('.document').on('mouseenter', function () {
        $(this).find('.document__options').addClass('document__options--focus');
    });

    $('.document').on('mouseleave', function () {
        $(this).find('.document__options').removeClass('document__options--focus');
    });
}

// CONTENT/FORM SUB TABS
$('.sub-tab-flaps .tabs__link').on('click', function() {
    var locale = $(this).data('locale');

    $('.sub-tab-flaps .tabs__link').removeClass('tabs__link--active');
    $('.sub-tab-flaps .tabs__link[data-locale="' + locale + '"]').addClass('tabs__link--active');

    $('.sub-tab').removeClass('sub-tab--active');
    $('.sub-tab[data-locale="' + locale + '"]').addClass('sub-tab--active');
});