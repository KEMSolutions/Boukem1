<?php $base_static_url = "//cdn.kem.guru/ptrslider"; ?>
<section class="slider-wrapper">
    <div class="responsive-container">
        <div class="slider">
        	<div class="fs_loader"></div>
           
		   <?php foreach ($items as $item): ?> 
           
		  <?php if ($item->type === "brand"): 
			   
			   $brand = Category::model()->findByPk($item->brand_id);
			   $brand_localization = $brand->localizationForLanguage(Yii::app()->language);
			   
			   if ($brand_localization === null){
				   continue;
			   }
			   
			   ?>
			<div class="slide">
                <img src="<?php echo $base_static_url . $item->background_img; ?>" alt="" height="440" data-position="0,-460" data-in="bottom" data-delay="200" data-out="top">
                <img src="<?php echo $base_static_url . $item->display_image; ?>" alt="" data-position="30, -30" data-in="top" data-delay="200" data-out="bottom">
                
                <p class="claim color-one" data-position="70,520" data-in="top" data-step="1" data-out="bottom" data-delay="50">
                	<?php echo CHtml::encode($item->major_title); ?>
                </p>
        		<p class="teaser color-two-d" data-position="130,520" data-in="top" data-step="1" data-out="bottom" data-delay="100">
                	<?php echo CHtml::encode($item->minor_title); ?>
                </p>		
        		<p class="text small <?php if ($item->description_color === "light") {echo 'white';} else {echo 'black'; }?>" data-position="180,520" data-in="top" data-step="1" data-out="bottom" data-delay="150">
               		<?php echo CHtml::encode($item->description); ?>
                    <br>
                    <a href="<?php echo $this->createUrl('category/view', array('slug'=>$brand_localization->slug)); ?>" class="btn btn-one"><?php echo CHtml::encode($item->link_title); ?></a>
                </p>
            </div>
			
		<?php endif; // BRAND ?>
		
		
		   <?php if ($item->type === "category"):
			   $category = Category::model()->findByPk($item->category_id);
			   $category_localization = $category->localizationForLanguage(Yii::app()->language);
			   
			   if ($category_localization === null){
				   continue;
			   }
			?>
			<div class="slide">
                <img src="<?php echo $base_static_url . $item->background_img; ?>" alt="" height="440" data-position="0,-460" data-in="bottom" data-delay="200" data-out="top">
                
                <p class="claim color-one" data-position="70,0" data-in="top" data-step="1" data-out="bottom" data-delay="50">
                	<?php echo CHtml::encode($item->major_title); ?>
                </p>
        		<p class="teaser color-two-d" data-position="130,0" data-in="top" data-step="1" data-out="bottom" data-delay="100">
                	<?php echo CHtml::encode($item->minor_title); ?>
                </p>
				
        		<p class="text small  <?php if ($item->description_color === "light") {echo 'white';} else {echo 'black'; }?>" data-position="180,0" data-in="top" data-step="1" data-out="bottom" data-delay="150">
					<?php echo CHtml::encode($item->description); ?>
                    <br>
                    <a href="<?php echo $this->createUrl('category/view', array('slug'=>$category_localization->slug)); ?>" class="btn btn-one"><?php echo CHtml::encode($item->link_title); ?></a>
                </p>
            </div>
			
		<?php endif; // category ?>
		
		
		  <?php if ($item->type === "product_one"): 
			   
			   $product = Product::model()->findByPk($item->product_id);
			   $product_localization = $product->localizationForLanguage(Yii::app()->language);
			   
			   if ($product_localization === null){
				   continue;
			   }
			   
			   ?>
			<div class="slide">
                <img src="<?php echo $base_static_url . $item->background_img; ?>" alt="" height="440" data-position="0,-460" data-in="bottom" data-delay="200" data-out="top">
                <img src="<?php echo $base_static_url . $item->display_image; ?>" alt="" data-position="<?php echo $item->display_image_y; ?>, <?php echo $item->display_image_x; ?>" data-in="top" data-delay="200" data-out="bottom">
                
                <p class="claim color-one" data-position="70,520" data-in="top" data-step="1" data-out="bottom" data-delay="50">
                	<?php echo CHtml::encode($item->major_title); ?>
                </p>
        		<p class="teaser color-two-d" data-position="130,520" data-in="top" data-step="1" data-out="bottom" data-delay="100">
                	<?php echo CHtml::encode($item->minor_title); ?>
                </p>		
        		<p class="text small <?php if ($item->description_color === "light") {echo 'white';} else {echo 'black'; }?>" data-position="180,520" data-in="top" data-step="1" data-out="bottom" data-delay="150">
               		<?php echo CHtml::encode($item->description); ?>
                    <br>
                    <a href="<?php echo $this->createUrl('product/view', array('slug'=>$product_localization->slug)); ?>" class="btn btn-one"><?php echo CHtml::encode($item->link_title); ?></a>
                </p>
            </div>
			
		<?php endif; // PRODUCT_ONE ?>
		
            
		<?php endforeach; ?>
			
        </div>
    </div>
</section>