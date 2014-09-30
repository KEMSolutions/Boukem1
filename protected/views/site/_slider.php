<?php $base_static_url = "//cdn.kem.guru/ptrslider"; ?>
<section class="slider-wrapper">
    <div class="responsive-container">
        <div class="slider">
        	<div class="fs_loader"></div>
           
		   <?php foreach ($items as $content): ?>
			   
           <div class="slide">
			   <?php if (isset($content->background) && $content->background !== "") : ?>
                <img src="https://cdn.kem.guru/<?php echo $content->background; ?>" alt="" height="440" data-position="0,-460" data-in="<?php echo isset($content->data_in) ? $content->data_in : "none"; ?>" data-delay="<?php echo isset($content->data_delay) ? $content->data_delay : "0"; ?>" data-out="<?php echo isset($content->data_out) ? $content->data_out : "none"; ?>">
			<?php endif; ?>
				
				<?php foreach ($content->images as $element): ?>
					<?php if (isset($element->name) && isset($element->position_x) && isset($element->position_y)): ?>
					<img src="https://cdn.kem.guru/<?php echo $element->name; ?>" alt="<?php echo isset($element->alt) ? $element->alt : ""; ?>" data-position="<?php echo $element->position_y; ?>,<?php echo $element->position_x; ?>" data-in="<?php echo isset($element->data_in) ? $element->data_in : "none"; ?>" data-delay="<?php echo isset($element->data_delay) ? $element->data_delay : "0"; ?>" data-out="<?php echo isset($element->data_out) ? $element->data_out : "none"; ?>"<?php if (isset($element->data_fixed) && $element->data_fixed) {echo " data-fixed";} ?> data-step="<?php echo isset($element->data_step) ? $element->data_step : "0"; ?>"<?php if (isset($element->data_special) && $element->data_special === "cycle") {echo " data-special='cycle'"; } ?>>
				<?php endif; ?>
                <?php endforeach; ?>
				
				<?php foreach ($content->textboxes as $element): ?>
					<?php if (isset($element->name) && isset($element->position_x) && isset($element->position_y)): ?>
	                <p class="<?php 
					if ($element->type === "h1"){
						echo "claim color-one";
					} else if ($element->type === "h2") {
						echo "teaser color-two-d";	
					} else if ($element->type === "h3") {
						echo "teaser color-two-l small";
					} else if ($element->type === "small_light") {
						echo "text small white";
					} else if ($element->type === "small_dark") {
						echo "text small black";
					} else if ($element->type === "large_light") {
						echo "white";
					} else if ($element->type === "large_dark") {
						echo "black";
					} ?>" data-position="<?php echo $element->position_y; ?>,<?php echo $element->position_x; ?>" data-in="<?php echo isset($element->data_in) ? $element->data_in : "none"; ?>" data-delay="<?php echo isset($element->data_delay) ? $element->data_delay : "0"; ?>" data-out="<?php echo isset($element->data_out) ? $element->data_out : "none"; ?>"<?php if (isset($element->data_fixed) && $element->data_fixed) {echo " data-fixed";} ?> data-step="<?php echo isset($element->data_step) ? $element->data_step : "0"; ?>"<?php if (isset($element->data_special) && $element->data_special === "cycle") {echo " data-special='cycle'"; } ?>><?php echo $element->name; ?></p>
					<?php endif; ?>
                <?php endforeach; ?>
				
                
			<?php foreach ($content->links as $element):
				
				$store_link = "#";
				
				if (isset($element->to) && $element->to === "product"){
					
					$product = Product::model()->findByPk($element->href);
					if ($product){
						$localization = $product->localizationForLanguage(Yii::app()->language);
						if ($localization){
							$store_link = $this->createUrl('product/view', array("slug"=>$localization->slug));
						}
					}
					
				} else if (isset($element->to) && $element->to === "category"){
					
					$category = Category::model()->findByPk($element->href);
					if ($category){
						$localization = $category->localizationForLanguage(Yii::app()->language);
						if ($localization){
							$store_link = $this->createUrl('category/view', array("slug"=>$localization->slug));
						}
					}
					
				}  else if (isset($element->to) && $element->to === "external"){
					
					$store_link = $element->href;
					
				}
				
				
				if ($store_link):
				?>
				
				<a href="<?php echo $store_link; ?>" class="<?php
					if (isset($element->type) && $element->type === "button_light"){
						echo "btn btn-one";
					} else if (isset($element->type) && $element->type === "button_dark"){
						echo "btn btn-two";
					} else if (isset($element->type) && $element->type === "button_primary_large"){
						echo "btn btn-primary btn-lg";
					} else if (isset($element->type) && $element->type === "button_primary_small"){
						echo "btn btn-primary btn-xs";
					} else if (isset($element->type) && $element->type === "button_default_large"){
						echo "btn btn-default btn-lg";
					} else if (isset($element->type) && $element->type === "button_default_small"){
						echo "btn btn-default btn-xs";
					} else if (isset($element->type) && $element->type === "button_success_large"){
						echo "btn btn-success btn-lg";
					} else if (isset($element->type) && $element->type === "button_success_small"){
						echo "btn btn-success btn-xs";
					} else if (isset($element->type) && $element->type === "text"){
						echo "";
					} ?>"  data-position="<?php echo $element->position_y; ?>,<?php echo $element->position_x; ?>" data-in="<?php echo isset($element->data_in) ? $element->data_in : "none"; ?>" data-delay="<?php echo isset($element->data_delay) ? $element->data_delay : "0"; ?>" data-out="<?php echo isset($element->data_out) ? $element->data_out : "none"; ?>"<?php if (isset($element->data_fixed) && $element->data_fixed) {echo " data-fixed";} ?> data-step="<?php echo isset($element->data_step) ? $element->data_step : "0"; ?>"<?php if (isset($element->data_special) && $element->data_special === "cycle") {echo " data-special='cycle'"; } ?>><?php echo $element->name; ?></a>

			<?php endif; ?>
			<?php endforeach; ?>
			
            </div>
			
		<?php endforeach; ?>
			
			
			
			
			
        </div>
    </div>
	
	
</section>