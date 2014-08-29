<?php $base_static_url = "//cdn.kem.guru/ptrslider"; ?>
<section class="slider-wrapper">
    <div class="responsive-container">
        <div class="slider">
        	<div class="fs_loader"></div>
           
		   <?php foreach ($items as $item):
			   
			   $delay = 100;
			    ?> 
			   
			   
			   
        
        	
              <div class="slide">
				  <?php if (isset($item->background)): ?>
					  
					  <?php if (isset($item->link)): ?>
					  <a href="<?php echo $item->link; ?>">
				  <?php endif; ?>
					  
                   <img src="https://cdn.kem.guru/<?php echo $item->background; ?>" alt="" height="440" data-position="0,-460" data-in="bottom" data-delay="<?php echo $delay; ?>" data-out="top">
				   
 					  <?php if (isset($item->link)): ?>
				  </a>
 				  <?php endif; ?>
				   
			   <?php endif; ?>
                
   				<?php if (isset($item->images)):
				 foreach ($item->images as $image): ?>
   					<img src="https://cdn.kem.guru/<?php echo $image->name; ?>" alt="" data-position="<?php echo $image->position_x; ?>,<?php echo $image->position_y; ?>" data-in="top" data-delay="<?php echo $delay; ?>" data-out="bottom">
                   <?php
				   $delay += 10;
			   	    endforeach;
					endif; ?>
				
   				<?php if (isset($item->titles)):
					 foreach ($item->titles as $title): ?>
   	                <p class="<?php 
   					if ($title->type === "h1"){
   						echo "claim color-one";
   					} else if ($title->type === "h2") {
   						echo "teaser color-two-d";	
   					} else if ($title->type === "h3") {
   						echo "teaser color-two-l small";
   					} ?>" data-position="<?php echo $title->position_x; ?>,<?php echo $title->position_y; ?>" data-in="top" data-step="1" data-out="bottom" data-delay="<?php echo $delay; ?>"><?php echo $title->name; ?>
   	                </p>
                   <?php
				    $delay += 10;
				 endforeach;
			   endif; ?>
				
   				<?php if (isset($item->textboxes)):
				 foreach ($item->textboxes as $textbox): ?>
   	        		<p class="text small <?php 
   					if ($textbox->color === "light"){
   						echo "white";
   					} else if ($textbox->color === "dark") {
   						echo "black";	
   					} ?>" data-position="<?php echo $textbox->position_x; ?>,<?php echo $textbox->position_y; ?>" data-in="top" data-step="1" data-out="bottom" data-delay="<?php echo $delay; ?>"><?php echo $textbox->box_content; ?>
   	                </p>
                   <?php endforeach;
			   endif; ?>
				
   				<?php if (isset($item->links)):
					 foreach ($item->links as $link): ?>
   	        		<p class="text small <?php 
   					if ($textbox->color === "light"){
   						echo "white";
   					} else if ($textbox->color === "dark") {
   						echo "black";	
   					} ?>" data-position="<?php echo $link->position_x; ?>,<?php echo $link->position_y; ?>" data-in="top" data-step="1" data-out="bottom" data-delay="<?php echo $delay; ?>"><?php echo $link->name; ?>
   	                </p>
                   <?php endforeach; ?>
                
   			<?php foreach ($item->links as $link):
				
				$store_link = "#";
				
				if (isset($link->to) && $link->to === "product"){
					
					$product = Product::model()->findByPk($link->href);
					if ($product){
						$localization = $product->localizationForLanguage(Yii::app()->language);
						if ($localization){
							$store_link = $this->createUrl('product/view', array("slug"=>$localization->slug));
						}
					} 
					
				}
				
   				?>
				
   				<?php if ($link->type === "button"): ?>
   				<a href="<?php echo $store_link; ?>" class="btn btn-one" data-position="<?php echo $link->position_x; ?>,<?php echo $link->position_y; ?>" data-in="top" data-step="1" data-out="bottom" data-delay="<?php echo $delay; ?>"><?php echo $link->name; ?></a>
   			<?php elseif ($link->type === "text"): ?>
   				<a href="<?php echo $store_link; ?>" data-position="<?php echo $link->position_x; ?>,<?php echo $link->position_y; ?>" data-in="top" data-step="1" data-out="bottom" data-delay="<?php echo $delay; ?>"><?php echo $link->name; ?></a>
   			<?php elseif ($link->type === "area"): ?>
   				<a href="<?php echo $store_link; ?>" class="btn btn-one" data-position="<?php echo $link->position_x; ?>,<?php echo $link->position_y; ?>" data-in="top" data-step="1" data-out="bottom" data-delay="<?php echo $delay; ?>" style="opacity:0;"><?php echo $link->name; ?></a>
   			<?php endif; ?>
				
   			<?php endforeach;
		endif; ?>
			
               </div>
            
            
		<?php endforeach; ?>
			
        </div>
    </div>
</section>