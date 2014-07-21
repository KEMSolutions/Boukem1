function updateBuyButtonsForProductWithId(id){
	$('button[data-product="' + id + '"]').html('<i class="fa fa-check-square"></i>');
	$('button[data-product="' + id + '"]').attr("disabled", "disabled");
}

function updateCartOverview(openModal){
	$.getJSON( "/" + page_lang + "/cart/overview", function( data ) {
	  	
		$("#cart_modal_items").html("");
		var total_count = 0;
		$.each( data, function( index, val ) {
			total_count += parseInt(val.quantity);
			updateBuyButtonsForProductWithId(val.product_id);
			$("#cart_modal_items").append("<li class='media'><a class='pull-left' href='" + val.link + "'><img class='media-object' src='" + val.thumbnail + "' alt=''></a><div class='media-body'><h4 class='media-heading'>" + val.name + "</h4>" + val.quantity + " x " + val.price_paid + "</div></li>");
			
		});
		$("#cart_badge").text(total_count);
		if (openModal){
			$( "#modal_cart" ).load( "/" + $("html").attr("lang") + '/site/modalCart', function() {
			  $("#cartModal").modal('show');
	  		$.each( data, function( index, val ) {
	  			$("#cart_modal_items").append("<li class='media'><a class='pull-left' href='" + val.link + "'><img class='media-object' src='" + val.thumbnail + "' alt=''></a><div class='media-body'><h4 class='media-heading'>" + val.name + "</h4>" + val.quantity + " x " + val.price_paid + "</div></li>");
	  		});
			});
			
		}
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
	updateCartOverview(true);
	updateBuyButtonsForProductWithId(product_id);
});
})


updateCartOverview(false);

