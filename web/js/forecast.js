/**
 * @property $
 */

(function () {
	if (typeof $ === 'undefined') return;

	function format(value) {
		return '&euro;' + Number(value).toFixed(2);
	}

	function total() {
		var expenses = 0;

		$('input[type=checkbox]').each(function () {
			if (this.checked) {
				expenses += parseFloat($(this).parent().parent().children('span').html().substring(1));
			}
		});

		$('.expenses').html(format(expenses));
	}

	$(document).ready(function () {
		total();
	});

	$('input[type=checkbox]').change(function () {
		total();
	});
} ());
