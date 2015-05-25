function Entity(price, quantity) {
    this.price = price;
    this.quantity = quantity;
}

var cartDisplay = {    
    $el : {
        $back : $("#back"),
        $proceed : $("#proceed"),
        $trigger : $(".view-cart"),
        $container : $("#cart-container"),
		$checkout : $("#checkout"),
        $body : $("body"),
    },
    
    displayOn: function() {
        _width = cartDisplay.$el.$container.width();
        cartDisplay.$el.$container.css( {
            "margin-right" : -_width,
        });        
                
        cartDisplay.$el.$trigger.click(function() {
            cartDisplay.animateIn();
        });
    },
    
    displayOff : function() {
        _width = cartDisplay.$el.$container.width();
        cartDisplay.$el.$back.click(function() {
            cartDisplay.animateOut();
        });
        cartDisplay.$el.$checkout.click(function() {
            sessionStorage.isDisplayed = false;
        });
    },
    
    animateIn : function() {
        cartDisplay.$el.$container.show();
        cartDisplay.$el.$container.animate( {
            "margin-right" : 0
        }, 400);
        sessionStorage.isDisplayed = true;
    },
    
    animateOut: function() {
        _width = cartDisplay.$el.$container.width();
        cartDisplay.$el.$container.animate( {
            "margin-right" : -_width
        }, 400, function() {
            $(this).hide();
        });
        sessionStorage.isDisplayed = false;
    },

        
    init : function() {
        cartDisplay.displayOn();
        cartDisplay.displayOff();
        
        if (sessionStorage.isDisplayed == "true")
        {
            cartDisplay.$el.$container.css("margin-right", 0);
            cartDisplay.$el.$container.show();
        }
        
        
    }    
}

var cartData = {    
    $el : {
        $back : $("#back"),
        $proceed : $("#proceed"),
        $trigger : $(".view-cart"),
		$checkout: $("#checkout"),
        $container : $("#cart-container"),
        $body : $("body"),
        $buybutton : $(".buybutton"),
        $close : $(".close-button"),
    },
    
    $links : {
        update_url : '/' + page_lang + '/cart/update',
		remove_url : '/' + page_lang + '/cart/remove',
		estimate_url : '/' + page_lang + '/cart/estimate', 
		login_url : '/' + page_lang + '/site/login'
    },
    
    deleteItem : function() {
        $(document).on('click', ".close-button", function(e) {            
            $this = $(this);
            
			mixpanel.track("Deleted item from cart");
			
			var product_id = $this.closest("li").data("product");
            e.stopPropagation();
            $.post( cartData.$links.remove_url, { product: product_id })
            .done(function( data ) {
                updateCartOverview(false);
            });
			var cart_item = $this.closest("li");
			
			// When we are on the cart layout, make the products disapear by the left as they are presented on the left side of the screen
			if (typeof cartCheckoutFetchEstimateProgramatically == 'function') { 
			  cart_item.addClass('animated bounceOutLeft'); 
			} else {
				cart_item.addClass('animated bounceOutRight');
			}
			
			cart_item.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
	            cart_item.remove();
				
				if (typeof cartCheckoutFetchEstimateProgramatically == 'function') { 
				  cartCheckoutFetchEstimateProgramatically(); 
				}
				cart_item.unbind();
				cart_item.remove();
			});
            
        });        
    },
    
    modifiyQuantity: function() {
        $("#cart-items").on("change", ".quantity", function() {
           $this = $(this);
           
		   
		   mixpanel.track("Updated item quantity");
		   
		   var container = $this.closest("li");
           var product_id = container.data("product");
		   var quantity_group = $this.closest("div");
		   var quantityField = container.find(".quantity");
           var quantity = quantityField.val();
		   var editIcon = quantity_group.find(".fa");
		   var priceLabel = container.find(".product-price");
			
			if (quantity <=0){
				quantity_group.addClass("has-error");
				quantity_group.addClass('animated shake');
				quantity_group.bind('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
					quantity_field.removeClass("animated");
					quantity_field.removeClass("shake");
					quantity_field.unbind();
				});
				return;
			}
			
			editIcon.addClass("fa-spinner fa-spin");
			quantityField.prop("disabled", true);
            
            $.post( cartData.$links.update_url, { product: product_id, quantity: quantity })
            .done(function( data ) {
				updateCartOverview(false);
				priceLabel.text( "$" + (priceLabel.data("price") * quantity).toFixed(2) );
				quantity_group.removeClass("has-error");
				editIcon.removeClass("fa-spinner fa-spin");
				editIcon.addClass('animated tada fa-check-circle-o text-success');
				editIcon.bind('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
					editIcon.removeClass("animated tada text-success fa-check-circle-o");
					editIcon.unbind();
					quantityField.prop("disabled", false);
				});
				
				// Reload the total if we are currently on the cart's page
				if (typeof cartCheckoutFetchEstimateProgramatically == 'function') { 
				  cartCheckoutFetchEstimateProgramatically(); 
				}
				
	       });
			
        })
    },
    
    init : function() {
        cartData.deleteItem();
        cartData.modifiyQuantity();
    }
}

$(document).ready(function() {
    cartDisplay.init();
    cartData.init();
})