<?php if ($layout->dense): ?>
<section class="slice color-two-d home_featured">
	<?php
	if ($show_tab){
		$this->renderPartial('_tab', array("layout"=>$layout));
	}
	?>
	<div class="w-section inverse blog-grid">
    	<div class="container">
        	<div class="row js-masonry">
				
<?php else: ?>
			
<section class="slice animate-hover-slide home_featured">
	<?php
	if ($show_tab){
		$this->renderPartial('_tab', array("layout"=>$layout));
	}
	?>
	<div class="w-section inverse blog-grid">
    	<div class="container">
        	<div class="row js-masonry">
				
<?php endif; ?>
				
				<?php
				$counter = 0;
	
					 foreach ($layout->products as $item){
		
							$product = Product::model()->findByPk($item->id);
							if (!$product)
								continue;
							
							$localization = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
							if ($localization && $product->visible && !$product->discontinued){
								
								if ($layout->dense){
									$this->renderPartial("application.views._product_card_dense", array("product"=>$product, "style"=>"fs", "localization"=>$localization));
								} else {
									$this->renderPartial("application.views._product_card", array("product"=>$product, "style"=>"fs", "localization"=>$localization));
								}
								
							
							
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