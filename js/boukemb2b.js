if( $('.buymultiple').length )         // When we have a buy multiple button, push the rest of the page up
{
	$("body").css("margin-bottom", "50px");
	
}


$(".buymultiple").click(function(){
	$(".buymultiple").attr("disabled", "disabled");
	var buybutton = $(this);
	var products_array = {};
	$.each( $(".qtymultiple"), function( index ) {
		
		// Find products on the list view (if any)
		products_array[$(this).attr("data-product")] = $(this).val();
		
	});
	
	var products_string = JSON.stringify(products_array);
	
	$.post( "/" + page_lang + "/cart/addMultiple", { "products": products_string }, function( data ) {
		buybutton.addClass('animated tada');
		updateCartOverview(true);
		$(".buymultiple").removeAttr("disabled");
	});

});