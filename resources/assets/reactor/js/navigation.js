// MOBILE NAVIGATION BUTTON
var hamburger = $('#hamburger'),
    navigationContainer = $('#navigationContainer'),
    contentContainer = $('#contentContainer'),
    contentWhiteout = $('#contentWhiteout'),
    body = $('body');

hamburger.on('click', function (e) {
    toggleNavigation();

    $(this).toggleClass('hamburger--open');

    e.preventDefault();
    e.stopPropagation();
    return false;
});

// CONTENT AREA DISABLER
contentWhiteout.on('click', function () {
    closeNavigation();
});

// NAVIGATION METHODS
function closeNavigation() {
    contentContainer.removeClass('container-content--slide');
    navigationContainer.removeClass('container-navigation--slide');
    contentWhiteout.removeClass('content-whiteout--active');
    hamburger.removeClass('hamburger--open');
    body.removeClass('scroll-disabled');
}

function toggleNavigation() {
    contentContainer.toggleClass('container-content--slide');
    navigationContainer.toggleClass('container-navigation--slide');
    contentWhiteout.toggleClass('content-whiteout--active');
    body.toggleClass('scroll-disabled');
}