<section class="slice color-one">
	<?php if ($show_title): ?>
	<div class="section-title color-three">
	        <h3><?php echo Yii::t("app", "Recommandations"); ?></h3>
	        <div class="indicator-down color-three"></div>
	    </div>
	
	<?php endif; ?>
    <div class="w-section inverse">
    	<div class="container">
			<div class="row">
				<div class="col-md-8">
				<?php
				$counter = 0;
				foreach ($items->products as $item):
					
					$product = Product::model()->findByPk($item);
					
					if (!$product || !$product->visible || $product->discontinued){
						continue;
					}
					
					$localization = $product->productLocalization;
					
					if ($localization === null){
						continue;
					}
					
					$product_url = $this->createUrl("product/view", array('slug'=>$localization->slug));
	
					$brand = $product->brand;
					$brand_localization = $brand->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
					$main_image = $localization->getMainImage();
					
				?>
				
	<div class="col-xs-12">
	                    <div class="aside-feature">
	                        <div class="row">
	                            <div class="col-md-2">
	                                <div class="img-feature">
	                                    <a href="<?php echo $product_url; ?>"><img src="<?php 
					
					if ($main_image){
						echo $main_image->getImageUrl(120, 120);
					} else {
						echo ProductImage::placehoderForSize(120, 120);
					}
						?>" class=" img-thumbnail center-block" alt=""></a>
	                                </div>
	                            </div>
	                            <div class="col-md-10">
									<p><a href="<?php echo $product_url; ?>" class="strong"><?php echo $localization->name; ?></a><span class="pull-right"><strong><i class="fa fa-star"></i> <?php echo Yii::t("app", "En vedette"); ?></strong></span></p>
	                                <p><?php echo substr(strip_tags($localization->short_description), 0, 120); ?>...
										<br><button class="btn btn-one btn-xs buybutton" data-product="<?php echo $product->id ?>"><i class="fa fa-shopping-cart"></i> <?php echo $product->getCurrentPrice(); ?> $</button></p>
									
	                            </div>
	                        </div>
	                    </div>
	                </div>
				
			<?php
			
			$counter++;
			
			if ($counter >= 4) {
				break;
			}
			
			 endforeach; ?>
		 </div> <!-- Col6 -->
		 <div class="col-md-4">
		 
         <div class="widget">
			<form class="form-inline" method="get" action="<?php echo $this->createUrl('product/search'); ?>">
                 <div class="input-group col-xs-12">
                     <input type="search" class="form-control" name="q" placeholder="<?php echo Yii::t("app", "Rechercher"); ?>" value="" autocomplete="off" spellcheck="false" />
                     <span class="input-group-btn">
                         <button class="btn btn-primary" type="submit"><span class="fa fa-search"><span class="sr-only"><?php echo Yii::t("app", "Rechercher"); ?></span></span></button>
                     </span>
                 </div>
             </form>
         </div>
		 
		 
		 <div class="widget">
		     <h4 class="widget-heading"><?php echo Yii::t("app","Accès rapide"); ?></h4>
		 	<ul class="categories highlight">
		 		<?php

		 		$counter = 0;
		 	foreach ($items->categories as $category_id){
		 		$category = Category::model()->findByPk($category_id);
		 		$localization = $category->localizationForLanguage(Yii::app()->language);
		 		if ($localization){
		 			echo '<li><a href="' . $this->createUrl('category/view', array('slug'=>$localization->slug)) . '">' . $localization->name . '</a></li>';
			
		 			$counter ++;
		 		}
		
		 		if ($counter>=8)
		 			break;
		 	}
	
		 	?>
		 	</ul>
		 </div>
		 
		 
		  </div> <!-- Col6 -->
	 </div><!-- row -->
	 
        </div>
 	</div>  
    
    
</section>