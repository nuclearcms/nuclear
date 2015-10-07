// Highlighters
$('.form-group input').focus(function () {
    $(this).closest('.form-group').addClass('focus');
});

$('.form-group input').blur(function () {
    $(this).closest('.form-group').removeClass('focus');
});

// Password strength meter
$('.form-group-password').each(function() {
    new Meter($(this));
});