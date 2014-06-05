<?php
/* @var $this CategoryController */
/* @var $model Category */

// Will append each mother category to the breadcrumbs so we can show a tree like structure to the users. Because of PHP way to handle scope, we just pass a "pointer" to $this->breadcrumbs.


?>

<h1><?php echo $localization->name; ?></h1>

<?php  $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$products,
	'itemView'=>'_product',
));  ?>
