// GENERAL LABEL HIGHLIGHTERS
$('.form-group input, .form-group textarea').focus(function () {
    $(this).closest('.form-group').find('.form-group__label').addClass('form-group__label--focus');
});

$('.form-group input, .form-group textarea').blur(function () {
    $(this).closest('.form-group').find('.form-group__label').removeClass('form-group__label--focus');
});

// LOCATE FORM BUTTONS
var formContainer = $('#content'),
    formButtons = $('#formButtons');

function locateFormButtons() {
    var wH = $(window).height(),
        fcH = formContainer.outerHeight();

    if ((wH - 16) > fcH) {
        formButtons.css('bottom', (wH - fcH + 16) + 'px');
    } else {
        formButtons.css('bottom', '');
    }
}

locateFormButtons();
$(window).on('resize.formbuttons', function () {
    locateFormButtons();
});