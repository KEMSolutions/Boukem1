

<section class="slice animate-hover-slide">
	<div class="w-section inverse blog-grid">
    	<div class="container">
        	<div class="row">
				<div class="col-md-8" id="masonryWr">
					

				<?php $this->renderPartial('_promoted', array("items"=>$items->promoted, 'style'=>'narrow', 'limit'=>16)); ?>
				
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

	                   <?php $this->renderPartial('_highlighted_categories', array("items"=>$items->highlighted_categories, 'limit'=>24)); ?>
				   </div>
	            </div>

	        </div>
	    </div>

    

	</section>
	

	
