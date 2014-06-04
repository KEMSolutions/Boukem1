<?php
/* @var $this MainStoreProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Produits' => array('index'),
	'Rechercher',
);

$this->pageTitle = "Rechercher";



?>

<h2>Rechercher un produit</h2>

<div class="widget">
    <form class="form-inline" method="get" action="<?php echo Yii::app()->createUrl("search"); ?>">
        <div class="input-group">
			
            <input type="text" name="q" class="form-control" value="<?php echo CHtml::encode($q); ?>" placeholder="Nom de produit" />
            <span class="input-group-btn">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Rechercher</button>
            </span>
        </div>
    </form>
</div>



<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_searchview',
	'pagerCssClass'=>"pagination",
)); ?>
