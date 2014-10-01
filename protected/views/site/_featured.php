<section class="slice animate-hover-slide">
	<div class="w-section inverse blog-grid">
    	<div class="container">
        	<div id="masonryWr" class="row">
				
				<?php
				error_reporting(E_ALL);
				ini_set('display_errors', '1');
	
				$counter = 0;
	
					 foreach ($items as $item){
		
							$product = Product::model()->findByPk($item);
							$localization = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
							if ($product && $localization && $product->visible && !$product->discontinued){
								$this->renderPartial("application.views._product_card", array("product"=>$product, "style"=>"fs", "localization"=>$localization));
							
							
								$counter ++;
								if ($counter >= $limit){
									break;
								}
							}
						
						}
					?>
	
	
	
				
			</div>
		</div>
	</div>
</section>