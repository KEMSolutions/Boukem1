<section class="slice animate-hover-slide">
	<?php if ($show_title): ?>
	<div class="section-title color-three">
	        <h3><?php echo Yii::t("app", "Choix populaires"); ?></h3>
	        <div class="indicator-down color-three"></div>
	    </div>
	
	<?php endif; ?>
	<div class="w-section inverse blog-grid">
    	<div class="container">
        	<div id="masonryWr" class="row">
				
				<?php
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