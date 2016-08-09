$('.scroller').perfectScrollbar();

$(window).on('resize.scroller', function () {
    $('.scroller').perfectScrollbar('update');
});

var hamburger = $('#hamburger'),
    navigationContainer = $('#navigationContainer'),
    contentContainer = $('#contentContainer'),
    contentWhiteout = $('#contentWhiteout'),
    content = $('#content'),
    body = $('body');

hamburger.on('click', function (e) {
    toggleNavigation();

    $(this).toggleClass('hamburger--open');

    e.preventDefault();
    e.stopPropagation();
    return false;
});

contentWhiteout.on('click', function () {
    contentContainer.removeClass('container-content--slide');
    navigationContainer.removeClass('container-navigation--slide');
    contentWhiteout.removeClass('content-whiteout--active-nav');
    hamburger.removeClass('hamburger--open');
    body.removeClass('scroll-disabled');
});

function toggleNavigation() {
    contentContainer.toggleClass('container-content--slide');
    navigationContainer.toggleClass('container-navigation--slide');
    contentWhiteout.toggleClass('content-whiteout--active-nav');
    body.toggleClass('scroll-disabled');
}