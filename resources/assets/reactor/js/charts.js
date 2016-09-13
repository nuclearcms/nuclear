Chart.defaults.global.responsive = true;
Chart.defaults.global.defaultFontFamily = '"Lato", sans-serif';
Chart.defaults.global.defaultFontColor = '#BE9100';
Chart.defaults.global.tooltips.backgroundColor = '#BE9100';
Chart.defaults.global.legend.position = 'bottom';
Chart.defaults.global.legend.labels.boxWidth = 16;
Chart.defaults.global.legend.labels.padding = 32;
Chart.defaults.global.legend.labels.usePointStyle = true;
Chart.defaults.global.legend.labels.fontSize = 10;

window.chartDisplayDefaults = {
    borderColor: '#FFFFFF',
    fill: false,
    pointRadius: 6,
    pointHoverRadius: 8,
    pointBackgroundColor: "#FFFFFF",
    pointHoverBackgroundColor: "#FFFFFF",
    pointBorderColor: "rgba(190,140,0,0.5)",
    pointBorderWidth: 4
};

var chartFlaps = $('#chartFlaps .tabs__child-link'),
    chartTabs = $('#chartTabs .chart__container');

chartFlaps.on('click', function () {
    chartFlaps.removeClass('tabs__child-link--active');
    $(this).addClass('tabs__child-link--active');

    chartTabs.removeClass('chart__container--active');
    $('#chartTabs .chart__container--' + $(this).data('mode')).addClass('chart__container--active');
})