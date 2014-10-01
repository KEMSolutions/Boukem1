<?php

/////// TEMPORARY AB TESTING CODE

/*
To AB test the new product card, we'll set a cookie for the user with a card type ('h' for Robert's new card, or 'v' for Remy's updated old card). If the user has no cookie yet, we'll need to create one.
On click on a button, we'll record an event in Google Analytics using GAE analytics.js with special button identifiers.
*/


// Cookie selection
$cookie_name = "boukemspirit_abtestproductcard_201409";
if (isset(Yii::app()->request->cookies[$cookie_name])){
	// Retrieve the cookie's value
	$card_type = (string)Yii::app()->request->cookies[$cookie_name];
	
} else {
	
	if (rand(0, 1)) {
		$card_type = "h";
	} else {
		$card_type = "v";
	}
	
	// Set the cookie
	$cookie = new CHttpCookie($cookie_name, $card_type);
	$cookie->expire = time()+60*60*24*30; // one month 
	Yii::app()->request->cookies[$cookie_name] = $cookie;
	
}


// TYPE H ////////////////////////////
if ($card_type === "h"):

	if (!isset($localization)){
		$localization = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
	}
	
	if ($localization):
	
		$product_url = $this->createUrl("product/view", array('slug'=>$localization->slug));
	
		$brand = $product->brand;
		$brand_localization = $brand->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
		$main_image = $localization->getMainImage();
	
							 ?>

<div class="item <?php 
if (isset($style) && $style === "narrow"){
	echo "col-lg-4 col-md-4 col-sm-6 col-xs-6";
} else if (isset($style) && $style === "large"){
	echo "col-lg-6 col-md-6 col-sm-12";
} else {
	echo "col-lg-3 col-md-4 col-sm-6";
}
?>">
    <div class="w-box">
        <figure>
            <a href="<?php echo $product_url; ?>">
                <img alt="" src="<?php 

				if ($main_image){
					echo $main_image->getImageUrl(300, 280);
				} else {
					echo ProductImage::placehoderForSize(300, 280);
				}
		        ?>" alt="<?php echo $localization->name; ?>" class="img-responsive center-block hidden-xs hidden-sm">
                     
                <img alt="" src="<?php 

				if ($main_image){
					echo $main_image->getImageUrl(600, 560);
				} else {
					echo ProductImage::placehoderForSize(600, 560);
				}
				?>" alt="<?php echo $localization->name; ?>" class="img-responsive center-block visible-xs-block visible-sm-block">
            </a>
        
            <hr/>
            
             <h2>
                 <a href="<?php echo $product_url; ?>" class="product-title">
                     <?php echo $localization->name; ?>
                 </a>
            </h2>
            
            <p class="product-manufacturer"> <?php echo Yii::t("app", "de"); ?> <?php echo CHtml::link($brand_localization->name, array('category/view', 'slug'=>$brand_localization->slug)); ?>
            </p>
            
            <h1 class="price"><?php echo $product->getCurrentPrice(); ?> $<?php

                if ($product->getCurrentPrice() != $product->price) {
                	echo "<br><small>" . Yii::t("app", "Prix régulier:") . " <span class='regularprice'>" . $product->price . "</span></small>";
                }

          		?>
			</h1>
            
            <p class="description">
                <?php echo substr(strip_tags($localization->short_description), 0, 120); ?>...
            </p>
            
            <button type="button" class="button-buy btn-success buybutton" data-abid="h" data-product="<?php echo $product->id ?>">
                <i class="fa fa-shopping-cart"></i> 
                <?php echo Yii::t("app","Acheter");?> 
            </button>
        
        </figure>
        
    </div>
</div>
<?php endif;

// TYPE H ENDS ////////////////////////////
else:
// TYPE V ////////////////////////////
	// Cookie is set to remy's 
	
	if (isset($localization)){
		$localization = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
	}
	
	if ($localization):
	
		$product_url = $this->createUrl("product/view", array('slug'=>$localization->slug));
	
		$brand = $product->brand;
		$brand_localization = $brand->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
		$main_image = $localization->getMainImage();
	
	
	 ?>
	 
	
	<div class="item <?php 
if (isset($style) && $style === "narrow"){
	echo "col-lg-4 col-md-4 col-sm-6 col-xs-6";
} else if (isset($style) && $style === "large"){
	echo "col-lg-6 col-md-6 col-sm-12";
} else {
	echo "col-lg-3 col-md-4 col-sm-6";
}
?>">
        <div class="w-box">
            <figure>
                <a href="<?php echo $product_url; ?>">
					<img alt="" src="<?php 

					if ($main_image){
						echo $main_image->getImageUrl(300, 280);
					} else {
						echo ProductImage::placehoderForSize(300, 280);
					}
						?>" alt="<?php echo $localization->name; ?>" class="img-responsive center-block hidden-xs hidden-sm">
					<img alt="" src="<?php 

					if ($main_image){
						echo $main_image->getImageUrl(600, 560);
					} else {
						echo ProductImage::placehoderForSize(600, 560);
					}
					?>" alt="<?php echo $localization->name; ?>" class="img-responsive center-block visible-xs-block visible-sm-block">
					</a>
                <span class="date-over"><strong><?php echo CHtml::link($brand_localization->name, array('category/view', 'slug'=>$brand_localization->slug)); ?></strong></span>
                <h2><a href="<?php echo $product_url; ?>"><?php
					
					$title_lines = explode(" - ", $localization->name);
					$counter = 0;
					$number_of_lines = count($title_lines);
					 foreach ($title_lines as $line){
						 if ($counter != 0 && $counter <= $number_of_lines){
							 // Not first line
							 echo "<br>";
						 }
						 
						 if ($counter != 0 && $counter+1 == $number_of_lines){
							 // Last but also not first line
							 echo "<small>" . $line . "</small>";
						 } else {
							 echo $line;
						 }
						
						 $counter++;
					 }
					 
					 
					  ?></a></h2>
                <p>
               <?php echo substr(strip_tags($localization->short_description), 0, 120); ?>...
                </p>
                

                <span class="w-footer">
                    <div class="pull-left"><?php

                if ($product->getCurrentPrice() != $product->price) {
                	echo Yii::t("app", "Prix régulier:") . " <span class='regularprice'>" . $product->price . "</span><br>";
                }

          		?><strong class="pricetag"><?php echo $product->getCurrentPrice(); ?> $</strong></div>
					<button class="btn btn-success pull-right buybutton" data-product="<?php echo $product->id ?>" data-abid="v"><i class="fa fa-shopping-cart"></i> <?php echo Yii::t("app","Acheter");?></button>
                    <span class="clearfix"></span>
                </span>
            </figure>
        </div>
    </div>
	 
	 
	 
	 
<?php

endif;
// TYPE V ENDS ////////////////////////////

 endif;
 //BETA TEST ENDS ?>