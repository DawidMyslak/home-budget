/**
 * @property $
 * @property categories
 */

(function() {
	function prepareSubcategories(model) {
		var categoryId = $('#' + model + '-category_id').val();
		var subcategoryId = $('#' + model + '-subcategory_id').val();
		
		$('#' + model + '-subcategory_id').html('<option value=""></option>');
		
		for (var i = 0, l = categories.length; i < l; i++) {
			var category = categories[i];
			if (category.id === categoryId) {
				for (var j = 0, l = category.subcategories.length; j < l; j++) {
					var subcategory = category.subcategories[j];
					$('#' + model + '-subcategory_id').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
				}
				$('#' + model + '-subcategory_id').val(subcategoryId);
				break;
			}
		}
	}
	
	$(document).ready(function() {
		prepareSubcategories('keyword');
		prepareSubcategories('transaction');
	});
	
	$('#keyword-category_id').change(function() {
		prepareSubcategories('keyword');
	});
	
	$('#transaction-category_id').change(function() {
		prepareSubcategories('transaction');
	});
}());
