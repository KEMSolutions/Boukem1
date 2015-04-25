<div id="outdated">
<h6><?php echo Yii::t('app', "Votre navigateur n'est pas compatible avec la boutique!"); ?></h6>
<p><?php echo Yii::t('app', "Veuillez utiliser un navigateur plus récent pour accéder au site. Cliquez sur le bouton mettre à jour pour obtenir de l'aide.<br>En attendant, vous pouvez également passer votre commande par téléphone en nous appellant au {contact_phone}.", array("{contact_phone}"=>"+1-844-276-3434 p" . Yii::app()->params['outbound_api_user'])); ?></p>
<p><a id="btnUpdateBrowser" href="http://outdatedbrowser.com/<?php echo Yii::app()->language; ?>"><?php echo Yii::t("app", "Mettre à jour"); ?></a></p>

<p class="last"><a href="#" id="btnCloseUpdateBrowser" title="<?php echo Yii::t("app", "Fermer"); ?>">&times;</a></p>
</div>


	<div class="back-link">
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
			<?php if (isset(Yii::app()->params['back_link']) && Yii::app()->params['back_link'] !== null): ?>
				<a href="<?php echo Yii::app()->params['back_link']; ?>" class="btn btn-one"><i class="fa fa-angle-double-left"></i> <?php echo Yii::t("app", "Retour au site principal"); ?></a>
			<?php endif; ?>
			</div>
			
			<div class="col-sm-3 col-md-offset-4">
			
			<form class="" role="search" method="get" action="<?php echo $this->createUrl('product/search'); ?>">
				<div class="input-group">
				      <input type="text" class="form-control" name="q" placeholder="<?php echo Yii::t("app", "Rechercher"); ?>" value="<?php echo CHtml::encode($this->searchTerm); ?>">
				      <span class="input-group-btn">
				        <button class="btn btn-default searchbutton" type="submit"><i class="fa fa-search"></i><span class="sr-only"><?php echo Yii::t("app", "Rechercher"); ?></span></button>
				      </span>
				    </div><!-- /input-group -->
				</form>
				
			</div>
			
			
			<div class="col-sm-2">
			
				 <a href="<?php echo $this->createUrl('/cart/index'); ?>" class="btn btn-one pull-right cart_button"><i class="fa fa-shopping-cart icon-cart"></i> <?php echo Yii::t('app', 'Panier'); ?> <span class="badge" id="cart_badge"></span></a>
			
			</div>
			
		</div>
	</div>
</div>
	
	
	
	
	</div>




	    <div id="navbar" class="navbar navbar-white" role="navigation">
	        <div class="container">
	            <div class="navbar-header">
	                 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	                    <span class="sr-only"><?php echo Yii::t('app', 'Afficher le menu'); ?></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                </button>
	                <a class="navbar-brand" href="<?php echo $siteRoot; ?>">
	                	<img src="/images/logo.png" class="img-responsive" alt="<?php echo Yii::app()->name; ?>">
	                </a>
	            </div>
	            <div class="navbar-collapse collapse">
	                <ul class="nav navbar-nav navbar-right">
	                	
	                    <li>
							<a href="<?php echo $siteRoot; ?>"><?php 
								
								if ($this->isB2b()){
									echo Yii::t("b2b", "Console");
								} else {
									echo Yii::t("app", "Accueil");
								}
								?></a>
						</li>
		                    <?php
							echo $category_links_html;
					        ?>
						
	                    <li class="dropdown">
	                    	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Yii::t("app", "Contact"); ?> <i class="fa fa-phone-square"></i> <i class="fa fa-envelope-square"></i></a>
	                        <ul class="dropdown-menu">
	                            <li>
									<a href="tel:18442763434"><i class="fa fa-phone fa-fw"></i> +1-844-276-3434 p<?php echo Yii::app()->params['outbound_api_user']; ?></a>
	                            </li>
	                            <li>
									<a href="mailto:<?php echo Yii::app()->params['adminEmail']; ?>"><i class="fa fa-envelope fa-fw"></i> <?php echo Yii::app()->params['adminEmail']; ?></a>
	                            </li>	
	                        </ul>
	                	</li>
						
						
	                </ul>
	            </div><!--/.nav-collapse -->
	        </div>
	    </div>