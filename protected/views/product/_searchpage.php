<?php if ($results->count > 0 || $results->tag): ?>
		
		<section class="slice color-one">
			<div class="cta-wr">
		        <div class="container">
		            <div class="row">
		                <div class="col-xs-12">
							<form class="pull-right form-inline" method="get" action="<?php echo Yii::app()->createUrl("search"); ?>">
								<div class="input-group">
									<input type="text" name="q" class="form-control" value="<?php echo CHtml::encode($q); ?>" placeholder="<?php echo Yii::t("app", 'Nom du produit, marque ou usage'); ?>" />
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> <?php echo Yii::t("app", "Rechercher"); ?></button>
									</span>
								</div>
							</form>
		                </div>
		               
		            </div>
		        </div>
		    </div>
		</section>
		
<?php if ($results->tag && count($results->tag->items)>0): ?>
<section class="slice color-two">
	<div class="w-section inverse blog-grid">
    	<div class="container">
        	<div class="row js-masonry">
                
				
				<?php
					 foreach ($results->tag->items as $item) {
	
							$product = Product::model()->findByPk($item);
							if (!$product){
								continue;
							}
						
							$localization = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
							if (!$localization){
								continue;
							}
						
							if ($product && $localization && $product->visible && !$product->discontinued){
								$this->renderPartial("application.views._product_card", array("product"=>$product, "style"=>"fs", "localization"=>$localization));
							}
					
						}
					?>
				
            </div>
        </div>
    </div>
    
    <span class="clearfix"></span>
    <div style="height:16px;"></div> 
    <div class="section-title hidden-sm hidden-xs color-three">
        <h3><?php echo Yii::t("app", "Suggestions"); ?></h3>
        <div class="indicator-down color-three"></div>
    </div>
    
</section>
<?php endif; ?>
	
<section class="slice animate-hover-slide color-two-d">
	<div class="w-section inverse blog-grid">
		<div class="container">
	    	<div class="js-masonry row">
			
				<?php
					 foreach ($results->items as $item){
	
							$product = Product::model()->findByPk($item);
							if (!$product){
								continue;
							}
						
							$localization = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
							if (!$localization){
								continue;
							}
						
							if ($product && $localization && $product->visible && !$product->discontinued){
								$this->renderPartial("application.views._product_card_dense", array("product"=>$product, "style"=>"fs", "localization"=>$localization));
							}
					
						}
					?>

			</div>
		</div>
	</div>
	<div class="section">
		<div class="container">
		<ul class="pagination">
			<?php
		
			$counter = 1;
			while ($counter <= $results->pagination->pageCount){
				echo '<li' . (($results->pagination->currentPage+1 == $counter) ? ' class="active"' : "") . '><a href="' . $this->createUrl("search", array("page"=>$counter-1, "q"=>CHtml::encode($q))) . '">' . $counter . '</a></li>';
				$counter++;
			}
		
			?>
	  
		</ul>
	</div>
	
	</div>
	<?php if ($results->tag && count($results->tag->items)>0): ?>
    <span class="clearfix"></span>
    <div style="height:16px;"></div> 
    <div class="section-title color-three">
        <h3><?php echo Yii::t("app", "Tous les résultats"); ?></h3>
        <div class="indicator-down color-three"></div>
    </div>
	<?php endif; ?>
</section>
<?php else: 
	
	 ?>
	<section class="slice color-one">
	    <div class="w-section inverse">
	    	<div class="container">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="aside-feature">
	                        <div class="row">
                            
								 <div class="col-xs-12">
								<div class="text-center">
								                    	<h2><?php echo Yii::t("app", "Désolé, aucun résultat trouvé."); ?></h2>
								                    	<h1 class="font-lg">
								                        	<i class="fa fa-meh-o"></i>                        </h1>
                        
								                        <span class="clearfix"></span>
		    <form class="form-inline" method="get" action="<?php echo Yii::app()->createUrl("search"); ?>">
		        <div class="input-group">

		            <input type="text" name="q" class="form-control" value="<?php echo CHtml::encode($q); ?>" placeholder="<?php echo Yii::t("app", 'Nom du produit, marque ou usage'); ?>" />
		            <span class="input-group-btn">
		                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> <?php echo Yii::t("app", "Rechercher"); ?></button>
		            </span>
		        </div>
		    </form>
								                    </div>
												</div>
							
							
	                        </div>
	                    </div>
	                </div>
                

	            </div>
        
	        </div>
	 	</div>  
                       

    
	</section>
	
	<section class="slice color-two product_history_box hidden" data-limit='4'> 
		<div class="section-title color-three">
		        <h3><?php echo Yii::t("app", "Articles récemment vus"); ?></h3>
		        <div class="indicator-down color-three"></div>
		    </div>
		<div class="product_history_box_content">
		<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i></div>
	</div>
 
	</section>
<?php endif; ?>