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
            
            
            var product_id = $this.closest("li").data("product");
            e.stopPropagation();
            $.post( cartData.$links.remove_url, { product: product_id })
            .done(function( data ) {
                updateCartOverview(false);
            });
			var cart_item = $this.closest("li");
			cart_item.addClass('animated bounceOutRight');
			cart_item.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
	            cart_item.remove();
			});
            
        });        
    },
    
    modifiyQuantity: function() {
        $("#cart-items").on("change", ".quantity", function() {
            $(this).next().fadeIn();
        });
        
        $("#cart-items").on("click", ".update_quantity", function() {
           $this = $(this);
           
		   var container = $this.closest("li");
            product_id = container.data("product");
            quantity = container.find(".quantity").val();
            
            $.post( cartData.$links.update_url, { product: product_id, quantity: quantity })
            .done(function( data ) {
	           location.reload();
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