<?php
/* @var $this CategoryController */
/* @var $model Category */

// Will append each mother category to the breadcrumbs so we can show a tree like structure to the users. Because of PHP way to handle scope, we just pass a "pointer" to $this->breadcrumbs.


$this->pageTitle = $localization->name;
?>

<nav class="navbar navbar-default navbar-fixed-bottom animated bounceInUp" role="navigation">
  <div class="container">
    <button class="btn btn-success navbar-btn pull-right buymultiple"><?php echo Yii::t("b2b", "Enregistrer les quantités"); ?></button>
  </div>
</nav>


<section class="slice animate-hover-slide">
	<div class="w-section inverse blog-grid">

<?php  $this->widget('CCustomListView', array(
	'dataProvider'=>$products,
	'itemView'=>'_listproduct',
	'ajaxUpdate'=>false,
	'itemsCssClass'=>'table table-hover',
	'itemsTagName'=>'table',
	'itemsHtmlOptions' => array('id' => 'product_list_table'),
	'pagerCssClass'=>"row pagination",
));  ?>
	    </div>

	</section>