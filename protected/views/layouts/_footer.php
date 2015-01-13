<footer>
    <div class="container">
		
		<div class="row">
			<?php if (!$this->isB2b()): ?>
            <div class="col-md-4">
            	<div class="col">
                   <h4><?php echo Yii::t('app', 'Information'); ?></h4>
      			<ul>
      				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'about')); ?>"><?php echo Yii::t('app', 'À propos de la boutique'); ?></a></li>
      				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'privacy')); ?>"><?php echo Yii::t('app', 'Politique de confidentialité'); ?></a></li>
      				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'terms')); ?>"><?php echo Yii::t('app', "Conditions d'utilisation"); ?></a></li>
      				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'shipping')); ?>"><?php echo Yii::t('app', "Méthodes d'expédition"); ?></a></li>
      			</ul>
                 </div>
            </div>
            
            <div class="col-md-4">
            	<div class="col">
                    <h4><?php echo Yii::t('app', 'Accès rapide'); ?></h4>
        			<ul>
        				<li><a href="catalogue.html"><?php echo Yii::t('app', 'Accueil'); ?></a></li>
						<?php
						echo $category_links_html;
						?>
        			</ul>
                </div>
            </div>
            <?php endif; ?>
            
             <div class="col-md-4">
             	<div class="col">
                    <h4><?php echo Yii::t('app', 'Service à la clientèle'); ?></h4>
        			<ul>
        				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'contact')); ?>"><?php echo Yii::t('app', 'Nous contacter'); ?></a></li>
        				<li><a href="<?php echo $this->createUrl('site/page', array('view'=>'returns')); ?>"><?php echo Yii::t('app', 'Retours et échanges'); ?></a></li>
        				<li><a href="<?php echo $this->createUrl('account/index'); ?>"><?php echo Yii::t('app', 'Compte'); ?></a></li>
				  		  <?php if (Yii::app()->user->isGuest):?>
		  
				  		  <li><a href=""><?php echo CHtml::link(Yii::t('app', 'Devenir membre ou se connecter'), array('site/register')); ?></a></li>
		  
				  	  <?php else: ?>
		  
				  		  <li><?php echo CHtml::link(Yii::t('app', 'Se déconnecter'), array('site/logout')); ?></li>
		  
				  		  <?php endif;?>
        			</ul>
                </div>
            </div>
			
        </div>
		
	
	  <hr />
        <div class="row">
        	<div class="col-lg-9 copyright">
            	&copy; <?php echo date("Y"); ?>, <?php echo Yii::t('app', 'tous droits réservés'); ?>.
            </div>
            <div class="col-lg-3 footer-logo text-right">
            	<img src="/images/kem_signature.png" alt="Powered by KEM">
            </div>
        </div>
    </div>
</footer><!-- JavaScript -->