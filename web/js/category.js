/**
 * @property $
 */

(function () {
	if (typeof $ === 'undefined') return;

	function getIcon(event) {
		return $(event.target).parent().find('.fa-update');
	}

	$('#accordion').on('show.bs.collapse', function (event) {
		var icon = getIcon(event);
		icon.removeClass('fa-chevron-circle-right');
		icon.addClass('fa-chevron-circle-down');
	});

	$('#accordion').on('hide.bs.collapse', function (event) {
		var icon = getIcon(event);
		icon.addClass('fa-chevron-circle-right');
		icon.removeClass('fa-chevron-circle-down');
	});
} ());
