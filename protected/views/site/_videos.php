<?php if (count($layout->videos) > 0): ?>
<section class="slice animate-hover-slide">
	<?php
	if ($show_tab){
		$this->renderPartial('_tab', array("layout"=>$layout));
	}

	?>
	<div class="w-section inverse work">
    	<div class="container">
        	<div class="row">
                <div>
<?php foreach ($layout->videos as $video): 
	
	$productName = explode(" - ", $video->name);
	
	$product = Product::model()->findByPk($video->id);
	if ($product === null)
		continue;
	
	
	
	$localization = $product->localizationForLanguage(Yii::app()->language);
	
	
	if ($localization === null)
		continue;
	
	$product_url = $this->createUrl("product/view", array('slug'=>$localization->slug));
	
	?>
                    <div class="mix category_1 col-lg-3 col-md-4 col-sm-6 mix_all" data-cat="1" style="  display: inline-block; opacity: 1;">
                    	<div class="w-box">
                            <figure>
                                <img alt="" src="<?php echo $video->poster; ?>" class="img-responsive">
                                <figcaption class="color-two-l" style="height: 173px;">
                                    <a href="#video_<?php echo $video->id; ?>" class="btn btn-xs btn-two theater"><i class="fa fa-play-circle"></i> <?php echo Yii::t("app", "Jouer"); ?></a>
                                    <a href="<?php echo $product_url; ?>" class="btn btn-xs btn-three"><?php echo Yii::t("app", "En savoir plus"); ?> </a>
									
									<div hidden id="video_<?php echo $video->id; ?>">
									
	                                   <div class="video-container">
                                   
									   <video width=640 height=360 controls preload="auto" poster="<?php echo $video->poster; ?>" class="video-js vjs-default-skin vjs-big-play-centered">
							   			   <source src="<?php echo $video->h264high; ?>" media="only screen and (min-device-width: 568px)" type='video/mp4'></source>
							               <source src="<?php echo $video->h264low; ?>" media="only screen and (max-device-width: 568px)" type='video/mp4'></source>
							               <source src="<?php echo $video->webm; ?>" type='video/webm'></source>
									   </video>
									   <div class="clearfix"></div>
										   
                                       <a href="<?php echo $product_url; ?>" class="btn btn-sm btn-three pull-right"><i class="fa fa-arrow-circle-right"></i> <?php echo Yii::t("app", "En savoir plus"); ?></a>
									   
								   
	                                   </div>
									
									</div>
									
									
                                </figcaption>
        					</figure>
                            <h2><?php echo $productName[0]; ?></h2>
                        </div>
                    </div>
<?php endforeach; ?>					

                </div>
                                
            </div>
        </div>
    </div>

</section>
<?php endif; ?>