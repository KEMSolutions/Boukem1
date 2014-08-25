<?php
/* @var $this ProductController */
/* @var $model Product */

$this->pageTitle = $localization->name;

$regular_price = $model->price;
$current_price = $model->getCurrentPrice();


if ($regular_price !== $current_price){
	$on_sale = true;
} else {
	$on_sale = false;
} 
	

?>


<section class="slice animate-hover-slide"  itemscope itemtype="http://schema.org/Product">
	<div class="w-section inverse blog-grid">
    	<div class="container">
        	<div class="row">
                <div class="col-sm-8">
                	<div class="row">
                    	<div class="col-md-12">
                        	<div class="w-box blog-post">
                                <figure>
                                    <img alt=""  itemprop="image" src="<?php
		
		$image = $localization->getMainImage();
		
		echo $image ? $image->getImageURL(700,500) : ProductImage::placehoderForSize(700,500);
		
		
		?>" class="img-responsive center-block">
                                    <ul class="meta-list">
                                        <?php if ($model->sku): ?>
										<li>
                                            <span>SKU</span>
                                            <span class="bold" itemprop="sku"><?php echo $model->sku; ?></span>
                                        </li>
										<?php endif; ?>
										
                                        <?php if ($model->barcode): ?>
										<li>
                                            <span><?php echo Yii::t("app", "CUP/EAN"); ?></span>
                                            <span class="bold" itemprop="gtin13"><?php echo $model->barcode; ?></span>
                                        </li>
										<?php endif; ?>
                                        
                                    </ul>
                                    <?php echo $localization->long_description; ?>
                                </figure>
                            </div>
                            
                            
                            
                        </div>
                    </div>

                </div>
                                        
                <div class="col-sm-4">
                    
                    <div class="widget pricing-plans" id="product_info_box" data-product="<?php echo $model->id; ?>">
	                    <div class="w-box popular">
	                        <h2 class="plan-title" itemprop="name"><?php echo CHtml::encode($localization->name); ?></h2>
	                        <span itemscope itemtype="http://schema.org/Offer"><h3 class="price-tag color-one" itemprop="price"><span>$</span><?php echo $current_price; ?></h3></span>
	                        <ul>
								<?php if ($on_sale || $this->isB2b()): ?>
								<li class="text-success"><i class="fa fa-smile-o"></i> <?php echo Yii::t("app", "Prix régulier:") . " $" . $regular_price; ?></li>
								<?php endif; ?>
	                            <li><i class="fa fa-truck"></i> <?php echo Yii::t("app", "Livré chez vous rapidement"); ?></li>
	                            <li><i class="fa fa-lock"></i> <?php echo Yii::t("app", "Transaction sécurisée"); ?></li>
	                        </ul>          
	                        <p class="plan-info" itemprop="description"><?php echo strip_tags($localization->short_description); ?></p>
	                        <p class="plan-select text-center">
								<div class="input-qty-detail form-inline text-center">
									<div class="form-group">
									    <input type="text" class="form-control input-qty text-center" id="item_quantity" value="1">
									  </div>
									  
									<button class="btn btn-three buybutton visible-lg-inline" data-product="<?php echo $model->id; ?>"><i class="fa fa-check-circle"></i>  <?php echo Yii::t("app", "Ajouter au panier"); ?></button>
									<button class="btn btn-block btn-three center-block buybutton hidden-lg" data-product="<?php echo $model->id; ?>"><i class="fa fa-check-circle"></i>  <?php echo Yii::t("app", "Ajouter au panier"); ?></button>
								</div>
								
	                    </div>
					</div>
                    
                    <div class="widget tags-wr">
                        <h4 class="widget-heading"><?php echo Yii::t("app", "Catégories"); ?></h4>
                        <ul class="tags-list">
							<?php
							
							foreach ($localized_categories as $locat) {
				
								if (isset($locat->name) && isset($locat->slug)){
									echo "<li><i class=\"fa fa-tags\"></i>";
									echo CHtml::link(CHtml::encode($locat->name), array("category/view", "slug"=>$locat->slug));
									echo "</li>";
								}
							
							}
							?>
                            
                            
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>