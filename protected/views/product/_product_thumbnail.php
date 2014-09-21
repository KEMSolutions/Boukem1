		<div class="w-section inverse blog-grid">
	    	<div class="container">
	        	<div class="row">
	                <div class="col-md-12">
<?php foreach ($items as $product) {
 error_reporting(E_ALL);
 ini_set('display_errors', '1');

	if ($product && $product->visible && !$product->discontinued){
		$this->renderPartial("application.views._product_card", array("product"=>$product, "style"=>"lg"));
	}
	
} ?>
</div>
</div>
</div>
</div>