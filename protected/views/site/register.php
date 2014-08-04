<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

$this->pageTitle = Yii::t("app", "Devenir membre");

?>


<div class="col-lg-8 col-sm-12">
	
	
	
	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-register-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<legend><?php echo Yii::t("app", "Déjà membre?")?></legend>
	
	<a href="<?php echo $this->createUrl('login'); ?>" class="btn btn-primary"><?php echo Yii::t('app', "Se connecter"); ?></a>
	<hr>
<legend><?php echo Yii::t("app", "Devenir membre")?></legend>
	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->emailField($model,'email', array('class'=>"form-control")); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password', array('class'=>"form-control", 'value' => '',)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname', array('class'=>"form-control")); ?>
		<?php echo $form->error($model,'firstname'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname', array('class'=>"form-control")); ?>
		<?php echo $form->error($model,'lastname'); ?>
	</div>


		<?php echo CHtml::submitButton(Yii::t("app", "Créer le compte"), array('class'=>"btn btn-primary")); ?>

<?php $this->endWidget(); ?>
</div>

<div class="col-lg-4 col-sm-12">
	
	<h3><?php echo Yii::t("app", "Pourquoi devenir membre?"); ?></h3>
    <ul class="list-check">
    	<li><i class="fa fa-check-square"></i> <?php echo Yii::t("app", "C'est 100% gratuit"); ?></li>
        <li><i class="fa fa-check-square"></i> <?php echo Yii::t("app", "Retrouvez l'historique de vos commandes"); ?></li>
        <li><i class="fa fa-check-square"></i> <?php echo Yii::t("app", "Dupliquez vos commandes facilement"); ?></li>
        <li><i class="fa fa-check-square"></i> <?php echo Yii::t("app", "Sauvez du temps en sauvegardant vos adresses"); ?></li>
        <li><i class="fa fa-check-square"></i> <?php echo Yii::t("app", "Bénéficiez de meilleures recommandations"); ?></li>
    </ul>
	
</div>