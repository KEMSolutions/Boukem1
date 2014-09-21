<div class="col-md-8">
					
                	<div class="row">
                    	
                        
                        
                       

<?php foreach ($items as $item): 

	$product = Product::model()->findByPk($item);
	if ($product && $product->visible && !$product->discontinued){
		$this->renderPartial("application.views._product_card", array("product"=>$product, "style"=>"large"));
	}
	
endforeach; ?>
                       
                    </div>
				</div>                