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
    
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>


<?php
$cs = Yii::app()->clientScript;
$themePath = Yii::app()->theme->baseUrl;

/**
 * StyleSHeets
 */
$cs
    ->registerCssFile('//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css')
	->registerCssFile('//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css')
	->registerCssFile('/css/jquery.bxslider.css')
	->registerCssFile('/css/style.css')
	->registerCssFile('/css/animate.css');

/**
 * JavaScripts
 */
$cs
    ->registerCoreScript('jquery',CClientScript::POS_END)
    ->registerCoreScript('jquery.ui',CClientScript::POS_END)
    ->registerScriptFile('//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js',CClientScript::POS_END)
	->registerScriptFile('/js/bootstrap.touchspin.js',CClientScript::POS_END)
	->registerScriptFile('/js/jquery.bxslider.min.js',CClientScript::POS_END)
	->registerScriptFile('/js/jquery.blImageCenter.js',CClientScript::POS_END)
	->registerScriptFile('/js/mimity.js',CClientScript::POS_END)
	->registerScriptFile('/js/boukem.js',CClientScript::POS_END)
		
    ->registerScript('tooltip',
        "$('[data-toggle=\"tooltip\"]').tooltip();
        $('[data-toggle=\"popover\"]').tooltip()"
        ,CClientScript::POS_READY);

?>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    <script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/html5shiv.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/respond.min.js"></script>
<![endif]-->

</head>

<body>

	<header>
	    <div class="container">
	        <div class="row">

	        	<!-- Logo -->
	            <div class="col-lg-4 col-md-3 hidden-sm hidden-xs">
	            	<div class="well logo">
	            		<a href="/">
	            			<img src="/images/logo.png" alt="<?php echo Yii::app()->name; ?>">
	            		</a>
	            	</div>
	            </div>
	            <!-- End Logo -->

				<!-- Search Form -->
	            <div class="col-lg-5 col-md-5 col-sm-7 col-xs-12">
	            	<div class="well">
						
						<form  method="get" action="<?php echo $this->createUrl('product/search'); ?>">
	                        <div class="input-group">
	                            <input type="text" name="q" class="form-control input-search" placeholder="<?php echo Yii::t('app', 'Rechercher'); ?>"/>
	                            <span class="input-group-btn">
	                                <button class="btn btn-default no-border-left" type="submit" ><span title="<?php echo Yii::t('app', 'Go!'); ?>" class="fa fa-search"></span></button>
	                            </span>
	                        </div>
	                    </form>
	                </div>
	            </div>
	            <!-- End Search Form -->

	            <!-- Shopping Cart List -->
	            <div class="col-lg-3 col-md-4 col-sm-5">
	                <div class="well">
	                    <div class="btn-group btn-group-cart">
							<a href="<?php echo $this->createUrl('/cart/index'); ?>" class="btn btn-default"><i class="fa fa-shopping-cart icon-cart"></i> <?php echo Yii::t('app', 'Panier'); ?> <span class="badge" id="cart_badge"></span></a>
	                      
	                    </div>
	                </div>
	            </div>
	            <!-- End Shopping Cart List -->
	        </div>
	    </div>
    </header>


	<!-- Navigation -->
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only"><?php echo Yii::t('app', 'Afficher le menu'); ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- text logo on mobile view -->
                <a class="navbar-brand visible-xs" href="/"><?php echo Yii::app()->name; ?></a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/" <?php if ($this->uniqueid === "site" && $this->action->id === "index") {echo "class=\"active\""; } ?>><?php echo Yii::t('app', 'Accueil'); ?></a></li>
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
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navigation -->


<?php if ($this->can_prompt_for_password_set && !Yii::app()->user->isGuest && !Yii::app()->user->user->password) {

	$this->renderPartial("application.views._password_setter");

}

?>

<?php echo $content; ?>

	<footer>
    	<div class="container">
        	<div class="col-lg-4 col-md-4 col-sm-6">
        		<div class="column">
        			<h4><?php echo Yii::t('app', 'Information'); ?></h4>
        			<ul>
        				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'about')); ?>"><?php echo Yii::t('app', 'À propos de la boutique'); ?></a></li>
        				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'privacy')); ?>"><?php echo Yii::t('app', 'Politique de confidentialité'); ?></a></li>
        				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'terms')); ?>"><?php echo Yii::t('app', "Conditions d'utilisation"); ?></a></li>
        				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'shipping')); ?>"><?php echo Yii::t('app', "Méthodes d'expédition"); ?></a></li>
        			</ul>
        		</div>
        	</div>
        	<div class="col-lg-4 col-md-4 col-sm-6">
        		<div class="column">
        			<h4><?php echo Yii::t('app', 'Accès rapide'); ?></h4>
        			<ul>
        				<li><a href="catalogue.html"><?php echo Yii::t('app', 'Accueil'); ?></a></li>
						<?php
						echo $category_links_html;
						?>
        			</ul>
        		</div>
        	</div>
        	<div class="col-lg-4 col-md-4 col-sm-12">
        		<div class="column">
        			<h4><?php echo Yii::t('app', 'Service à la clientèle'); ?></h4>
        			<ul>
        				<li><a href="<?php echo $this->createUrl('site/contact'); ?>"><?php echo Yii::t('app', 'Nous contacter'); ?></a></li>
        				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'returns')); ?>"><?php echo Yii::t('app', 'Retours et échanges'); ?></a></li>
        				<li><a href="#"><?php echo Yii::t('app', 'Signaler un problème'); ?></a></li>
				  		  <?php if (Yii::app()->user->isGuest):?>
		  
				  		  <li><a href=""><?php echo CHtml::link(Yii::t('app', 'Devenir membre ou se connecter'), array('site/register')); ?></a></li>
		  
				  	  <?php else: ?>
		  
				  		  <li><?php echo CHtml::link(Yii::t('app', 'Se déconnecter'), array('site/logout')); ?></li>
		  
				  		  <?php endif;?>
        			</ul>
        		</div>
        	</div>
        	
        </div>
        <div class="navbar-inverse text-center copyright">
        	&copy; <?php echo date("Y"); ?>, <?php echo Yii::t('app', 'tous droits réservés'); ?>.
        </div>
    </footer>

    <a href="#top" class="back-top text-center" onclick="$('body,html').animate({scrollTop:0},500); return false">
    	<i class="fa fa-angle-double-up"></i>
    </a>


<div id="modal_cart"></div>


<script>

// Include the UserVoice JavaScript SDK (only needed once on a page)
UserVoice=window.UserVoice||[];(function(){var uv=document.createElement('script');uv.type='text/javascript';uv.async=true;uv.src='//widget.uservoice.com/cD9gVxQWYW9mlPv2ssCcOg.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(uv,s)})();

//
// UserVoice Javascript SDK developer documentation:
// https://www.uservoice.com/o/javascript-sdk
//

// Set colors
UserVoice.push(['set', {
  "locale": "fr",
  accent_color: '#FF3333',
  trigger_color: 'white',
  trigger_background_color: '#FF3333'
}]);


// Add default trigger to the bottom-right corner of the window:
UserVoice.push(['addTrigger', { mode: 'contact', trigger_position: 'bottom-right' }]);

// Or, use your own custom trigger:
//UserVoice.push(['addTrigger', '#id', { mode: 'contact' }]);

// Autoprompt for Satisfaction and SmartVote (only displayed under certain conditions)
UserVoice.push(['autoprompt', {}]);
</script>
</body>
</html>
