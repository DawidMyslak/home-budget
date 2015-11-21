/**
 * @property $
 */

(function () {
	if (typeof $ === 'undefined') return;
	
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});
} ());