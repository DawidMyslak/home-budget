/**
 * @property $
 * @property categories
 */

(function() {
	function prepareSubcategories() {
		var categoryId = $('#keyword-category_id').val();
		var subcategoryId = $('#keyword-subcategory_id').val();
		
		$('#keyword-subcategory_id').html('<option value=""></option>');
		
		for (var i = 0, l = categories.length; i < l; i++) {
			var category = categories[i];
			if (category.id === categoryId) {
				for (var j = 0, l = category.subcategories.length; j < l; j++) {
					var subcategory = category.subcategories[j];
					$('#keyword-subcategory_id').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
				}
				$('#keyword-subcategory_id').val(subcategoryId);
				break;
			}
		}
	}
	
	$(document).ready(function() {
		prepareSubcategories();
	});
	
	$('#keyword-category_id').change(function() {
		prepareSubcategories();
	});
}());
