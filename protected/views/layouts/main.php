<?php /* 
@var $this WebController
*/ ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language;?>">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="/favicon.png" />
	<?php if ($this->pageDescription): ?>
		<meta name="description" content="<?php echo CHtml::encode($this->pageDescription); ?>">
	<?php endif; ?>
    
    <title><?php if ($this->isHomePage){
    	echo Yii::app()->name;
    } else {
    	echo CHtml::encode($this->pageTitle) . " - " . Yii::app()->name;
    }; ?></title>

<?php foreach ($this->alternatives as $key => $value) {
	echo '<link rel="alternate" hreflang="' . $key . '" href="' . $value . '" />';
}?>

<?php
$cs = Yii::app()->clientScript;
$themePath = Yii::app()->theme->baseUrl;

/**
 * StyleSHeets
 */
$cs
    ->registerCssFile('//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css')
	->registerCssFile('//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css')
	//->registerCssFile('/js_assets/fancybox/jquery.fancybox.css?v=2.1.5')
	//->registerCssFile('/js_assets/fraction/fractionslider.css')
	
	->registerCssFile('//cdn.kem.guru/boukem/spirit/css/fancybox-fraction-concat.css')
	->registerCssFile('/css/global-style.css')
	->registerCssFile('/css/cart-drawer.css')
	->registerCssFile('/css/skin-four.css');

/**
 * JavaScripts
 */
$cs
    ->registerCoreScript('jquery',CClientScript::POS_END)
    ->registerCoreScript('jquery.ui',CClientScript::POS_END)
    ->registerScriptFile('//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js',CClientScript::POS_END)
	->registerScriptFile('//cdn.kem.guru/boukem/spirit/js/gcc_ressources.js.gz',CClientScript::POS_END)
	//->registerScriptFile('//cdn.kem.guru/boukem/spirit/js/bootstrap.touchspin.js',CClientScript::POS_END)
	//->registerScriptFile('//cdn.kem.guru/boukem/spirit/js/modernizr.custom.js',CClientScript::POS_END)
	//->registerScriptFile('//cdn.kem.guru/boukem/spirit/js/jquery.mousewheel-3.0.6.pack.js',CClientScript::POS_END)
	//->registerScriptFile('//cdn.kem.guru/boukem/spirit/js/jquery.cookie.js',CClientScript::POS_END)
	//->registerScriptFile('//cdn.kem.guru/boukem/spirit/js/jquery.easing.js',CClientScript::POS_END)
	//->registerScriptFile('/js_assets/masonry/masonry.js',CClientScript::POS_END)
	//->registerScriptFile('/js_assets/page-scroller/jquery.ui.totop.min.js',CClientScript::POS_END)
	//->registerScriptFile('/js_assets/mixitup/jquery.mixitup.js',CClientScript::POS_END)
	->registerScriptFile('/js_assets/mixitup/jquery.mixitup.init.js',CClientScript::POS_END)
	->registerScriptFile('/js_assets/fancybox/jquery.fancybox.pack.js?v=2.1.5',CClientScript::POS_END)
	//->registerScriptFile('/js_assets/fraction/jquery.fractionslider.min.js',CClientScript::POS_END)
	->registerScriptFile('/js_assets/fraction/jquery.fractionslider.init.js',CClientScript::POS_END)
	//->registerScriptFile('//cdn.kem.guru/boukem/spirit/js/imagesloaded.pkgd.min.js',CClientScript::POS_END)
	->registerScriptFile('//cdn.kem.guru/boukem/spirit/js/jquery.ebright.custom.js.gz',CClientScript::POS_END)
	->registerScriptFile('/js/boukem.js',CClientScript::POS_END)
	
		
    ->registerScript('tooltip',
        "$('[data-toggle=\"tooltip\"]').tooltip();
        $('[data-toggle=\"popover\"]').tooltip()"
        ,CClientScript::POS_READY);
		
		
	
		if ($this->isB2b()){
			$cs->registerScriptFile('/js/boukemb2b.js',CClientScript::POS_END);
			$redirect_domain = Yii::app()->language === "fr" ? "https://kle-en-main.com" : "https://kemsolutions.com";
			$siteRoot = $redirect_domain . "/CloudServices/";
		} else {
			$siteRoot = "/";
		}

?>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    <script src="//cdn.kem.guru/boukem/spirit/js/html5shiv.js"></script>
    <script src="//cdn.kem.guru/boukem/spirit/js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<header>
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
							
							$categories_links_cache_id = Yii::app()->request->hostInfo . " Layout:[footer_links_for_language] " . Yii::app()->language;
							$category_links_html = Yii::app()->cache->get($categories_links_cache_id);
							if (!$category_links_html){
						
								$category_links_html = "";
								foreach ($this->topCategoriesLocalizationsDataProvider()->getData() as $topCategory) {
									$category_links_html .= "<li>" . CHtml::link($topCategory->name, array('/category/view', 'slug'=>$topCategory->slug)) . "</li>";
						}
						Yii::app()->cache->set($categories_links_cache_id, $category_links_html, 3600);
							}
					
							echo $category_links_html;
					
		                    ?>
						
	                    <li class="">
	                    	<a href="<?php echo $this->createUrl('/cart/index'); ?>"><i class="fa fa-shopping-cart icon-cart"></i> <?php echo Yii::t('app', 'Panier'); ?> <span class="badge" id="cart_badge"></span></a>
	                       
	                	</li>
	                </ul>
	            </div><!--/.nav-collapse -->
	        </div>
	    </div>
	</header>
	
	<!-- SEARCH -->
	<div class="search-wr" id="divSearch">
		<span class="close" id="cmdCloseSearch" title="Fermez la recherche en cliquant sur ce bouton ou en appuyant sur la touche ESC"><i class="fa fa-times-circle"></i></span>
		<div class="container">
	    	<div class="row">
	        	<div class="col-md-1 col-xs-2 search-sign">
	            	<i class="fa fa-search"></i>
	            </div>
	            <div class="col-md-11 col-xs-10">
					<form  method="get" action="<?php echo $this->createUrl('product/search'); ?>">
	            	<input type="text" name="q" autofocus class="global-search-input" placeholder="<?php echo Yii::t("app", "Rechercher"); ?>" value="" autocomplete="off" spellcheck="false" dir="ltr">
				</form>
				</div>
	            </div>
	        </div>
	    </div>
	</div>


	


