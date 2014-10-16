$('select').chosen({});

function updateChosenSelects() {

		var chosenCountry = $('#country').val();
		if (chosenCountry == 'CA' || chosenCountry == 'US'){
			$('#postcode').removeAttr('disabled');
			$('#province').removeAttr('disabled');
			$('#province').trigger('chosen:updated');
		} else {
			$('#province').attr('disabled','disabled');
			$('#postcode').attr('disabled');
		}

		$('#province optgroup').attr('disabled','disabled');

		if (chosenCountry == 'CA' || chosenCountry == 'US' || chosenCountry == 'MX'){
			$('#province [data-country="' + chosenCountry + '"]').removeAttr('disabled');
		}

		$('#province').trigger('chosen:updated');
	}

$('#country').chosen().change( function(){

	updateChosenSelects();

});


function updateTotal(){
	var total_price = parseFloat($('#price_subtotal').text()) + parseFloat($('#price_transport').text()) + parseFloat($('#price_taxes').text());
	$('#price_total').text(total_price.toFixed(2));
};

var checkoutEnabled = false;
function enableCheckout(){
	$('#estimateButton').removeClass('btn-three');
	$('#estimateButton').addClass('btn-one');
	$('#checkoutButton').addClass('btn-three animated pulse');
	$('#checkoutButton').tooltip('disable');
	checkoutEnabled = true;
}

function updateTransport(){
	if (!$(".shipping_method:checked").val()){
		return;
	}
	
  	$('#price_transport').text($(".shipping_method:checked").attr('data-cost'));

	updateTotal();
	enableCheckout();
}


function fetchEstimate(){
	
	$(".has-error").removeClass("has-error");
	
	var email_value = $("#customer_email").val();
	var postcode_value = $("#postcode").val();
	var country_value = $("#country").val();
	
	var shouldBlock = false;
	if (email_value == ""){
		
		$("#customer_email").parent().addClass("has-error");
		$('#customer_email').addClass('animated shake');
		$('#customer_email').bind('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
			$(this).removeClass("animated");
			$(this).removeClass("shake");
		});
		
		$("#why_email").removeClass("hidden");
		$("#why_email").addClass("animated bounceInRight");
		
		
		shouldBlock = true;
	}
	
	
	if ((country_value == "CA" || country_value == "US") && postcode_value == "") {
		
		$("#postcode").parent().addClass("has-error");
		$('#postcode').addClass('animated shake');
		$('#postcode').bind('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
			$(this).removeClass("animated");
			$(this).removeClass("shake");
		});
		
		shouldBlock = true;
	
	}
	
	
	if (shouldBlock){
		return;
	}
	
	$('#estimate').html('<div class="text-center"><i class="fa fa-spinner fa-3x fa-spin"></i></div>');
	
  $("#total_column").removeClass("hidden");
  $("#total_column").addClass("animated zoomIn");
	
	$.ajax({
	  type: 'POST',
	  dataType: 'json',
	  url: estimate_url,
	  data: {'country':country_value, 'province':$("#province").val(), 'postcode':postcode_value,'email':email_value},
	  success: function(data){
	  
		  $('#estimate').html(data.shipping_block);
		  $('#price_taxes').text(data.taxes.toFixed(2));
	  
		  updateTransport();
		  	
		  // Register the received radio buttons to trigger a total update
		  $(".shipping_method").change(function(){
			  	updateTransport();
		  });
			  
			  
			  
	 },
	 error: function(xhr, textStatus){
	 
		 if (xhr.status == 403){
			 window.location.replace(login_url);
			 return;
		 }
	 
		 $('#estimate').html('<div class="alert alert-danger">Une erreur est survenue. Veuillez vérifier les informations fournies.</div>');
	 }
  
	});
}

$('#estimateButton').click(function( event ){

	event.preventDefault();
	fetchEstimate();

});


$('#checkoutButton').click( function(event){


	if (!checkoutEnabled){
		event.preventDefault();
	}
	
	$(this).removeClass("btn-three");
	$(this).addClass("btn-primary");
	$(this).html("<i class=\"fa fa-spinner fa-spin\"></i>");
	$(this).attr("disabled", "disabled");
	
	$.ajax({
	  type: "POST",
	  url: paypaltoken_url,
	  data: $("#cart_form").serialize(),
	  success: function(data){
	  	
		window.location.href = data.paypal_url;
		
	  },
	  dataType: "json"
	});
	
	
	
	event.preventDefault();
	
	
	
});


$('.update_cart_quantity').click( function(){

	var row = $(this).closest('tr');
	var product_id = row.attr('data-product');
	var quantity = row.find('.quantity_field').val();

	$.post( update_url, { product: product_id, quantity: quantity })
	  .done(function( data ) {
	    location.reload();
	  });

});


$('.cart_remove_button').click(function(){

	var row = $(this).closest('tr');
	var product_id = row.attr('data-product');
	var quantity = row.find('.quantity_field').val();

	$.post( remove_url, { product: product_id })
	  .done(function( data ) {
	    location.reload();
	  });

});

$('#why_email').tooltip();