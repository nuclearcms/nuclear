$('.scroller').perfectScrollbar();

$(window).on('resize.scroller', function () {
    $('.scroller').perfectScrollbar('update');
});

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

contentWhiteout.on('click', function () {
    closeNavigation();
});

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