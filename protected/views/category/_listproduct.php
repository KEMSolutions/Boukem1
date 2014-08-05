<?php
/**
 * @var $data Product
 */
$localization = $data->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
$product_url = $this->createUrl('product/view', array('slug'=>$localization->slug));
$brand = $data->brand;
$brand_localization = $brand->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
$main_image = $localization->getMainImage();

?>

<tr>
	<td class="hidden-xs">
		
        <a href="<?php echo $product_url; ?>">
			<img alt="" src="<?php 
			
			if ($main_image){
				echo $main_image->getImageUrl(50, 50);
			} else {
				echo ProductImage::placehoderForSize(50, 50);
			}
				?>" alt="<?php echo $localization->name; ?>" class="img-responsive center-block">
			
					</a>
		</td>
		<td>
			<strong><a href="<?php echo $product_url; ?>"><?php echo $localization->name; ?></a></strong><br>
			<small><?php echo CHtml::link($brand_localization->name, array('category/view', 'slug'=>$brand_localization->slug)) . " - " . $data->sku . " - " . $data->barcode; ?></small>
		</td>
		
		<td>
			<?php echo number_format((float)$data->getCurrentPrice(), 2, '.', ''); ?> $
		</td>
		
		<td class="input-qty-detail form-inline text-right col-xs-4 col-sm-3 col-lg-2">
			

				    <input type="text" class="form-control input-qty text-center qtymultiple pull-right" data-product="<?php echo $data->id; ?>" value="0">
			
		</td>
</tr>