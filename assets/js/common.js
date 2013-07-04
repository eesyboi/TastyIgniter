function addToCart(food_id, quantity) {
	//var obj = $(this).parent('tr').find('select[name=\'quantity\']')
	//var qty = $(obj).val();
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: 'http://localhost/TastyIgniter/cart/add',
		type: 'post',
		data: 'food_id=' + food_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			//$('.success, .warning, .attention, .information, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '</div>');
				
				//$('.success').fadeIn('slow');
				
				//$('#cart-total').html(json['total']);
				
				//$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}

//Remove Category in Admin
function removeCategory(category_id) {

	$.ajax({
		url: 'http://localhost/TastyIgniter/admin/categories/remove',
		type: 'post',
		data: 'category_id=' + category_id,
		dataType: 'json',
		success: function(json) {
		
		}
	});
}

//Remove Food in Admin
function removeFood(food_id) {

	$.ajax({
		url: 'http://localhost/TastyIgniter/admin/foods/remove',
		type: 'post',
		data: 'food_id=' + food_id,
		dataType: 'json',
		success: function(json) {
		
		}
	});
}
