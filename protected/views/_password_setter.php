<?php
	
	$cs = Yii::app()->clientScript;
	$cs->registerScriptFile('/js/hideShowPassword.min.js', CClientScript::POS_END);
	$cs->registerCssFile('/css/show-hide-password.min.css');
	
	
	$cs->registerScript('password_setter_reveal_password', "
			
			$('#password-setter-input-field').hidePassword(true);
			" ,CClientScript::POS_READY);
?>

<section class="slice color-one">
	<div class="w-section inverse">
    	<div class="container">
        	<div class="row">
                <div class="col-md-12">
                	<div class="text-center">
                        
						
						<h2><?php echo Yii::t("app", "Créer un mot de passe"); ?></h2>
                        <p>
                           <?php echo Yii::t("app", "Retrouvez la liste de vos achats précédents et obtenez le statut de vos commandes en créant un mot de passe."); ?>
                        </p>
						
						<form class="form-inline" role="form" method="post" action="<?php echo $this->createUrl("/Site/createPassword"); ?>">
						  <div class="form-group">
						    <label class="sr-only" for="password-setter-input-field"><?php echo Yii::t("app", "Mot de passe"); ?></label>
						    <input class="login-field  login-field-password form-control" autofocus id="password-setter-input-field" type="password" placeholder="<?php echo Yii::t("app", "Mot de passe"); ?>" name="password">
						  </div>
						  <button type="submit" class="btn btn-default"><?php echo Yii::t("app", "Créer le mot de passe"); ?></button>
						</form>
						
						
				
                        <span class="clearfix"></span>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
  
    
</section>

