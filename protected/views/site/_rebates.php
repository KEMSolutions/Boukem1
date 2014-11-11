<?php if ($layout->dense) :?>
	<section class="slice color-two-d">
		<?php
		if ($show_tab){
			$this->renderPartial('_tab', array("layout"=>$layout));
		}
		?>
		
	<div class="w-section inverse blog-grid">
    	<div class="container">
			<div class="row js-masonry">
<?php else: ?>
<section class="slice animate-hover-slide">
	<?php
	if ($show_tab){
		$this->renderPartial('_tab', array("layout"=>$layout));
	}
	?>
	
	<div class="w-section inverse blog-grid">
    	<div class="container">
        	<div class="row js-masonry" data-masonry-options='{ "itemSelector": ".item" }'>
<?php endif; ?>
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
			if ($layout->dense){
				$this->renderPartial("application.views._product_card_dense", array("product"=>$product, "style"=>"fs", "localization"=>$localization));
			} else {
				$this->renderPartial("application.views._product_card", array("product"=>$product, "style"=>"fs", "localization"=>$localization));
			}
			
			
			$counter ++;
			
		}
	
	unset($rebates_array[$key]);
	if ($counter >= $layout->limit) {
		break;
	}
	
endforeach; ?>
			</div>
			
		</div>
	</div>
</section>