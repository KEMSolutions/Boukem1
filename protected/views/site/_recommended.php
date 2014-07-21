<div class="col-md-8">
					
                	<div class="row">
                    	
                        
                        
                       

<?php foreach ($items as $item): 

$product = Product::model()->findByPk($item);
$localization = $product->localizationForLanguage(Yii::app()->language);
$product_url = $this->createUrl("Product/view", array('slug'=>$localization->slug));



if ($localization === null){
	continue;
}

$brand = $product->brand;
$brand_localization = $brand->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
$main_image = $localization->getMainImage();

?>	
                    	<div class="col-sm-6">
                        	<div class="w-box">
                                <figure>
                                    <a href="<?php echo $product_url; ?>">
										<img alt="" src="<?php 
												echo $main_image->getImageUrl(300, 280); ?>" alt="<?php echo $localization->name; ?>" class="img-responsive center-block hidden-xs hidden-sm">
										<img alt="" src="<?php 
														echo $main_image->getImageUrl(600, 560); ?>" alt="<?php echo $localization->name; ?>" class="img-responsive center-block visible-xs-block visible-sm-block">
									</a>
                                    <span class="date-over"><strong><?php echo CHtml::link($brand_localization->name, array('category/view', 'slug'=>$brand_localization->slug)); ?></strong></span>
                                    <h2><?php echo $localization->name; ?></h2>
                                    <p>
                                   <?php echo strip_tags(substr($localization->short_description, 0, 50)); ?>...
                                    </p>
                                    <span class="w-footer">
                                    	<span class="pull-left"><small><?php echo $product->price; ?> $</small></span>
                                        <button class="btn btn-xs btn-two pull-right buybutton" data-product="<?php echo $product->id ?>"><i class="fa fa-shopping-cart"></i> <?php echo Yii::t("app","Acheter");?></button>
                                        <span class="clearfix"></span>
                                    </span>
                                </figure>
                            </div>
                        </div>
						
    
	
<?php 
endforeach; ?>
                       
                    </div>
				</div>                