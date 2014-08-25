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
			
			// Find products on the list view (if any)
			$('input[data-product=' + val.product_id + ']').val(val.quantity);
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

function pageInitialization(){
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
}

// If our user is visiting a product page, we need to add that product to a json array stored in it's browser session storage
if( $('#product_info_box').length ){
	var product_id = $('#product_info_box').attr("data-product");
	var visited_products;
	if (sessionStorage.getItem("product_history")){
		visited_products = JSON.parse(sessionStorage.getItem("product_history"));
	} else {
		visited_products = [];
	}
	var current_index = visited_products.indexOf(product_id);
	if (current_index > -1) {
	    visited_products.splice(current_index, 1);
	}
	visited_products.unshift(product_id);
	var visited_string = JSON.stringify(visited_products.slice(0,25));
	sessionStorage.setItem('product_history',visited_string);
}

// On pages where a product history section is included (index, cart), fetch a pre-formatted html list prior to initialize our buy buttons
if ($(".product_history_box").length && sessionStorage.getItem("product_history")){
	$(".product_history_title").removeClass("hidden");
	$(".product_history_box").removeClass("hidden");
	
	// Post the JSON formatted list of recent product IDs
	$.post( "/" + page_lang + "/product/thumbnails", { "products": sessionStorage.getItem("product_history"), "limit": $(".product_history_box").attr("data-limit")}, function( data ) {
		$(".product_history_box").html(data);
		var container = $('.product_history_box');
		
		// Wait until the images are loaded so we don't end up with a messed up layout
		imagesLoaded( container, function() {
		 	container.masonry({
			  itemSelector: '.item'
			});
		});
	 	
		pageInitialization();
	});
} else {
	// Initialize the buy button and cart counter immediatly
	pageInitialization();
}



