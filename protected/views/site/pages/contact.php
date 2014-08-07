<?php
/* @var $this SiteController */

$this->pageTitle = Yii::t('app', 'Contact');
$this->breadcrumbs=null;

$this->layout = "//layouts/freestyle";


?>

<section class="slice color-two">
	<div class="w-section inverse">
    	<div class="container">
        	<div class="row">
                <div class="col-md-6">
                    <h2><?php echo Yii::t('app', 'Nous contacter'); ?></h2>
                    <p>
                    <?php echo Yii::t('app', "Notre équipe de professionnels est à l'écoute de vos besoins: que vous ayez des questions sur nos produits ou sur une commande passée avec nous, n'hésitez pas à nous envoyer un message."); ?>
                    </p>
                    
                  <?php /*?>  <h2>Send us a message</h2>
                    <form class="form-default" role="form">
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" placeholder="Your name">
                        </div>
                        <div class="row">
                        	<div class="col-md-6">
                                <div class="form-group">
                            		<input type="email" class="form-control" id="email" placeholder="Email address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                            		<input type="text" class="form-control" id="phone" placeholder="Phone number">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="subject" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="message" placeholder="Write you message here..." style="height:100px;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-three pull-right">Send message</button>
                    </form> */ ?>
                </div>
                <div class="col-md-5 col-md-offset-1">
                <div class="row">
                	<div class="col-xs-12">
                	<h2><?php echo Yii::t('app', 'Notre magasin'); ?></h2>
                    <address class="contact-info" itemscope itemtype="http://schema.org/Store">
						
						
                    	
                        
                        <h4><?php echo Yii::t('app', 'Courriel'); ?></h4>
                        <p><a href="mailto:<?php echo Yii::app()->params['adminEmail']; ?>"><?php echo Yii::app()->params['adminEmail']; ?></a></p>
                        
                        
                    </address>
                    </div>
                    
                    </div>
                	
                </div>
            </div>
        </div>
    </div>

</section>