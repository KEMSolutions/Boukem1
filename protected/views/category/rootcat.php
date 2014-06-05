<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->id,
);



$this->menu=array();
foreach ($model->children as $children){
	
	$localization = $children->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
	if ($localization)
		$this->menu[] = array('label'=>$localization->name, 'url'=>array('category/view', "slug"=>$localization->slug));
}

?>

<h1>View Root Category #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parent_category',
		'visible',
		'is_brand',
	),
)); ?>

<em>No products will be shown here</em>