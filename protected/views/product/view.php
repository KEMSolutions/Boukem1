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


<section class="slice product-slice animate-hover-slide"  itemscope itemtype="http://schema.org/Product">
	<div class="w-section inverse blog-grid">
    	<div class="container">
        	<div class="row">
				
				
				                <div class="col-md-4 col-md-push-8">
                    				
				                    <div class="widget pricing-plans" id="product_info_box" data-product="<?php echo $model->id; ?>">
					                    <div class="w-box popular">
					                        <h2 class="plan-title" itemprop="name">
												<?php
					
																	$title_lines = explode(" - ", $kemProduct->localization->name);
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
					 
					 
																	  ?></h2>
							
											<?php if ($kemProduct->discontinued): ?>
												<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
												<link itemprop="availability" href="http://schema.org/Discontinued">
												<p class="text-center text-danger">
													<?php echo Yii::t("app", "Ce produit n'est pas disponible."); ?>
												</p>
												</span>
											<?php else: ?>
												<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					                        <h3 class="price-tag color-one">
												<meta itemprop="price" content="<?php echo $current_price; ?>"><?php
								
											if (Yii::app()->language === "fr") {
					                        	echo $current_price . "<span itemprop='priceCurrency' content='CAD'>$</span>";
					                        } else {
					                        	echo "<span itemprop='priceCurrency' content='CAD'>$</span>" . $current_price;
					                        }
											?></h3>
							
					                        <ul>
												<?php if ($on_sale || $this->isB2b()): ?>
												<li class="text-success"><i class="fa fa-smile-o fa-fw"></i> <?php echo Yii::t("app", "Prix régulier:") . " $" . $regular_price; ?></li>
												<?php endif; ?>
												
												
												
												<?php $country_code = $this->getVisitorCountryCode();
									
												$supported_countries = array("US", "FR", "BE", "IT", "CH", "GB", "IE", "ES", "DE");
												
												$shipping_icon = ($country_code === "US" || $country_code === "CA") ? "fa-truck" : "fa-plane";
												
												if (in_array($country_code, $supported_countries)): ?>
								<li> <i class="fa fa-fw"><img src="https://cdn.kem.guru/boukem/spirit/flags/<?php echo $country_code; ?>.png" width="17" alt="<?php echo $country_code; ?>"></i>
									 <?php echo Yii::t("app", "Livraison à l'international disponible"); ?></li>
												
												<?php elseif ($country_code === "CA"): ?>
												<li> <i class="fa fa-fw"><img src="https://cdn.kem.guru/boukem/spirit/flags/<?php echo $country_code; ?>.png" width="17" alt="<?php echo $country_code; ?>"></i>
													 <?php echo Yii::t("app", "Livraison partout au pays"); ?></li>
												
												<?php endif; ?>
												
												
												
												<?php if ($kemProduct->inventory->count > 5): ?>
													<link itemprop="availability" href="http://schema.org/InStock" >
													<li class="text-success"><i class="fa <?php echo $shipping_icon; ?> fa-fw"></i> <?php echo Yii::t("app", "En stock : Expédition express"); ?></li>
												<?php elseif ($kemProduct->inventory->count > 0): ?>
													<link itemprop="availability" href="http://schema.org/InStock" >
													<li class="text-warning"><i class="fa <?php echo $shipping_icon; ?> fa-fw"></i> <?php echo Yii::t("app", "Seulement {n} restant en expédition express|{n} restants en expédition express.", $kemProduct->inventory->count); ?></li>
												<?php else: ?>
													<link itemprop="availability" href="http://schema.org/LimitedAvailability" >
													<li><i class="fa <?php echo $shipping_icon; ?> fa-fw"></i> <?php echo Yii::t("app", "Expédition prévue dans les 3 à 7 jours."); ?></li>
												<?php endif; ?>
								
					                            <li><i class="fa fa-lock fa-fw"></i> <?php echo Yii::t("app", "Transaction sécurisée"); ?></li>
								
					                        </ul>
											</span>
							
											<?php endif; ?>
							
					                        <p class="plan-info" id="product_short_description" itemprop="description"><?php echo strip_tags($kemProduct->localization->short_description); ?></p>
					                        <?php if (!$kemProduct->discontinued): ?>
											<p class="plan-select text-center">
								
								
												<div class="input-qty-detail form-inline text-center">
													<div class="form-group">
													    <input type="text" class="form-control input-qty text-center" id="item_quantity" value="1">
													  </div>
									  
													<button class="btn btn-three buybutton visible-lg-inline" data-product="<?php echo $model->id; ?>"><i class="fa fa-check-circle"></i>  <?php echo Yii::t("app", "Ajouter au panier"); ?></button>
													<button class="btn btn-block btn-three center-block buybutton hidden-lg" data-product="<?php echo $model->id; ?>"><i class="fa fa-check-circle"></i>  <?php echo Yii::t("app", "Ajouter au panier"); ?></button>
												</div>
							
					                    </p>
									<?php endif; ?>
					
									</div>
					
								</div>
					
									<?php
									$videos = $kemProduct->videos;
					
									if (count($videos)>0){
										// Insert support for video.js player
										Yii::app()->clientScript->registerScriptFile("//vjs.zencdn.net/4.8/video.js", CClientScript::POS_END);
										Yii::app()->clientScript->registerCssFile('//vjs.zencdn.net/4.8/video-js.css');

										$product_video_player_script = <<<EOD
											//store_video
											document.createElement('video');document.createElement('audio');document.createElement('track');
EOD;

										Yii::app()->clientScript->registerScript('product_video_player_script', $product_video_player_script, CClientScript::POS_END);
									}
					
									foreach ($videos as $video):
									?>
                    
								    <div class="widget">
								                           <h4 class="widget-heading"><?php echo Yii::t("app", "Vidéo"); ?></h4>
								                           <div class="w-box">
								                               <figure>
								                                   <div class="video-container">
				                                   
																   <video width="100%" height=180 controls preload="metadata" poster="<?php echo $video->poster; ?>" class="video-js vjs-default-skin vjs-big-play-centered">
														   			   <source src="<?php echo $video->h264high; ?>" media="only screen and (min-device-width: 568px)" type='video/mp4'></source>
														               <source src="<?php echo $video->h264low; ?>" media="only screen and (max-device-width: 568px)" type='video/mp4'></source>
														               <source src="<?php echo $video->webm; ?>" type='video/webm'></source>
																   </video>
												   
								                                   </div>
								                                   <h2><?php echo CHtml::encode($video->title); ?></h2>
								                               </figure>
								                           </div>
								                       </div>
					
					
								<?php endforeach; ?>
								    <div class="widget">
								                           <h4 class="widget-heading"><?php echo Yii::t("app", "Partagez")?></h4>

								                           <ul class="categories highlight">
											   
									  				                               <li class="facebook_share_button"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $this->createAbsoluteUrl("", array("slug"=>$localization->slug)); ?>">
									  					     <span class="fa fa-facebook fa-fw"></span> <?php echo Yii::t("app", "Partagez sur Facebook"); ?>
									  					     </a></li>
											   
											   
								                               <li class="pinterest_share_button"><a href="http://www.pinterest.com/pin/create/button/?url=<?php echo $this->createAbsoluteUrl("", array("slug"=>$localization->slug)); ?>&media=<?php echo $image ? $image->getImageURL(700,700) : ProductImage::placehoderForSize(700,700);?>&description=<?php echo urlencode($localization->name . "\n" . strip_tags($localization->short_description)); ?>" data-pin-do="buttonPin" data-pin-config="above">
									     <span class="fa fa-pinterest fa-fw"></span> <?php echo Yii::t("app", "Pin it"); ?>
									     </a></li>
				                               
								                           </ul>
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
				                </div> <!-- Right column -->
				
                <div class="col-md-8 col-md-pull-4">
                	<div class="row">
                    	<div class="col-md-12">
                        	<div class="w-box blog-post">
                                <figure>
                                    <img alt=""  itemprop="image" src="<?php
		
		$image = $localization->getMainImage();
		
		echo $image ? $image->getImageURL(700,500) : ProductImage::placehoderForSize(700,500);
		
		
		?>" class="img-responsive center-block">
                                    <ul class="meta-list">
                                        <?php if ($kemProduct->sku): ?>
										<li>
                                            <span>SKU</span>
                                            <span class="bold" itemprop="sku"><?php echo $kemProduct->sku; ?></span>
                                        </li>
										<?php endif; ?>
										
                                        <?php if ($kemProduct->barcode): ?>
										<li>
                                            <span><?php echo Yii::t("app", "CUP/EAN"); ?></span>
                                            <span class="bold" itemprop="gtin13"><?php
												if (strlen($kemProduct->barcode) == 12)
													echo "0";
												echo $kemProduct->barcode;
											?></span>
                                        </li>
										<?php endif; ?>
                                        
										<li itemprop="brand" itemscope itemtype="http://schema.org/Brand">
											<span><?php echo Yii::t("app", "Marque"); ?></span>
										    <span class="bold" itemprop="name"><?php echo $brand->name; ?></span>
											<meta itemprop="url" content="<?php echo $this->createAbsoluteUrl("category/view", array("slug"=>$brand->slug)); ?>">
										</li>
										
										
										
                                    </ul>
									
									<?php if ($kemProduct->localization->custom_description): ?>
									</figure> <!-- Image figure -->
								</div><!-- blog post -->
								
								<div class="w-box inner">
                	
								                                <div class="comments-wr">
								                                	<h2><?php echo Yii::t("app", "La suggestion de {name}", array("{name}"=>$kemProduct->localization->custom_description->author_name)); ?></h2>
                                    
								                                    <div class="comment">
								                                        <img src="<?php echo $this->createUrl("avatar", array("user"=>$kemProduct->localization->custom_description->author_id, "hash"=>$kemProduct->localization->custom_description->hash)); ?>" alt="<?php echo Yii::t("app", "La suggestion de {name}", array("{name}"=>$kemProduct->localization->custom_description->author_name)); ?>">
								                                        <p><?php echo $kemProduct->localization->custom_description->content; ?></p>
								                                    </div><!-- Comment -->
								                                  </div><!-- comments-wr -->
								                            </div><!-- w-box inner -->
									
		                        	<div class="w-box blog-post">
		                                <figure>
									
									<?php endif; ?>
									<div id="product_long_description">
                                    	<?php echo $kemProduct->localization->long_description; ?>
									</div>
                                </figure>
                            </div>
                            
                            
                            
                        </div>
                    </div>

                </div><!-- Left column -->
                                        
                
            </div>

        </div>
    </div>

</section>