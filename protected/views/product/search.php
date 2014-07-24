<?php
/* @var $this MainStoreProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=null;

if ($q){
	$this->pageTitle = Yii::t("app", "Rechercher") . ": " . CHtml::encode($q);
}



?>

        		<div class="col-lg-12 col-sm-12">
					
					


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


<section class="slice animate-hover-slide">
	<div class="w-section inverse blog-grid">


<?php $this->widget('CCustomListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_searchview',
	'ajaxUpdate'=>false,
	'itemsCssClass'=>'row',
	'itemsHtmlOptions' => array('id' => 'masonryWr'),
	'pagerCssClass'=>"row pagination",
)); ?>
	    </div>

	</section>