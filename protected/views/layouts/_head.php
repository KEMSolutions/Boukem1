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

$main_style_sheet = '/css/global-style.css';
if (file_exists(Yii::app()->basePath . "/.." . $themePath . $main_style_sheet)){
	$main_style_sheet = $themePath . $main_style_sheet;
}



$secondary_style_sheet = '/css/skin-four.css';
if (file_exists(Yii::app()->basePath . "/.." . $themePath . $secondary_style_sheet)){
	$secondary_style_sheet = $themePath . $secondary_style_sheet;
}


/**
 * StyleSHeets
 */
$cs
    ->registerCssFile('//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css')
	->registerCssFile('//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css')
	//->registerCssFile('/js_assets/fancybox/jquery.fancybox.css?v=2.1.5')
	//->registerCssFile('/js_assets/fraction/fractionslider.css')
	
	->registerCssFile('//cdn.kem.guru/boukem/spirit/css/fancybox-fraction-concat.css')
	->registerCssFile($main_style_sheet)
	->registerCssFile('/css/cart-drawer.css')
	->registerCssFile($secondary_style_sheet);

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
		}

?>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    <script src="//cdn.kem.guru/boukem/spirit/js/html5shiv.js"></script>
    <script src="//cdn.kem.guru/boukem/spirit/js/respond.min.js"></script>
<![endif]-->
