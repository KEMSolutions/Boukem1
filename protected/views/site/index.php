<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
$this->layout = "//layouts/freestyle";
?>
    <div class="container main-container">
        <div class="row">

        	<!-- Slider -->
        	<div class="col-lg-9 col-md-12">
                <div class="slider">
                    <ul class="bxslider">
                        <li>
                            <a href="/<?php echo Yii::app()->language; ?>/cat/<?php echo Yii::app()->language; ?>-lorna-vanderhaeghe.html">
                                <img src="/images/slider/slider-1-<?php echo Yii::app()->language; ?>.png" alt=""/>
                            </a>
                        </li>
						
                        <li>
                            <a href="/<?php echo Yii::app()->language; ?>/cat/<?php echo Yii::app()->language; ?>-performances-intellectuelles.html">
                                <img src="/images/slider/slider-2-<?php echo Yii::app()->language; ?>.jpg" alt=""/>
                            </a>
                        </li>
						
                    </ul>
                </div>
            </div>
            <!-- End Slider -->

			<!-- Product Selection, visible only on large desktop -->
            <div class="col-lg-3 visible-lg">
                <div class="row text-center">
                    <div class="col-lg-12 col-md-12 hero-feature">
                        <div class="thumbnail">
                        	<a href="/fr/prod/fr-menosmart-plus-120-capsules-vegetariennes.html" class="link-p first-p">
		                    	<img src="http://static.boutiquekem.com/productimg-300-280-3682.jpg" alt="">
		                    </a>
		                    <div class="caption prod-caption">
		                        <h4><a href="/fr/prod/fr-menosmart-plus-120-capsules-vegetariennes.html">MenoSmart</a></h4>
		                        <p>Pour accompagner la femme dans le chemin de la vie.</p>
		                        <p>
		                        	<div class="btn-group">
			                        	<a href="/fr/prod/fr-menosmart-plus-120-capsules-vegetariennes.html" class="btn btn-default">$ 32.99</a>
			                        	<button class="btn btn-primary buybutton" data-product="52"><i class="fa fa-shopping-cart"></i> <?php echo Yii::t("app","Acheter");?></button>
		                        	</div>
		                        </p>
		                    </div>
		                </div>
                    </div>
                </div>
            </div>
            <!-- End Product Selection -->
        </div>
		
		
	
	<div class="row">
	        	<div class="col-lg-3 col-md-3 col-sm-12">

	        		<!-- Categories -->
	        		<div class="col-lg-12 col-md-12 col-sm-6">
		        		<div class="no-padding">
		            		<span class="title"><?php echo Yii::t("app","Catégories"); ?></span>
		            	</div>
						<div class="list-group list-categ">
							<?php
								
							#TODO replace this generator by actual fetch of front page categories
								$featured_categories = array(
									Category::model()->findByPk(20),
									Category::model()->findByPk(77),
									Category::model()->findByPk(81),
									Category::model()->findByPk(12),
									Category::model()->findByPk(18),
									Category::model()->findByPk(144),
									Category::model()->findByPk(156),
									Category::model()->findByPk(171),
									Category::model()->findByPk(5),
									Category::model()->findByPk(39),
									Category::model()->findByPk(111),
								);
								
							?>
							<?php
								
							foreach ($featured_categories as $category){
								$localization = $category->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
								echo '<a href="' . $this->createUrl('category/view', array('slug'=>$localization->slug)) . '" class="list-group-item">' . $localization->name . '</a>';
							}
								
							?>
							
						
						</div>
					</div>
					<!-- End Categories -->

					
					<!-- End Best Seller -->

	        	</div>

	        	<div class="clearfix visible-sm"></div>
				
				<?php
					
				#TODO replace this generator by actual fetch of front page categories
					$featured_products = array(
						Product::model()->findByPk(2944),
						Product::model()->findByPk(2778),
						Product::model()->findByPk(907),
					);
					
				?>
				
				<!-- Featured -->
	        	<div class="col-lg-9 col-md-9 col-sm-12">
	        		<div class="col-lg-12 col-sm-12">
	            		<span class="title"><?php echo Yii::t("app","En vedette"); ?></span>
	            	</div>
					<?php
						
					foreach ($featured_products as $product){
						$localization = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
						$image = $localization->getMainImage();
						$product_url = $this->createUrl('product/view', array('slug'=>$localization->slug));
						echo "<div class='col-lg-4 col-sm-4 hero-feature text-center'>
		                <div class='thumbnail'>
		                	<a href='". $product_url ."' class='link-p'>
		                    	<img src='" . $image->getImageUrl(280, 280) . "' alt=''>
		                	</a>
		                    <div class='caption prod-caption'>
		                        <h4><a href='$product_url'>$localization->name</a></h4>
		                        <p>" . substr(strip_tags($localization->short_description), 0, 50) . "</p>
		                        <p>
		                        	<div class='btn-group'>
			                        	<a href='$product_url' class='btn btn-default'>$ $product->price</a>
			                        	<button class='btn btn-primary buybutton' data-product='" . $product->id . "'><i class='fa fa-shopping-cart'></i> " . Yii::t("app", "Acheter") . "</button>
		                        	</div>
		                        </p>
		                    </div>
		                </div>
		            </div>";
					}
						
					?>
					
		            
		            
	        	</div>
	        	<!-- End Featured -->
	
		
  
</div>