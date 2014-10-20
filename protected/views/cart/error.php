<?php
/* @var $this CartController */
/* @var $order Order */

$this->pageTitle = Yii::t("app", "Erreur de paiement");

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
                                <h4><?php echo Yii::t("app", "Oups...une erreur est survenue!"); ?></h4>
								<p><?php if ($error == "expired") {
									echo Yii::t("app", "Le lien de paiement a expiré.");
								} else {
									echo $error;
								}
								?></p>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</section>
