<?php


if (!isset($localization)){
	$localization = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
}

if ($localization):

	$product_url = $this->createUrl("product/view", array('slug'=>$localization->slug));

	$brand = $product->brand;
	$brand_localization = $brand->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
	$main_image = $localization->getMainImage();
	
	$currentPrice = $product->getCurrentPrice();
	$regularPrice = $product->price;
	if ($currentPrice == $regularPrice) {
		$isOnSale = false;
		$rebatePercent = 0;
	} else {
		$isOnSale = true;
		$rebatePercent = round((($regularPrice - $currentPrice) / $regularPrice) * 100, $precision=0, $mode=PHP_ROUND_HALF_DOWN);
	}



 ?>
	
	
	<div class="col-xs-6 col-sm-4 col-md-3 text-center dense_product">
		
		<a href="<?php echo $product_url; ?>"><img alt="" src="<?php 

		if ($main_image){
			echo $main_image->getImageUrl(160, 160, $fit=ProductImage::FIT_HEIGHT);
		} else {
			echo ProductImage::placehoderForSize(160, 160);
		}
			?>" alt="<?php echo $localization->name; ?>" class=" center-block"></a>
		<?php if ($isOnSale): ?>
			<div class="rebatebadge"><span class="animated tada">-<?php echo $rebatePercent; ?>%</span></div>
		<?php endif; ?>
		<?php if ($brand_localization): ?>
		<div class="text-uppercase brand"><strong><?php echo CHtml::link($brand_localization->name, array('category/view', 'slug'=>$brand_localization->slug)); ?></strong></div>
	<?php endif; ?>
		
		<div class="name">
			<a href="<?php echo $product_url; ?>"><?php
					
								$title_lines = explode(" - ", $localization->name);
								$counter = 0;
								$number_of_lines = count($title_lines);
								 foreach ($title_lines as $line){
									 if ($counter != 0 && $counter <= $number_of_lines){
										 // Not first line
										 echo "<br>";
									 }
						 
									 if ($counter != 0 && $counter+1 == $number_of_lines){
										 // Last but also not first line
										 echo "<small>" . $line . "</small>";
									 } else {
										 echo $line;
									 }
						
									 $counter++;
								 }
					 
								  ?></a>
		</div>
		
		<div class="price">
		
		<button class="btn btn-default btn-xs buybutton" data-product="<?php echo $product->id ?>"><i class="fa fa-shopping-cart"></i> <?php
		
		if ($isOnSale) {
			echo "<small class='regularprice'>" . $product->price . "</small> ";
		}
		 echo $product->getLocalizedCurrentPrice(); ?></button>
		</div>
		
		
	</div>
	
	 
	 
	 
<?php

 endif;

?>