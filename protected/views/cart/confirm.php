<?php
/* @var $this CartController */
/* @var $order Order */

$this->pageTitle = Yii::t("app", "Confirmation");

?>

<section class="slice">
	<div class="w-section inverse">
        <div class="container">
        	<div class="row">
                <div class="col-xs-12">
                    <div class="aside-feature">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="icon-feature animated bounceIn">
                                    <i class="fa fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <h4><?php echo Yii::t("app", "Votre commande a été reçue."); ?></h4>
                                <p><?php echo Yii::t("app", "Merci pour votre commande! Vous recevrez au cours des prochaines minutes un courriel de confirmation de la réception de votre commande. N'hésitez pas à répondre directement à ce courriel pour toute question concernant celle-ci."); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</section>
