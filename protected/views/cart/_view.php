<?php
/* @var $this CartController
   @var $data OrderHasProduct
 */

$product = $data->product;
$localizationForProduct = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=true);

?>

<tr data-product="<?php echo $product->id; ?>">
    <td class="remove-cell col-xs-1"><button type="button" class="btn btn-default cart_remove_button" title="<?php echo Yii::t('app', 'Enlever du panier'); ?>"><i class="fa fa-times-circle fa-lg"></i></button>
		<td class="hidden-xs"><img src="<?php
		
		$image = $localizationForProduct->getMainImage();
		
		echo $image ? $image->getImageURL(150,150) : ProductImage::placehoderForSize(150,150);
		?>" class="img-center" alt=""></td>
    <td><?php echo CHtml::link($localizationForProduct->name, array("product/view", 'slug'=>$localizationForProduct->slug)); ?></td>
    <td>$<?php echo CHtml::encode($data->price_paid);?></td>
    <td class="col-md-3">
		<div class="form-inline">
		 <input type="text" class="form-control quantity_field" value="<?php echo $data->quantity;?>">
		<button type="button" class="btn btn-default update_cart_quantity" data-toggle="dropdown"><?php echo Yii::t('app', "Modifier"); ?></button>
		<div>
    </td>
</tr>