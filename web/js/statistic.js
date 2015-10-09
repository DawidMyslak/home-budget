/**
 * @property $
 * @property Chartist
 * @property dataA
 * @property dataB
 * @property dataC
 */

(function () {
	function format(value) {
		return ' &euro;' + Number(value).toFixed(2);
	}
	
	/* chart A */

	var chartASliceIndex = 0;
	$(window).resize(function () {
		chartASliceIndex = 0;
	});

	var chartA = new Chartist.Pie('.ct-chart-a', dataA, {
		fullWidth: true,
		height: 320,
		donut: true,
		donutWidth: 40,
		labelInterpolationFnc: function (value) {
			return;
		}
	});

	chartA.on('draw', function (data) {
		if (data.type === 'slice') {
			var cssClass = 'ct-slice-donut-' + chartASliceIndex;
			data.element.addClass(cssClass);
			$('.' + cssClass).attr('ct:label', dataA.labels[chartASliceIndex]);
			chartASliceIndex++;
		}
	});

	var chartA = $('.ct-chart-a');
	var chartAInitValue = $('.ct-chart-a-value').html();
	var chartAInitLabel = $('.ct-chart-a-label').html();

	chartA.on('mouseenter', '.ct-slice-donut', function () {
		var slicePie = $(this),
			value = slicePie.attr('ct:value'),
			label = slicePie.attr('ct:label');

		$('.ct-chart-a-value').html(format(value));
		$('.ct-chart-a-label').html(label);
	});

	chartA.on('mouseleave', '.ct-slice-donut', function () {
		$('.ct-chart-a-value').html(chartAInitValue);
		$('.ct-chart-a-label').html(chartAInitLabel);
	});
	
	/* chart B */

	var chartB = new Chartist.Line('.ct-chart-b', dataB, {
		fullWidth: true,
		chartPadding: {
			right: 40
		},
		height: 320,
		low: 0,
		lineSmooth: Chartist.Interpolation.cardinal({
			tension: 0
		})
	});

	chartB.on('draw', function (data) {
		if (data.type === 'grid' && data.index === 0) {
			data.element.addClass('ct-axis-0');
		}
	});

	var chartB = $('.ct-chart-b');

	var tooltipB = chartB
		.append('<div class="ct-tooltip ct-tooltip-b"></div>')
		.find('.ct-tooltip-b')
		.hide();

	chartB.on('mouseenter', '.ct-point', function () {
		var point = $(this),
			value = point.attr('ct:value'),
			seriesName = point.parent().attr('ct:series-name');
		tooltipB.html(seriesName + '<br>' + format(value)).show();
	});

	chartB.on('mouseleave', '.ct-point', function () {
		tooltipB.hide();
	});

	chartB.on('mousemove', function (event) {
		tooltipB.css({
			left: (event.offsetX || event.originalEvent.layerX) - tooltipB.width() / 2 - 10,
			top: (event.offsetY || event.originalEvent.layerY) - tooltipB.height() - 40
		});
	});
	
	/* chart C */

	var chartC = new Chartist.Bar('.ct-chart-c', dataC, {
		fullWidth: true,
		chartPadding: {
			right: 40
		},
		height: 320
	});

	chartC.on('draw', function (data) {
		if (data.type === 'grid' && data.index === data.axis.ticks.indexOf(0)) {
			data.element.addClass('ct-axis-0');
		}
		else if (data.type === 'bar' && data.value.y < 0) {
			data.element.addClass('ct-bar-negative');
		}
	});

	var chartC = $('.ct-chart-c');

	var tooltipC = chartC
		.append('<div class="ct-tooltip ct-tooltip-c"></div>')
		.find('.ct-tooltip-c')
		.hide();

	chartC.on('mouseenter', '.ct-bar', function () {
		var bar = $(this),
			value = bar.attr('ct:value')
		status = '';

		if (value > 0) {
			status = '+';
		} else if (value < 0) {
			status = '-';
		}
		value = Math.abs(value);

		tooltipC.html(status + ' ' + format(value)).show();
	});

	chartC.on('mouseleave', '.ct-bar', function () {
		tooltipC.hide();
	});

	chartC.on('mousemove', function (event) {
		tooltipC.css({
			left: (event.offsetX || event.originalEvent.layerX) - tooltipC.width() / 2 - 10,
			top: (event.offsetY || event.originalEvent.layerY) - tooltipC.height() - 40
		});
	});
} ());
