<?php
/* @var $this MainStoreProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Produits' => array('index'),
	'Rechercher',
);

if ($q){
	$this->pageTitle = CHtml::encode($q) . " - " . Yii::t("app", "Rechercher") . " - " . Yii::app()->name;
}



?>

        		<div class="col-lg-12 col-sm-12">
            		<span class="title"><?php echo Yii::t("app", "Rechercher") . " : " . CHtml::encode($q); ?></span>
					
					


					<div class="widget">
					    <form class="form-inline" method="get" action="<?php echo Yii::app()->createUrl("search"); ?>">
					        <div class="input-group">
			
					            <input type="text" name="q" class="form-control" value="<?php echo CHtml::encode($q); ?>" placeholder="<?php echo Yii::t("app", 'Nom du produit, marque ou usage'); ?>" />
					            <span class="input-group-btn">
					                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> <?php echo Yii::t("app", "Rechercher"); ?></button>
					            </span>
					        </div>
					    </form>
					</div>
					
            	</div>




<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_searchview',
	'pagerCssClass'=>"pagination",
)); ?>
