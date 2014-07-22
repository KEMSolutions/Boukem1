<?php
/* @var $this CartController
   @var $data OrderHasProduct
 */

$product = $data->product;
$localizationForProduct = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=true);

?>

<tr data-product="<?php echo $product->id; ?>">
    <td class="remove-cell col-xs-1"><button type="button" class="btn btn-default cart_remove_button" title="<?php echo Yii::t('app', 'Enlever du panier'); ?>"><i class="fa fa-times-circle fa-lg"></i></button>
				<?php 
				/* $cart_url = $this->createUrl('cart/index');
				echo CHtml::ajaxButton('<i class="fa fa-times-circle fa-2x"></i>', CController::createUrl('cart/remove'),array(
								'type'=>'POST',
								'data'=>array('product'=>$product->id,
								'success'=>'js:function(data){
		window.location = "' . $cart_url . '";
		}',
								'async' => true,
								),
							), array("class"=>"btn btn-danger btn-xs", 'title'=>)); 
			*/	?>
		
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

<?php /* 
<tr>
	<td><img src="" class="img-responsive"></td>
	<td><h2></h2>
		<strong><?php echo Yii::t('app', "En stock"); ?></strong>: <?php echo Yii::t('app', "Disponible à la livraison 7 à 10 jours après achat."); ?>
		<hr>
				
		
		
	</td>
	<td class="col-xs-2">
		<div class="input-group">
		     
		      <div class="input-group-btn">
		        
		        
		      </div><!-- /btn-group -->
		    </div><!-- /input-group -->
		</td>
	<td><h3><?php echo CHtml::encode($data->price_paid);?></h3></td>

</tr>
*/ ?>