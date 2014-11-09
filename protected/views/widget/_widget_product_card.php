<?php
$product_url = $this->createAbsoluteUrl("product/view", array('slug'=>$localization->slug));

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
?><li class="col-xs-12 col-sm-6 col-md-3"><figure class="card">
  <a href="<?php echo $product_url; ?>" target="_parent">
	  
<img alt="" class="center-block" src="<?php 

if ($main_image){
	echo $main_image->getImageUrl(125, 125, $fit=ProductImage::FIT_HEIGHT);
} else {
	echo ProductImage::placehoderForSize(125, 125);
}
	?>" alt="<?php echo $localization->name; ?>">
	<?php if ($isOnSale): ?><div class="rebatebadge">-<?php echo $rebatePercent; ?>%</div><?php endif; ?>
	<h2 class="text-center"><?php
					
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
							 echo "<small>" . $line . " - </small>";
						 } else if ($counter == 0 && $counter+1 == $number_of_lines) {
							 // Last AND first
							 echo $line;
							 echo "<br>";
						 } else {
							 echo $line;
						 }
						
						 $counter++;
					 }
					 echo "<small><b> " . $currentPrice . "$</b></small>";
					  ?></h2>
					  
  </a>
</figure></li>
