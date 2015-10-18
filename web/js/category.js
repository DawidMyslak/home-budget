/**
 * @property $
 */

(function () {
	if (typeof $ === 'undefined') return;

	function getIcon(event) {
		return $(event.target).parent().find('.caret');
	}

	$('#accordion').on('show.bs.collapse', function (event) {
		var icon = getIcon(event);
		icon.removeClass('caret-rotated');
	});

	$('#accordion').on('hide.bs.collapse', function (event) {
		var icon = getIcon(event);
		icon.addClass('caret-rotated');
	});
} ());
