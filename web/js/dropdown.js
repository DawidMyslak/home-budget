/**
 * @property $
 * @property model
 * @property categories
 */

(function () {
	if (typeof $ === 'undefined') return;
	if (typeof model === 'undefined') return;
	if (typeof categories === 'undefined') return;

	function prepareSubcategories() {
		var categoryId = $('#' + model + '-category_id').val();
		var subcategoryId = $('#' + model + '-subcategory_id').val();

		$('#' + model + '-subcategory_id').html('<option value=""></option>');

		for (var i = 0, l = categories.length; i < l; i++) {
			var category = categories[i];
			if (category.id === categoryId) {
				for (var j = 0, l = category.subcategories.length; j < l; j++) {
					var subcategory = category.subcategories[j];
					$('#' + model + '-subcategory_id').append('<option value="' + subcategory.id + '">' + $('<div>').text(subcategory.name).html() + '</option>');
				}
				$('#' + model + '-subcategory_id').val(subcategoryId);
				break;
			}
		}
	}

	$(document).ready(function () {
		var date = $('#transaction-date').val();
		if (date) {
			$('#transaction-date').val(date.replace(' 00:00:00', ''));
		}

		prepareSubcategories();
	});

	$('#keyword-category_id').change(function () {
		prepareSubcategories();
	});

	$('#transaction-category_id').change(function () {
		prepareSubcategories();
	});
} ());
