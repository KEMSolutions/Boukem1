
		<?php $this->renderPartial('_slider', array("items"=>$items->slider)); ?>

<div class="container">
	<div class="row">
	<?php $this->renderPartial('_recommended', array("items"=>$items->recommended)); ?>
		</div>
	
<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-12">

		<!-- Categories -->
		<div class="col-lg-12 col-md-12 col-sm-6">
			<div class="no-padding">
				<span class="title"><?php echo Yii::t("app","Catégories"); ?></span>
			</div>
			<div class="list-group list-categ">
				
					<?php $this->renderPartial('_highlighted_categories', array("items"=>$items->highlighted_categories)); ?>		
						
			</div>
		</div>
		<!-- End Categories -->

					
		<!-- End Best Seller -->

	</div>

	<div class="clearfix visible-sm"></div>
				
	<!-- Featured -->
	<div class="col-lg-9 col-md-9 col-sm-12">
		<div class="col-lg-12 col-sm-12">
			<span class="title"><?php echo Yii::t("app","En vedette"); ?></span>
		</div>
		
		<?php $this->renderPartial('_promoted', array("items"=>$items->promoted)); ?>			
		            
		            
	</div>
	<!-- End Featured -->
</div>
</div>
	