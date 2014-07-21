<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=null;

$this->menu=array();
foreach ($model->children as $children){
	
	$childLocalization = $children->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
	if ($childLocalization)
		$this->menu[] = array('label'=>$childLocalization->name, 'url'=>array('category/view', "slug"=>$childLocalization->slug));
}

//$this->menuTitle = $localization->name;

$this->pageTitle = $localization->name;

?>

<div class="col-xs-12"><span class="title"><?php echo Yii::t("app", "En vedette") ?></span></div>

<?php if ($localization->slug === "fr-marques"): ?>
	
	<div class="col-lg-12 col-sm-12 hero-feature text-center">
	    <div class="thumbnail">
	    	<a href="/fr/cat/fr-lorna-vanderhaeghe.html" class="link-p">
	        	<img src="/images/lorna-banner.png" alt="">
	    	</a>
	      
	    </div>
	</div>
	<div class="col-lg-12 col-sm-12 hero-feature text-center">
	    <div class="thumbnail">
	    	<a href="/fr/cat/fr-aor.html" class="link-p">
	        	<img src="/images/aor-banner.png" alt="">
	    	</a>
	      
	    </div>
	</div>
	<div class="col-lg-12 col-sm-12 hero-feature text-center">
	    <div class="thumbnail">
	    	<a href="/fr/cat/fr-new-roots.html" class="link-p">
	        	<img src="/images/newroot-banner.png" alt="">
	    	</a>
	      
	    </div>
	</div>

<?php elseif ($localization->slug === "en-brands"): ?>

	<div class="col-lg-12 col-sm-12 hero-feature text-center">
	    <div class="thumbnail">
	    	<a href="/en/cat/en-lorna-vanderhaeghe.html" class="link-p">
	        	<img src="/images/lorna-banner.png" alt="">
	    	</a>
	      
	    </div>
	</div>
	<div class="col-lg-12 col-sm-12 hero-feature text-center">
	    <div class="thumbnail">
	    	<a href="/en/cat/en-aor.html" class="link-p">
	        	<img src="/images/aor-banner.png" alt="">
	    	</a>
	      
	    </div>
	</div>
	<div class="col-lg-12 col-sm-12 hero-feature text-center">
	    <div class="thumbnail">
	    	<a href="/en/cat/en-new-roots.html" class="link-p">
	        	<img src="/images/newroot-banner.png" alt="">
	    	</a>
	      
	    </div>
	</div>


<?php elseif ($localization->slug === "fr-sujets-de-sante"): ?>

	<div class="col-lg-12 col-sm-12 hero-feature text-center">
	    <div class="thumbnail">
	    	<a href="/fr/cat/fr-performance-blessures-et-trauma.html" class="link-p">
	        	<img src="/images/trauma-banner-fr.jpg" alt="">
	    	</a>
	      
	    </div>
	</div>
	<div class="col-lg-12 col-sm-12 hero-feature text-center">
	    <div class="thumbnail">
	    	<a href="/fr/cat/fr-stress.html" class="link-p">
	        	<img src="/images/stress-banner.jpg" alt="">
	    	</a>
	      
	    </div>
	</div>

<?php elseif ($localization->slug === "fr-categories"): ?>

	<div class="col-lg-12 col-sm-12 hero-feature text-center">
	    <div class="thumbnail">
	    	<a href="/fr/cat/fr-omega-3-et-6.html" class="link-p">
	        	<img src="/images/omega-banner.jpg" alt="">
	    	</a>
	      
	    </div>
	</div>
	<div class="col-lg-12 col-sm-12 hero-feature text-center">
	    <div class="thumbnail">
	    	<a href="/fr/cat/fr-tisanes-therapeutiques.html" class="link-p">
	        	<img src="/images/alimentation-banner.jpg" alt="">
	    	</a>
	      
	    </div>
	</div>
	
	
	

<?php endif; ?>