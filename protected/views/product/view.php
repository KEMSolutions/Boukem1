<?php
/* @var $this ProductController */
/* @var $model Product */



?>


<h1><?php echo $localization->name; ?></h1>

<div class="row">

	<div class="col-md-7">
		
		
		<img src="<?php
		
		$image = $localization->getMainImage();
		
		echo $image->getImageURL(700,500);
		?>" class="img-responsive" alt="<?php echo $localization->name; ?>">
		
	</div>

	<div class="col-md-5">

		<h2><?php echo $model->price; ?>$</h2>

		<p><?php echo $localization->short_description; ?></p>

		<p class="small"><?php echo Yii::t("app", "Livré chez vous rapidement"); ?></p>
		
		<?php 
		echo CHtml::ajaxButton(Yii::t("app", "Ajouter au panier"),CController::createUrl('cart/add'),array(
						'type'=>'POST',
						'data'=>array('product'=>$model->id, 'quantity'=>'1',
						'success'=>'js:function(data){
window.location = "/panier.html";
}',
						'async' => true,
						),
					), array("class"=>"btn btn-lg btn-primary")); 
		?>
		
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