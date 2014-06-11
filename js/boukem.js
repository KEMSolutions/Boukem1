function updateBuyButtonsForProductWithId(id){
	$('button[data-product="' + id + '"]').html('<i class="fa fa-check-square"></i>');
	$('button[data-product="' + id + '"]').attr("disabled", "disabled");
}

function updateCartOverview(){
	$.getJSON( "/" + page_lang + "/cart/overview", function( data ) {
	  
		var total_count = 0;
		$.each( data, function( index, val ) {
			total_count += parseInt(val.quantity);
			updateBuyButtonsForProductWithId(val.product_id);
		});
		$("#cart_badge").text(total_count);
	});
}



var page_lang = $("html").attr("lang");
$(".buybutton").click(function(){
	var buybutton = $(this);
	var product_id = buybutton.attr("data-product");
	var quantity;
	if($("#item_quantity").length) {
	    quantity = $("#item_quantity").val();
	} else {
		quantity = 1;
	}
	
	buybutton.attr("disabled", "disabled");
	buybutton.html('<i class="fa fa-spinner fa-spin"></i>');
	
	$.post( "/" + page_lang + "/cart/add", { "product": product_id, "quantity" : quantity }, function( data ) {
	buybutton.addClass('animated tada');
	updateCartOverview();
	updateBuyButtonsForProductWithId(product_id);
	});
})


updateCartOverview();