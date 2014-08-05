<?php
$this->pageTitle = Yii::t("app", "Compte");

if (!$this->isB2b()) {
	$this->menu=array(array('label'=>Yii::t('app', "Changer de mot de passe"), 'url'=>array('account/updatePassword')));
}

?>



	<h3><?php echo Yii::t('app', "Historique de commandes"); ?></h3>
	<?php

	$this->widget('zii.widgets.grid.CGridView', array(
	    'dataProvider'=>$orders,
		'itemsCssClass'=>"table table-striped",
		'columns'=>array(
			"order_number",
			"timestamp",
			array(
				'name'=>'Status',
				'value'=>'Order::localizedStatus($data->status)',
			),
		),
	));
	
	  ?>
	
	