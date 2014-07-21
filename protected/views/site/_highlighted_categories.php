<div class="widget">
    <h4 class="widget-heading"><?php echo Yii::t("app","Catégories"); ?></h4>
	<ul class="categories highlight">
		<?php

	foreach ($items as $category_id){
		$category = Category::model()->findByPk($category_id);
		$localization = $category->localizationForLanguage(Yii::app()->language);
		if ($localization){
			echo '<li><a href="' . $this->createUrl('category/view', array('slug'=>$localization->slug)) . '">' . $localization->name . '</a></li>';
		}
	}
	
	?>
	</ul>
</div>