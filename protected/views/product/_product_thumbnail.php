		<div class="w-section inverse blog-grid">
	    	<div class="container">
	        	<div class="row">
	                <div class="col-md-12">
<?php foreach ($items as $product) {
	if ($product && $product->visible && !$product->discontinued){
		$this->renderPartial("application.views._product_card", array("product"=>$product, "style"=>"lg"));
	}
	
} ?>
</div>
</div>
</div>
</div>