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
