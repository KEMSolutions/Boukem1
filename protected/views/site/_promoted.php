<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
	
$counter = 0;
	
	 foreach ($items as $item): 
		
		$product = Product::model()->findByPk($item);
		if ($product && $product->visible && !$product->discontinued){
			$this->renderPartial("application.views._product_card", array("product"=>$product, "style"=>"fs"));
		}
	
	?>
	
	
	
	<?php 
	
	$counter ++;
	if ($counter >= $limit){
		break;
	}
	
endforeach; ?>