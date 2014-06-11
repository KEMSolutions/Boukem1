<?php
/* @var $this CartController
   @var $data OrderHasProduct
 */

$product = $data->product;
$localizationForProduct = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=true);

?>

<tr data-product="<?php echo $product->id; ?>">
	<td><img src="<?php
		
		$image = $localizationForProduct->getMainImage();
		
		echo $image ? $image->getImageURL(300,300) : ProductImage::placehoderForSize(300,300);
		?>" class="img-responsive"></td>
	<td><h2><?php echo CHtml::encode($localizationForProduct->name);?></h2>
		<small><?php echo Yii::t('app', "ID"); ?>: <?php echo CHtml::encode($product->id);?> <?php echo Yii::t('app', "SKU"); ?>: <?php echo CHtml::encode($product->sku);?></small><hr>
		<strong><?php echo Yii::t('app', "En stock"); ?></strong>: <?php echo Yii::t('app', "Disponible à la livraison 7 à 10 jours après achat."); ?>
		<hr>
				<?php 
				$cart_url = $this->createUrl('cart/index');
				echo CHtml::ajaxButton(Yii::t('app', 'Enlever du panier'),CController::createUrl('cart/remove'),array(
								'type'=>'POST',
								'data'=>array('product'=>$product->id,
								'success'=>'js:function(data){
		window.location = "' . $cart_url . '";
		}',
								'async' => true,
								),
							), array("class"=>"btn btn-danger btn-xs")); 
				?>
		
		
	</td>
	<td class="col-xs-2">
		<div class="input-group">
		      <input type="text" class="form-control quantity_field" value="<?php echo $data->quantity;?>">
		      <div class="input-group-btn">
		        <button type="button" class="btn btn-default update_cart_quantity" data-toggle="dropdown"><?php echo Yii::t('app', "Modifier"); ?></button>
		        
		      </div><!-- /btn-group -->
		    </div><!-- /input-group -->
		</td>
	<td><h3><?php echo CHtml::encode($data->price_paid);?></h3></td>

</tr>