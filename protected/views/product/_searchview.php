<?php
/* @var $this ProductController */
/* @var $data ProductLocalization */

$product = Product::model()->findByPk($data->id);
$localization = $product ? $product->localizationForLanguage(Yii::app()->language) : null;

if ($product && $localization):
	
	$product_link = $this->createUrl('view', array('slug'=>$localization->slug));
	
?>


<div class="item col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <div class="w-box">
        <figure>
            <a href="<?php echo $product_link; ?>">
				<img alt="" src="<?php
	
	$mainImage = $localization->getMainImage();
 
	if ($mainImage){
		echo $mainImage->getImageURL(300,280);
	} else {
		echo ProductImage::placehoderForSize(300,280);
	}
	
	?>" alt="<?php echo $localization->name; ?>" class="img-responsive center-block hidden-xs hidden-sm">
				<img alt="" src="<?php 
				
				if ($mainImage){
					echo $mainImage->getImageURL(600,560);
				} else {
					echo ProductImage::placehoderForSize(600,560);
				}
				
				?>" alt="<?php echo $localization->name; ?>" class="img-responsive center-block visible-xs-block visible-sm-block">
						</a>
            <?php
			$brand = $product->brand;
			if ($brand):
            ?><span class="date-over"><strong><?php 
			$brand_localization = $brand->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
			echo CHtml::link($brand_localization->name, $this->createUrl("category/view", array("slug"=>$brand_localization->slug))); ?></strong></span>
		<?php endif; ?>
			<h2><a href="<?php echo $product_link ?>"><?php echo $localization->name; ?></a></h2>
            <p>
           <?php echo strip_tags(substr($localization->short_description, 0, 120)); ?>...
            </p>
            
            <span class="w-footer">
                <span class="pull-left"><small><?php echo $product->getCurrentPrice(); ?> $</small></span>
				<button class="btn btn-xs btn-two pull-right buybutton" data-product="<?php echo $product->id ?>"><i class="fa fa-shopping-cart"></i> <?php echo Yii::t("app","Acheter");?></button>
                <span class="clearfix"></span>
            </span>
        </figure>
    </div>
</div>
<?php
 endif; ?>