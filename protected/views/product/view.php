<?php
/* @var $this ProductController */
/* @var $model Product */



?>

<div class="col-lg-12 col-sm-12">
	<span class="title"><?php echo CHtml::encode($localization->name); ?></span>
</div>


<div class="row">

	<div class="col-md-7">
		
		
		<img src="<?php
		
		$image = $localization->getMainImage();
		
		echo $image->getImageURL(700,500);
		?>" class="img-responsive" alt="<?php echo $localization->name; ?>">
		
	</div>

	<div class="col-md-5  hero-feature">

		<h4><?php echo CHtml::encode($localization->name); ?></h4>
		<?php echo Yii::t("app", "Livré chez vous rapidement"); ?>
		<hr/>
		<p><?php echo strip_tags($localization->short_description); ?></p>
		
		<hr/>
		<h3>$<?php echo $model->price; ?></h3>
		
		<div class="input-qty-detail">
			<input type="text" class="form-control input-qty text-center" id="item_quantity" value="1">
					<?php 
					echo CHtml::ajaxButton(Yii::t("app", "Ajouter au panier"),CController::createUrl('cart/add'),array(
									'type'=>'POST',
									'data'=>array('product'=>$model->id, 'quantity'=>'js: $("#item_quantity").val()',
									'success'=>'js:function(data){
			window.location = "/panier.html";
			}',
									'async' => false,
									),
								), array("class"=>"btn btn-primary pull-left")); 
					?>
			
		</div>
		<br/>
		<hr/>
		
		<p class="small"><?php echo Yii::t("app", "Transaction sécurisée"); ?></p>

	</div>

</div>

<div class="row">
	
	<div class="col-md-9">
	
			<?php echo $localization->long_description; ?>
	
	</div>
	
	<div class="col-md-3">
	
			<h3><?php echo Yii::t("app", "Catégories"); ?></h3>
			<ul>
			<?php
			
			
			foreach ($localized_categories as $locat) {
				
				echo "<li>";
				echo CHtml::link(CHtml::encode($locat->name), array("category/view", "slug"=>$locat->slug));
				echo "</li>";
			}
			?>
			</ul>
	</div>
	
	
	
</div>