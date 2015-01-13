	    <div id="navbar" class="navbar navbar-white" role="navigation">
	        <div class="container">
	            <div class="navbar-header">
	                <button type="button" id="cmdSearchCollapse" class="navbar-toggle">
	                    <i class="fa fa-search icon-search"></i>
	                </button>
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
	                	<li class="hidden-xs">
	                    	<a href="#" class="" id="cmdSearch"><i class="fa fa-search"></i></a>
	                    </li>
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
	                    	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Yii::t("app", "Contact"); ?></a>
	                        <ul class="dropdown-menu">
	                            <li>
									<a href="tel:18442763434" class="sign-up.html"><i class="fa fa-phone fa-fw"></i> 1-844-276-3434 p<?php echo Yii::app()->params['outbound_api_user']; ?></a>
	                            </li>
	                            <li>
									<a href="mailto:<?php echo Yii::app()->params['adminEmail']; ?>" class="sign-up.html"><i class="fa fa-envelope fa-fw"></i> <?php echo Yii::app()->params['adminEmail']; ?></a>
	                            </li>	
	                        </ul>
	                	</li>
						
	                    <li class="">
	                    	<a href="<?php echo $this->createUrl('/cart/index'); ?>"><i class="fa fa-shopping-cart icon-cart"></i> <?php echo Yii::t('app', 'Panier'); ?> <span class="badge" id="cart_badge"></span></a>
	                    </li>
						
	                    
						
						
						
	                </ul>
	            </div><!--/.nav-collapse -->
	        </div>
	    </div>