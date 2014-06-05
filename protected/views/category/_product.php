<?php
/**
 * @var $data Product
 */
?>

 <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="<?php
	  $mainImage = $data->productLocalization->getMainImage();
	   echo $mainImage ? $mainImage->getImageUrl(300,200) : "//placehold.it/300x200"; ?>" alt="<?php echo $data->productLocalization->name;?>">
      <div class="caption">
        <h3><?php echo $data->productLocalization->name;?></h3>
        <p><?php echo $data->productLocalization->short_description;?></p>
        <p><a href="<?php echo $this->createUrl('product/view', array('slug'=>$data->productLocalization->slug)); ?>" class="btn btn-primary" role="button"><?php echo Yii::t('app', "Plus de détails..."); ?></a></p>
      </div>
    </div>
  </div>
 