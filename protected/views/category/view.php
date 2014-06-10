<?php
/* @var $this CategoryController */
/* @var $model Category */

// Will append each mother category to the breadcrumbs so we can show a tree like structure to the users. Because of PHP way to handle scope, we just pass a "pointer" to $this->breadcrumbs.

$this->menuTitle = $localization->name;
?>
<div class="col-lg-12 col-sm-12">
	<span class="title"><?php echo Yii::t("app", "Produits"); ?></span>
</div>

<?php  $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$products,
	'itemView'=>'_product',
	
	'pagerCssClass'=>"pagination",
));  ?>
