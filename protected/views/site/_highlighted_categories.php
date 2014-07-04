<?php

foreach ($items as $category_id){
	$category = Category::model()->findByPk($category_id);
	$localization = $category->localizationForLanguage(Yii::app()->language);
	if ($localization){
		echo '<a href="' . $this->createUrl('category/view', array('slug'=>$localization->slug)) . '" class="list-group-item">' . $localization->name . '</a>';
	}
}
	
?>
