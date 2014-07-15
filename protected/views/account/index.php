<?php
$this->pageTitle = Yii::t("app", "Compte") . " - " . Yii::app()->name;
?>



<div class="col-md-4">
	<span class="title"><?php echo Yii::t('app', "Compte"); ?></span>
<div class="list-group">
  <a href="<?php echo $this->createUrl("updatePassword"); ?>" class="list-group-item">
    <span class="badge"><i class="fa fa-key"></i></span><?php echo Yii::t('app', "Changer de mot de passe"); ?>
  </a>
 
</div>
</div>

<div class="col-md-8">
	<span class="title"><?php echo Yii::t('app', "Historique de commandes"); ?></span>
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
	
	
</div>