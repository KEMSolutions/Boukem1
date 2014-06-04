<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->breadcrumbs=array(
	Yii::t('app','Connexion'),
);
?>

<h1><?php echo Yii::t("app", "Connexion") ?></h1>

<p><?php echo Yii::t("app", "Veuillez renseigner les champs avec vos informations de connexion:"); ?></p>

<div class="form">
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
		
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password', array('class'=>"form-control")); ?>
		
	</div>

	<div class="checkbox">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
	</div>

		<?php echo CHtml::submitButton('Login', array('class'=>"btn btn-primary")); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->
