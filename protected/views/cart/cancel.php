<?php
/* @var $this CartController */
/* @var $order Order */

$this->pageTitle = Yii::t("app", "Annulation");

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
                                    <i class="fa fa-exclamation-triangle"></i>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <h4><?php echo Yii::t("app", "Votre commande a été annulée."); ?></h4>
                                <p><?php echo Yii::t("app", "Vous avez annulés le processus de commande. Nous ne préparons les commandes qu'une fois payées. N'hésitez pas à nous contacter si vous avez des questions sur le processus de paiement."); ?></p>
								
								<p><?php echo Yii::t("app", "Pour reprendre le processus de paiement, rendez-vous simplement dans votre panier."); ?><br><a href="<?php echo $this->createUrl("cart/index"); ?>" class="btn btn-three"><i class="fa fa-shopping-cart"></i> <?php echo Yii::t("app", "Panier"); ?></a></p>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</section>
