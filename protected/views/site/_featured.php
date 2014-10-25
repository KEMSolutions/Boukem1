<section class="slice animate-hover-slide">
	<?php
	if ($show_tab){
		$this->renderPartial('_tab', array("layout"=>$layout));
	}
	?>
	<div class="w-section inverse blog-grid">
    	<div class="container">
        	<div class="row js-masonry">
				
				<?php
				$counter = 0;
	
					 foreach ($layout->products as $item){
		
							$product = Product::model()->findByPk($item->id);
							$localization = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
							if ($product && $localization && $product->visible && !$product->discontinued){
								$this->renderPartial("application.views._product_card", array("product"=>$product, "style"=>"fs", "localization"=>$localization));
							
							
								$counter ++;
								if ($counter >= $layout->limit){
									break;
								}
							}
						
						}
					?>
	
			</div>
		</div>
	</div>
</section>