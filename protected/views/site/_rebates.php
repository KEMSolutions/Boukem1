<section class="slice animate-hover-slide">
	<?php if ($show_title): ?>
	<div class="section-title color-three">
	        <h3><?php echo Yii::t("app", "Promotions"); ?></h3>
	        <div class="indicator-down color-three"></div>
	    </div>
	
	<?php endif; ?>
	<div class="w-section inverse blog-grid">
    	<div class="container">
        	<div class="row">
<?php

if (!isset($rebates_array)){
	// If we render the _rebates slice for the first time
	$rebates_array = $items->getData();
	shuffle($rebates_array);
}

$counter = 0;
	
	 foreach ($rebates_array as $key => $rebate): 
		
		$product = $rebate->product;
		$localization = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
		if ($product && $localization && $product->visible && !$product->discontinued){
			$this->renderPartial("application.views._product_card", array("product"=>$product, "style"=>"fs", "localization"=>$localization));
			
			$counter ++;
			
			
		}
	
	unset($rebates_array[$key]);
	if ($counter >= $limit){
		break;
	}
	
endforeach; ?>
			</div>
			
		</div>
	</div>
</section>