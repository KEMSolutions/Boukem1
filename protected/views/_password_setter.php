<?php
	
	$cs = Yii::app()->clientScript;
	$cs->registerScriptFile('/js/modernizr.custom.js', CClientScript::POS_END);
	$cs->registerScriptFile('/js/hideShowPassword.min.js', CClientScript::POS_END);
	$cs->registerCssFile('/css/show-hide-password.min.css');
	
	
	$cs->registerScript('password_setter_reveal_password', "
			
			$('#password-setter-input-field').hidePassword(true);
			" ,CClientScript::POS_READY);
?>
<section class="container" id="password_setter">
	
	<div class="row">
		<div class="col-xs-12">
			
			
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo Yii::t("app", "Créer un mot de passe"); ?></h3>
				</div>
			  <div class="panel-body">
			    <?php echo Yii::t("app", "Retrouvez la liste de vos achats précédents et obtenez le statut de vos commandes en créant un mot de passe."); ?>
			  </div>
			  <div class="panel-footer">
			  	
				
				<form class="form-inline" role="form" method="post" action="<?php echo $this->createUrl("/Site/createPassword"); ?>">
				  <div class="form-group">
				    <label class="sr-only" for="password-setter-input-field"><?php echo Yii::t("app", "Mot de passe"); ?></label>
				    <input class="login-field  login-field-password form-control" autofocus id="password-setter-input-field" type="password" placeholder="<?php echo Yii::t("app", "Mot de passe"); ?>" name="password">
				  </div>
				  <button type="submit" class="btn btn-default"><?php echo Yii::t("app", "Créer le mot de passe"); ?></button>
				</form>
				

				
				
			  </div>
			</div>
			
			
		</div>
	</div>
	
</section>