<?php if ($this->isB2b()): ?>

<section class="slice color-two-l">
	<div class="w-section inverse">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-5">
                    <h2><?php echo Yii::t("b2b", "Bienvenue dans <strong>votre</strong> boutique"); ?></h2>
                    <p><?php echo Yii::t("b2b", "La boutique KEMB2B vous permet d'acheter l'ensemble des produits du catalogue KEM en bénéficiant de prix réduits."); ?>
                    </p>
                    <p>
                    <?php echo Yii::t("b2b", "Que vous exploitiez un magasin ou afin d'offrir à vos clients une officine bien garnie, la boutique KEMB2B est là pour vous faciliter la vie."); ?>
                    </p>
                   
                </div>
                <div class="col-md-6 col-md-offset-1">
                    <h2><?php echo Yii::t("b2b", "Votre rabais");
						
						$rebate_percent = 100 * Yii::app()->params['b2b_rebate_multiplier'];
						$total_percent = 100-$rebate_percent;
						
						 ?></h2>
                    <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-one" role="progressbar" aria-valuenow="<?php echo $total_percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $total_percent; ?>%">
                        <span class="sr-only"><?php echo $rebate_percent; ?>%</span>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    
</section>


<?php endif; ?>

<section class="slice animate-hover-slide">
	<div class="w-section inverse blog-grid">
    	<div class="container">
        	<div class="row">
				<div class="col-md-8" id="masonryWr">
					

				<?php $this->renderPartial('_featured', array("items"=>$items->promoted->products, 'style'=>'normal', 'limit'=>9, 'show_title'=>false, 'style'=>"narrow")); ?>
				
			</div>
	                <div class="col-md-4">
						
	                    <div class="widget">
							<form class="form-inline" method="get" action="<?php echo $this->createUrl('product/search'); ?>">
	                            <div class="input-group">
	                                <input type="search" class="form-control" name="q" placeholder="<?php echo Yii::t("app", "Rechercher"); ?>" value="" autocomplete="off" spellcheck="false" />
	                                <span class="input-group-btn">
	                                    <button class="btn btn-primary" type="submit"><span class="fa fa-search"><span class="sr-only"><?php echo Yii::t("app", "Rechercher"); ?></span></span></button>
	                                </span>
	                            </div>
	                        </form>
	                    </div>

	                   <?php $this->renderPartial('_highlighted_categories', array("items"=>$items->recommended->categories, 'limit'=>24)); ?>
				   </div>
	            </div>

	        </div>
	    </div>

    

	</section>
	

	
