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
            cartData.displayData();
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
        $cartitemslist : $("#cart-items-list"),
        $buybutton : $(".buybutton"),
        $subtotal : $(".subtotal dt"),
        $itemprice : $(".item dt"),
        $nbItem : $(".item dd"),
        $taxes : $(".taxes dt"),
        $close : $(".close-button"),
    },
    
    $links : {
        update_url : '/' + page_lang + '/cart/update',
		remove_url : '/' + page_lang + '/cart/remove',
		estimate_url : '/' + page_lang + '/cart/estimate', 
		login_url : '/' + page_lang + '/site/login'
    },
    
    displayData : function() { 
        
        var ar = $.get('/cart/overview', function(res) {    
            array_length = res.length;
            total_price = [];
            
            function getnbItem() {
                var return_total = 0;
                
                for (var i = 0; i < array_length; i++) {
                    return_total += parseInt(res[i].quantity);
                }                
                return return_total;
            }
            nb_item = getnbItem();
            
            cartData.$el.$cartitemslist.empty();
            
            for (var i = 0; i < array_length; i++)
            {
                total_price.push(new Entity(res[i].price_paid, res[i].quantity));
                
                var domElement = '<li class="w-box" data-product="' + res[i].product_id + '" data-quantity=' + res[i].quantity + '>' +
                    '<div class="col-xs-3 text-center"><img src=' + res[i].thumbnail_lg + ' ></div>' +
                    '<div class="col-xs-9">' + 
                        '<h2 class="product-name">' + res[i].name + '<i class="fa fa-times fa-1 close-button pull-right"></i></h2>' + 
                        '<p class="product-price">' + res[i].price_paid + '$</p>' +
                        '<div class="input-group"><input type="number" value="' + res[i].quantity + '" class="quantity form-control" min="1" step="1" >' +
                        '<span class="input-group-btn"><button type="button" class="btn btn-primary update_quantity">Modifier</button></span></div>'
                    '</div>' +
                    '</li>';
                cartData.$el.$cartitemslist.append(domElement);
            }
            cartData.getPrice(total_price, nb_item);
        });
    },
    
    deleteItem : function() {
        $(document).on('click', ".close-button", function(e) {            
            $this = $(this);
            
            
            var product_id = $this.closest("li").data("product");
            e.stopPropagation();
			
            $this.closest("li").remove();
            $.post( cartData.$links.remove_url, { product: product_id })
            .done(function( data ) {
                location.reload();
            });
        });        
    },
    
    getPrice : function(t, nb_item) {
        var return_price = 0;
        
        for (var i =0; i<t.length; i++)    
        {
            return_price += ((parseFloat(t[i].price)) * (parseInt(t[i].quantity)));
        }
        
        cartData.setPrice(return_price, nb_item);
    },
    
    setPrice : function(price, nb_item) {
        var taxes = taxes(price, 0.05, 0.09975).toFixed(2);
        
        cartData.$el.$itemprice.text(price.toFixed(2) + "$");
        cartData.$el.$nbItem.text(nb_item + " items");
        cartData.$el.$taxes.text(taxes + "$");
        cartData.$el.$subtotal.text(((parseFloat(price) + parseFloat(taxes)).toFixed(2) + "$"));
        
        function taxes(price, tvs, tvq) {
            return (price * tvs) + (price * tvq);
        }
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
        $(cartData.$el.$trigger).on("click", cartData.displayData);
        $(".slice").on("click", cartData.$el.$buybutton, cartData.displayData);
        cartData.deleteItem();
        cartData.modifiyQuantity();
    }
}

$(document).ready(function() {
    cartDisplay.init();
    cartData.init();
})