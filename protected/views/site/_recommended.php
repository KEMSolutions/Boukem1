<?php foreach ($items as $item): 

$product = Product::model()->findByPk($item);
$localization = $product->localizationForLanguage(Yii::app()->language);
$product_url = $this->createUrl("Product/view", array('slug'=>$localization->slug));
if ($localization):
?>	
	<!-- Product Selection, visible only on large desktop -->
    <div class="col-lg-3 visible-lg">
        <div class="row text-center">
            <div class="col-lg-12 col-md-12 hero-feature">
                <div class="thumbnail">
                	<a href="<?php echo $product_url; ?>" class="link-p first-p">
                    	<img src="<?php 
						$main_image = $localization->getMainImage();
						echo $main_image->getImageUrl(300, 280); ?>" alt="<?php echo $localization->name; ?>">
                    </a>
                    <div class="caption prod-caption">
                        <h4><a href="<?php echo $product_url; ?>"><?php echo $localization->name; ?></a></h4>
                        <p><?php echo strip_tags(substr($localization->short_description, 0, 80)); ?>...</p>
                        <p>
                        	<div class="btn-group">
	                        	<a href="<?php echo $product_url; ?>" class="btn btn-default">$ <?php echo $product->price; ?></a>
	                        	<button class="btn btn-primary buybutton" data-product="<?php echo $product->id ?>"><i class="fa fa-shopping-cart"></i> <?php echo Yii::t("app","Acheter");?></button>
                        	</div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Product Selection -->
	
<?php 
break; // We only want one product on boukem's default template
endif;
endforeach; ?>