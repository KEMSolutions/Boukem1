<?php
/* @var $this ProductController */
/* @var $data ProductLocalization */

$product = $data->product;

$product_link = $this->createUrl('view', array('slug'=>$data->slug));

?>

<div class="col-lg-3 col-sm-4 hero-feature text-center">
    <div class="thumbnail">
    	<a href="<?php echo $product_link; ?>" class="link-p">
        	<img src="<?php
		
		if ($data->image_id){
			$image = ProductImage::model()->findByPk($data->image_id);
			echo $image->getImageURL(280,280);
		} else {
			echo "//placehold.it/300x200";
		}
		
		?>" alt="">
    	</a>
        <div class="caption prod-caption">
            <h4><a href="<?php echo $product_link; ?>"><?php echo $data->name; ?></a></h4>
            <p>
            	<div class="btn-group">
                	<a href="<?php echo $product_link; ?>" class="btn btn-default">$ 122.51</a>
                	<a href="<?php echo $product_link; ?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> <?php echo Yii::t("app", "Acheter"); ?></a>
            	</div>
            </p>
        </div>
    </div>
</div>
