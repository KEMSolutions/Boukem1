<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>


<div class="col-lg-8 col-sm-12 hero-feature">
	
	<span class="title"><?php echo Yii::t("app", "Devenir membre")?></span>
	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-register-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->emailField($model,'email', array('class'=>"form-control")); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password', array('class'=>"form-control")); ?>
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
	
	<span class="title"><?php echo Yii::t("app", "Déjà membre?")?></span>
	
	<a href="<?php echo $this->createUrl('login'); ?>" class="btn btn-success btn-block"><?php echo Yii::t('app', "Se connecter"); ?></a>
	
</div>