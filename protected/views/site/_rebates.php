<section class="slice color-one">
    <div class="w-section inverse">
    	<div class="container">
				<?php
					
				$rebates_array = $items->getData();
				shuffle($rebates_array);
				
				$counter = 0;
				
				foreach ($rebates_array as $rebate):
					
					$product = $rebate->product;
					$localization = $product->productLocalization;
					
					if ($localization === null){
						continue;
					}
					
					$product_url = $this->createUrl("product/view", array('slug'=>$localization->slug));
	
					$brand = $product->brand;
					$brand_localization = $brand->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
					$main_image = $localization->getMainImage();
					
					if ($counter % 2 == 0) {
						// It an even number, print the beggining of a row
						echo "<div class='row'>";
					}
					
					
				?>
				
				
	<div class="col-md-6">
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
									<p><a href="<?php echo $product_url; ?>" class="strong"><?php echo $localization->name; ?></a><span class="pull-right"><small><?php echo $product->getCurrentPrice(); ?> $</small></span></p>
	                                <p><i class="fa fa-quote-left"></i> <?php echo strip_tags(substr($localization->short_description, 0, 120)); ?>...
										<br><button class="btn btn-xs btn-primary buybutton" data-product="<?php echo $product->id ?>"><i class="fa fa-shopping-cart"></i> <?php echo Yii::t("app","Acheter");?></button></p>
									
	                            </div>
	                        </div>
	                    </div>
	                </div>
	
				
				
			<?php
			
			
			if ($counter % 2 != 0) {
				// It an odd number, print the end of a row
				echo "</div>";
			}
			
			$counter++;
			
			if ($counter >= 4) {
				break;
			}
			
			 endforeach; ?>

        </div>
 	</div>  
    
    <div class="section-title color-three">
        <h3><?php echo Yii::t("app", "En vedette"); ?></h3>
        <div class="indicator-down color-three"></div>
    </div>
    
</section>



	