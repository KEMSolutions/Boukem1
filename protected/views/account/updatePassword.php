<?php
$this->pageTitle = Yii::t("app", "Changer de mot de passe");
	
$this->breadcrumbs = array(
	Yii::t("app", "Compte") => array('account/index'),
	Yii::t("app", "Changer de mot de passe")
);
	
	$cs = Yii::app()->clientScript;
	$cs->registerScriptFile('/js/modernizr.custom.js', CClientScript::POS_END);
	$cs->registerScriptFile('/js/hideShowPassword.min.js', CClientScript::POS_END);
	$cs->registerCssFile('/css/show-hide-password.min.css');
	
	
	$cs->registerScript('password_update_reveal_password', "
			
			$('#new_password').hidePassword(true);
			" ,CClientScript::POS_READY);
?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'htmlOptions'=>array('class'=>"form-horizontal"),
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($models=$model, $header=null, $footer=null, $htmlOptions=array('class'=>'alert alert-danger animated shake')); ?>

  <div class="form-group">
    <label for="old_password" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'old_password'); ?></label>
    <div class="col-sm-9">
		<?php echo $form->passwordField($model,'old_password',array('class'=>'form-control','id'=>'old_password', 'required'=>'required')); ?>
      <?php echo $form->error($model,'old_password', array('class'=>'text-danger')); ?>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'new_password'); ?></label>
    <div class="col-sm-9">
      <?php echo $form->passwordField($model,'new_password',array('class'=>'form-control','id'=>'new_password', 'required'=>'required')); ?>
    </div>
  </div>
 
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
		<?php echo CHtml::submitButton(Yii::t('app', "Enregistrer"), array('class'=>"btn btn-primary")); ?>
    </div>
  </div>
<?php $this->endWidget(); ?>