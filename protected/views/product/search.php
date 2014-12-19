<?php
/* @var $this MainStoreProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=null;

if ($q){
	$this->pageTitle = Yii::t("app", "Rechercher") . ": " . CHtml::encode($q);
}

?>

<?php echo $search_html; ?>
