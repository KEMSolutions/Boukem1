<?php if ($results->count > 0 || $results->tag): ?>
		
		
		<div class="pg-opt pin">
			<div class="container">
		        <div class="row">
		            <div class="col-md-6">
		                <h2><?php echo Yii::t("app", "Rechercher"); ?></h2>
		            </div>
			            				<div class="col-md-6">
                
								<ol class="breadcrumb">
		<li><em><?php echo CHtml::encode($q); ?></em></li><li class="active"><?php echo Yii::t("app","Page {page_number}", array("{page_number}"=>$results->pagination->currentPage+1)); ?></li></ol></div>
					        </div>
		    </div>
		</div>
		
		
		
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
	
<?php if (count($results->items)>0): ?>
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
			<div class="row">
				<div class="col-sm-7">
		<ul class="pagination">
			<?php
		
			$counter = 1;
			while ($counter <= $results->pagination->pageCount){
				echo '<li' . (($results->pagination->currentPage+1 == $counter) ? ' class="active"' : "") . '><a href="' . $this->createUrl("search", array("page"=>$counter-1, "q"=>CHtml::encode($q))) . '">' . $counter . '</a></li>';
				$counter++;
			}
		
			?>
	  
		</ul>
		
			</div><!--Col pagination-->
			
			<div class="col-sm-5">
				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h3 class="panel-title"><?php echo Yii::t("app", "Incapable de trouver?"); ?><i class="fa fa-frown-o pull-right"></i></h3>
				  </div>
				  <div class="panel-body">
		    
					<?php echo Yii::t("app", "Vous n'arrivez pas à trouver? Contactez nous au {phone_number} pour passer une commande téléphonique!", array("{phone_number}"=>CHtml::link($this->getSupportPhoneNumber(), "tel:" . $this->getSupportPhoneNumber()))); ?>
			
				  </div>
				</div>
			</div><!-- col sm5-->
			
		</div><!--row-->
		
		
		
		
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
<?php endif; // Items more than 0 ?>
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
															
															<p><?php echo Yii::t("app", "Tentez de reformuler votre requête. Vous pouvez chercher par nom de produit, marque ou catégorie (exemple: glucosamine ou santé des enfants)."); ?></p>
															
															<p><?php echo Yii::t("app", "Vous n'arrivez pas à trouver? Contactez nous au {phone_number} pour passer une commande téléphonique!", array("{phone_number}"=>CHtml::link($this->getSupportPhoneNumber(), "tel:" . $this->getSupportPhoneNumber()))); ?></p>
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