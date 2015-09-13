/**
 * @property $
 * @property Chartist
 * @property dataA
 * @property dataB
 * @property dataC
 */

(function() {
	// charts
	
	var chartA = new Chartist.Pie('.ct-chart-a', dataA, {
		fullWidth: true,
		height: 300,
		labelOffset: 40,
		labelInterpolationFnc: function(value) {
			return value[0];
		}
	});
	
	var chartB = new Chartist.Line('.ct-chart-b', dataB, {
		fullWidth: true,
		chartPadding: {
			right: 40
		},
		height: 300,
		low: 0,
		lineSmooth: Chartist.Interpolation.cardinal({
			tension: 0
		})
	});
	
	chartB.on('draw', function(data) {
		if (data.type === 'grid' && data.index === 0) {
			data.element.addClass('ct-axis-0');
		}
	});
	
	var chartC = new Chartist.Bar('.ct-chart-c', dataC, {
		fullWidth: true,
		chartPadding: {
			right: 40
		},
		height: 300
	});
	
	chartC.on('draw', function(data) {
		if (data.type === 'grid' && data.index === data.axis.ticks.indexOf(0)) {
			data.element.addClass('ct-axis-0');
		}
		else if (data.type === 'bar' && data.value.y < 0) {
			data.element.addClass('ct-bar-negative');
		}
	});
	
	// tooltips
	
	var chartB = $('.ct-chart-b');
	
	var tooltipB = chartB
		.append('<div class="ct-tooltip ct-tooltip-b"></div>')
		.find('.ct-tooltip-b')
		.hide();
	
	chartB.on('mouseenter', '.ct-point', function() {
		var point = $(this),
			value = point.attr('ct:value'),
			seriesName = point.parent().attr('ct:series-name');
		tooltipB.html(seriesName + '<br>&euro;' + value).show();
	});
	
	chartB.on('mouseleave', '.ct-point', function() {
		tooltipB.hide();
	});
	
	chartB.on('mousemove', function(event) {
		tooltipB.css({
			left: (event.offsetX || event.originalEvent.layerX) - tooltipB.width() / 2 - 10,
			top: (event.offsetY || event.originalEvent.layerY) - tooltipB.height() - 40
		});
	});
	
	var chartC = $('.ct-chart-c');
	
	var tooltipC = chartC
		.append('<div class="ct-tooltip ct-tooltip-c"></div>')
		.find('.ct-tooltip-c')
		.hide();
	
	chartC.on('mouseenter', '.ct-bar', function() {
		var bar = $(this),
			value = bar.attr('ct:value')
			status = '';
			
		if (value > 0) {
			status = '+';
		} else if (value < 0) {
			status = '-';
		}
		value = Math.abs(value);
		
		tooltipC.html(status + ' &euro;' + value).show();
	});
	
	chartC.on('mouseleave', '.ct-bar', function() {
		tooltipC.hide();
	});
	
	chartC.on('mousemove', function(event) {
		tooltipC.css({
			left: (event.offsetX || event.originalEvent.layerX) - tooltipC.width() / 2 - 10,
			top: (event.offsetY || event.originalEvent.layerY) - tooltipC.height() - 40
		});
	});
}());
