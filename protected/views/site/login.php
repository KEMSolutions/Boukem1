<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->breadcrumbs=array(
	Yii::t('app','Connexion'),
);
?>

<div class="col-lg-8 col-sm-12 hero-feature">
	<span class="title"><?php echo Yii::t("app", "Connexion")?></span>

<p><?php echo Yii::t("app", "Veuillez renseigner les champs avec vos informations de connexion:"); ?></p>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array("role"=>"form")
)); ?>


	<div class="form-group">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username', array('class'=>"form-control")); ?>
		<?php echo $form->error($model,'username', array('class'=>'alert alert-danger')); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password', array('class'=>"form-control")); ?>
		<?php echo $form->error($model,'password', array('class'=>'alert alert-danger')); ?>
	</div>

	<div class="checkbox">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
	</div>

		<?php echo CHtml::submitButton('Login', array('class'=>"btn btn-primary")); ?>

<?php $this->endWidget(); ?>
</div>

<div class="col-lg-4 col-sm-12">
	
	<span class="title"><?php echo Yii::t("app", "Pas de compte?")?></span>
	
	<a href="<?php echo $this->createUrl('register'); ?>" class="btn btn-success btn-block"><?php echo Yii::t('app', "Devenir membre"); ?></a>
	
</div>