<?php if ($this->can_prompt_for_password_set && !$this->isB2b() && !Yii::app()->user->isGuest && !Yii::app()->user->user->password) {

	$this->renderPartial("application.views._password_setter");

}

?>


<?php if(Yii::app()->user->hasFlash('success') || Yii::app()->user->hasFlash('danger') || Yii::app()->user->hasFlash('warning') || Yii::app()->user->hasFlash('info')): ?>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="alert alert-' . $key . ' alert-dismissable animated pulse"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $message . "</div>\n";
    }
?>

<?php endif; ?>

<?php echo $content; ?>


<footer>
    <div class="container">
		
        
		
        <div class="row">
			<?php if (!$this->isB2b()): ?>
            <div class="col-md-4">
            	<div class="col">
                   <h4><?php echo Yii::t('app', 'Information'); ?></h4>
      			<ul>
      				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'about')); ?>"><?php echo Yii::t('app', 'À propos de la boutique'); ?></a></li>
      				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'privacy')); ?>"><?php echo Yii::t('app', 'Politique de confidentialité'); ?></a></li>
      				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'terms')); ?>"><?php echo Yii::t('app', "Conditions d'utilisation"); ?></a></li>
      				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'shipping')); ?>"><?php echo Yii::t('app', "Méthodes d'expédition"); ?></a></li>
      			</ul>
                 </div>
            </div>
            
            <div class="col-md-4">
            	<div class="col">
                    <h4><?php echo Yii::t('app', 'Accès rapide'); ?></h4>
        			<ul>
        				<li><a href="catalogue.html"><?php echo Yii::t('app', 'Accueil'); ?></a></li>
						<?php
						echo $category_links_html;
						?>
        			</ul>
                </div>
            </div>
            <?php endif; ?>
            
             <div class="col-md-4">
             	<div class="col">
                    <h4><?php echo Yii::t('app', 'Service à la clientèle'); ?></h4>
        			<ul>
        				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'contact')); ?>"><?php echo Yii::t('app', 'Nous contacter'); ?></a></li>
        				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'returns')); ?>"><?php echo Yii::t('app', 'Retours et échanges'); ?></a></li>
        				<li><a href="<?php echo $this->createUrl('account/index'); ?>"><?php echo Yii::t('app', 'Compte'); ?></a></li>
				  		  <?php if (Yii::app()->user->isGuest):?>
		  
				  		  <li><a href=""><?php echo CHtml::link(Yii::t('app', 'Devenir membre ou se connecter'), array('site/register')); ?></a></li>
		  
				  	  <?php else: ?>
		  
				  		  <li><?php echo CHtml::link(Yii::t('app', 'Se déconnecter'), array('site/logout')); ?></li>
		  
				  		  <?php endif;?>
        			</ul>
                </div>
            </div>
			
        </div>
		
	
	  <hr />
        <div class="row">
        	<div class="col-lg-9 copyright">
            	&copy; <?php echo date("Y"); ?>, <?php echo Yii::t('app', 'tous droits réservés'); ?>.
            </div>
            <div class="col-lg-3 footer-logo text-right">
            	<img src="/images/kem_signature.png" alt="Powered by KEM">
            </div>
        </div>
    </div>
</footer><!-- JavaScript -->
  

<div id="modal_cart"></div>
<div id="cart-container">
	<div class="proceed btn-group btn-group-justified">
		<a class="btn btn-two btn-lg" id="back"><?php echo Yii::t("app", "Continuer le magasinage"); ?></a>
		<?php echo CHtml::link(Yii::t("app", "Passer à la caisse"), "/cart/index", array('class'=>'btn btn-three btn-lg', 'id'=>'checkout')); ?>
	</div>
	<hr/>
	<div id="cart-total">
		<dl class="subtotal">
			<dd><?php echo Yii::t("app", "Sous-total"); ?></dd>
			<dt>&nbsp;</dt>
		</dl>
		<hr>
		<dl class="item">
			<dd>0 item</dd>
			<dt>&nbsp;</dt>
		</dl>
		<dl class="taxes">
			<dd> <?php echo Yii::t("app", "Taxes"); ?> </dd>
			<dt>&nbsp;</dt>
		</dl>            
	</div>
	<hr>
	<div id="cart-items">
		<ul id="cart-items-list">            
		</ul>
	</div>
</div>



<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://kle-en-main.com/CloudAnalytics/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', <?php echo Yii::app()->params['kem_analytics_id']; ?>]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="http://kle-en-main.com/CloudAnalytics/piwik.php?idsite=<?php echo Yii::app()->params['__KEM_ANALYTICS_ID__']; ?>" style="border:0;" alt="" /></p></noscript>

</body>
</html>
