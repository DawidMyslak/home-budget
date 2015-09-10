// charts

var options = {
	fullWidth: true,
	height: 300,
	labelOffset: 40,
	labelInterpolationFnc: function(value) {
		return value[0];
	}
};

new Chartist.Pie('.ct-chart-a', dataA, options);

var options = {
	fullWidth: true,
	chartPadding: {
		right: 40
	},
	height: 300,
	low: 0,
	lineSmooth: Chartist.Interpolation.cardinal({
		tension: 0
	})
};

new Chartist.Line('.ct-chart-b', dataB, options);


// tooltip

var chart = $('.ct-chart-b');

var tooltip = chart
	.append('<div class="ct-tooltip"></div>')
	.find('.ct-tooltip')
	.hide();

chart.on('mouseenter', '.ct-point', function() {
	var point = $(this),
	value = point.attr('ct:value'),
	seriesName = point.parent().attr('ct:series-name');
	tooltip.html(seriesName + '<br>&euro;' + value).show();
});

chart.on('mouseleave', '.ct-point', function() {
	tooltip.hide();
});

chart.on('mousemove', function(event) {
	tooltip.css({
		left: (event.offsetX || event.originalEvent.layerX) - tooltip.width() / 2 - 10,
		top: (event.offsetY || event.originalEvent.layerY) - tooltip.height() - 40
	});
});