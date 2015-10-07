var nav = $('#navigation'),
    hamburger = $('#hamburger'),
    blackout = $('#blackout'),
    close = $('#nav_close'),
    tabs = $('.navigation-tab'),
    flaps = $('.navigation-tabs > li'),
    body = $('body');


function toggleNav() {
    if (nav.hasClass('open')) {
        hideNav();
    } else {
        nav.addClass('open');
        body.addClass('disable-scroll');
    }
}

function hideNav() {
    nav.removeClass('open');
    body.removeClass('disable-scroll');

}

hamburger.on('click', function () {
    toggleNav();
});

blackout.on('click', function () {
    hideNav();
});

close.on('click', function () {
    hideNav();
});


function changeTab(flap) {
    tabs.removeClass('active');

    flap.addClass('active');
    $('#nav_' + flap.data('for')).addClass('active');
}

flaps.on('click', function () {
    flaps.removeClass('active');

    changeTab($(this));
});