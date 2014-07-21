<?php
/* @var $this CategoryController */
/* @var $model Category */

// Will append each mother category to the breadcrumbs so we can show a tree like structure to the users. Because of PHP way to handle scope, we just pass a "pointer" to $this->breadcrumbs.


$this->pageTitle = $localization->name;

		
?>
<section class="slice animate-hover-slide">
	<div class="w-section inverse blog-grid">

<?php  $this->widget('CCustomListView', array(
	'dataProvider'=>$products,
	'itemView'=>'_product',
	'ajaxUpdate'=>false,
	'itemsCssClass'=>'row',
	'itemsHtmlOptions' => array('id' => 'masonryWr'),
	'pagerCssClass'=>"row pagination",
));  ?>
	    </div>

	</section>