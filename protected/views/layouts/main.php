<?php /* 
@var $this WebController
*/ ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language;?>">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    ->registerCssFile('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css')
    ->registerCssFile($themePath.'/assets/css/bootstrap-theme.css')
	->registerCssFile('//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css')
	->registerCssFile($themePath.'/assets/css/kem-theme.css');

/**
 * JavaScripts
 */
$cs
    ->registerCoreScript('jquery',CClientScript::POS_END)
    ->registerCoreScript('jquery.ui',CClientScript::POS_END)
    ->registerScriptFile('//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js',CClientScript::POS_END)

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
<!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only"><?php echo Yii::t('app', 'Modifier la navigation'); ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo CHtml::encode(Yii::app()->name); ?></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="/"><?php echo Yii::t('app', 'Accueil'); ?></a></li>
			
			<?php
			$top_categories_dataprovider = $this->topCategoriesDataProvider();
			$listOfTopCategories = $top_categories_dataprovider->getData();
			foreach ($listOfTopCategories as $topCategory) {
				$this->renderPartial("application.views._top_categories_menu_item", array("data"=>$topCategory));
			};
			
			?>
			
          </ul>
		  
		  		
					
					
		  
				  <div class="navbar-form navbar-right" role="form">
					  
					
						
					  <a href="<?php echo $this->createUrl('/cart/index'); ?>" class="btn btn-success"><span class="fa fa-shopping-cart"> <?php echo Yii::t('app', 'Panier'); ?></span> <span id="cart_content_badge" class="badge"></span></a>
				  </div>
		            
		  
        </div><!--/.nav-collapse -->
      </div>
    </div>
	
	
	<div class="container"  id="searchbar">
	
	<div class="row">
		
		<div class="col-md-7">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?>
		</div>
		<div class="col-md-5">
			<form method="get" action="<?php echo $this->createUrl('product/search'); ?>">
			<div class="input-group">
			      <input type="text" name="q" class="form-control" placeholder="<?php echo Yii::t('app', 'Rechercher'); ?>">
			      <span class="input-group-btn">
			        <button class="btn btn-default" type="button"><span class="fa fa-search" title="<?php echo Yii::t('app', 'Go!'); ?>"></span></button>
			      </span>
			    </div><!-- /input-group -->
			</form>
		</div>
	<?php endif?>
	
	</div>
	</div>
</header>

<?php echo $content; ?>

   
      <hr>
<div class="container">
      <footer>
		  
		  <?php if (Yii::app()->user->isGuest):?>
		  
		  <a href=""><?php echo Yii::t('app', 'Devenir membre ou se connecter'); ?></a>
		  
	  <?php else: ?>
		  
		  <a href="/site/logout"><?php echo Yii::t('app', 'Se déconnecter'); ?></a>
		  
		  <?php endif;?>
        <p>&copy; <?php echo date('Y'); ?>, <?php echo Yii::t('app', 'tous droits réservés'); ?>.</p>
      </footer>
    </div> <!-- /container -->



</body>
</html>
