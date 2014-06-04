<?php
/* @var $this ProductController */
/* @var $data ProductLocalization */

$product = $data->product;

?>

<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
		<img src="<?php
		
		if ($data->image_id){
			$image = ProductImage::model()->findByPk($data->image_id);
			echo $image->getImageURL(300,200);
		} else {
			echo "//placehold.it/300x200";
		}
		
		?>" alt="...">
      <div class="caption">
        <h3><?php echo CHtml::link(CHtml::encode($data->name), array('view', 'slug'=>$data->slug)); ?></h3>
      </div>
    </div>
  </div>
