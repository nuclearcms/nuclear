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