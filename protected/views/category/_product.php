<?php
/**
 * @var $data Product
 */
$product_url = $this->createUrl('product/view', array('slug'=>$data->productLocalization->slug));
?>

<div class="col-lg-4 col-sm-4 hero-feature text-center">
    <div class="thumbnail">
    	<a href="<?php echo $product_url; ?>" class="link-p">
        	<img src="<?php
	  $mainImage = $data->productLocalization->getMainImage();
	   echo $mainImage ? $mainImage->getImageUrl(280,280) : ProductImage::placehoderForSize(280,280); ?>" alt="<?php echo $data->productLocalization->name;?>" alt="<?php echo $data->productLocalization->name;?>">
    	</a>
        <div class="caption prod-caption">
            <h4><a href="<?php echo $product_url; ?>"><?php echo $data->productLocalization->name;?></a></h4>
            
            <p>
            	<div class="btn-group">
                	<a href="<?php echo $product_url; ?>" class="btn btn-default">$ <?php echo $data->price;?></a>
                	<button class="btn btn-primary buybutton" data-product="<?php echo $data->id; ?>"><i class="fa fa-shopping-cart"></i> <?php echo Yii::t("app", "Acheter");?></button>
            	</div>
            </p>
        </div>
    </div>
</div>
