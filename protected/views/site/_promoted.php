	<?php
	
	$counter = 0;
	 foreach ($items as $item): 

	$product = Product::model()->findByPk($item);
	$localization = $product->localizationForLanguage(Yii::app()->language);
	$product_url = $this->createUrl("Product/view", array('slug'=>$localization->slug));
	
	if ($localization):
	?>	
		<!-- Product Selection, visible only on large desktop -->
	   <div class='col-lg-4 col-sm-4 hero-feature text-center'>
	                <div class="thumbnail">
	                	<a href="<?php echo $product_url; ?>" class="link-p first-p">
	                    	<img src="<?php 
							$main_image = $localization->getMainImage();
							echo $main_image->getImageUrl(300, 280); ?>" alt="<?php echo $localization->name; ?>">
	                    </a>
	                    <div class="caption prod-caption">
	                        <h4><a href="<?php echo $product_url; ?>"><?php echo $localization->name; ?></a></h4>
	                        <p><?php echo strip_tags(substr($localization->short_description, 0, 120)); ?>...</p>
	                        <p>
	                        	<div class="btn-group">
		                        	<a href="<?php echo $product_url; ?>" class="btn btn-default">$ <?php echo $product->price; ?></a>
		                        	<button class="btn btn-primary buybutton" data-product="<?php echo $product->id ?>"><i class="fa fa-shopping-cart"></i> <?php echo Yii::t("app","Acheter");?></button>
	                        	</div>
	                        </p>
	                    </div>
	                </div>
	            </div>
	      
	    <!-- End Product Selection -->
	
	<?php 
	
	if ($counter === 2){
		break;
	}
	$counter++;
endif;
	endforeach; ?>