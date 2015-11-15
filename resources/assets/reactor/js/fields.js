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

// Initialize color pickers
$('input.minicolors').minicolors();