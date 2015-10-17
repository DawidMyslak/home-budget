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
		prepareSubcategories();
	});

	$('#keyword-category_id').change(function () {
		prepareSubcategories();
	});

	$('#transaction-category_id').change(function () {
		prepareSubcategories();
	});
} ());

(function () {
	if (typeof $ === 'undefined') return;

	function getIcon(event) {
		var temp = $('#' + event.target.id);
		var temp2 = temp.prev()[0].id;
		var temp3 = $('#' + temp2 + ' .caret');
		return temp3;
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
