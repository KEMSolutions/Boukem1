<?php
/* @var $this ProductController */
/* @var $data ProductLocalization */

$product = Product::model()->findByPk($data->id);
$product_link = $this->createUrl('view', array('slug'=>$data->slug));



if ($product !== null):

?>


<div class="item col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <div class="w-box">
        <figure>
            <a href="<?php echo $product_link; ?>">
				<img alt="" src="<?php
	
	if ($data->image_id){
		$image = ProductImage::model()->findByPk($data->image_id);
		echo $image->getImageURL(300,280);
	} else {
		echo ProductImage::placehoderForSize(300,280);
	}
	
	?>" alt="<?php echo $data->name; ?>" class="img-responsive center-block hidden-xs hidden-sm">
				<img alt="" src="<?php 
				
				if ($data->image_id){
					$image = ProductImage::model()->findByPk($data->image_id);
					echo $image->getImageURL(600,560);
				} else {
					echo ProductImage::placehoderForSize(600,560);
				}
				
				?>" alt="<?php echo $data->name; ?>" class="img-responsive center-block visible-xs-block visible-sm-block">
						</a>
            <?php
			if ($data->brand_name):
            ?><span class="date-over"><strong><?php echo CHtml::link($data->brand_name, $product_link); ?></strong></span>
		<?php endif; ?>
			<h2><a href="<?php echo $product_link; ?>"><?php echo $data->name; ?></a></h2>
            <p>
           <?php echo strip_tags(substr($data->short_description, 0, 120)); ?>...
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