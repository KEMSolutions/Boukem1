<?php /* 
@var $this WebController
*/ ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language;?>">
  <head>
	  <?php
	  
	if ($this->isB2b()){
		$redirect_domain = Yii::app()->language === "fr" ? "https://kle-en-main.com" : "https://kemsolutions.com";
		$siteRoot = $redirect_domain . "/CloudServices/";
	} else {
		$siteRoot = "/";
	}
	
	  	$this->renderPartial("application.views.layouts._head");
		$this->renderPartial("application.views.layouts._subclassable_head");
	  ?>
  </head>

<body>
	<header>
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
		
	    	$this->renderPartial("application.views.layouts._header", array("siteRoot"=>$siteRoot, 'category_links_html'=>$category_links_html));
	    ?>
	</header>

<?php

$this->renderPartial("application.views.layouts._search", array());

if ($this->can_prompt_for_password_set && !$this->isB2b() && !Yii::app()->user->isGuest && !Yii::app()->user->user->password) {
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

<?php
$this->renderPartial("application.views.layouts._footer", array("siteRoot"=>$siteRoot, 'category_links_html'=>$category_links_html));
$this->renderPartial("application.views.layouts._footer_invisibles");
$this->renderPartial("application.views.layouts._footer_subclassable_invisibles");

?>

  
</body>
</html>
