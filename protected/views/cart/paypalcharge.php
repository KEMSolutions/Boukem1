<?php
/* @var $this CartController */
/* @var $order Order */

$this->pageTitle = Yii::t("app", "Confirmation");

$cs = Yii::app()->clientScript;

$charge_url = $this->createUrl("chargePaypal", array("order"=>$model->id, "token"=>CHtml::encode($token)));
$localized_expired_error = Yii::t("app", "Le lien de paiement a expiré.");

$googleAnalytics = "";
if (isset(Yii::app()->params["google_analytics_tracking_id"]) && Yii::app()->params["google_analytics_tracking_id"] !== null){
	
	$store_name = Yii::app()->name;
	$revenue = $model->orderDetails->total;
	$tax = $model->orderDetails->taxes;
	$shipping = $model->orderDetails->shipping;
	
	$googleAnalytics = "
	
		ga('require', 'ecommerce');
		ga('ecommerce:addTransaction', {
			'id': '$model->id',
			'affiliation': \"$store_name\",
			'revenue': '$revenue',
			'shipping': '$shipping',
			'tax': '$tax',
			'currency': 'CAD'
		});
	
		ga('ecommerce:send');
		";

} // End of Google analytics ecommerce data

$cs->registerScript('charge_paypal',"

function sendEcommerceTransactionToGoogleAnalytics(){
	$googleAnalytics
}

$('.passwordsetter').hide();
$('#success_indicator').hide();
$('#failure_indicator').hide();


$('#continue_button').click(function(){
	
	window.location.replace('/');
	
});

$.post( '$charge_url', function( data ) {
	

	$('#progress_indicator').addClass('animated fadeOutLeftBig');
	if (data.status == 'success'){
		
		sendEcommerceTransactionToGoogleAnalytics();
		
		
		$('#progress_indicator').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
			$('#progress_indicator').hide();
			$('#success_indicator').show();
			$('#success_indicator').addClass('animated fadeInRightBig');
			$('#success_indicator').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
				$('.icon-feature').addClass('animated tada');
			});
	
		});
		
		
	} else {
		
		// Error
		
		var error_message = data.error;
		if (data.error == 'expired'){
			error_message = '$localized_expired_error';
		}
		$('#error_message').text(error_message);
		
		$('#progress_indicator').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
			$('#progress_indicator').hide();
			$('#failure_indicator').show();
			$('#failure_indicator').addClass('animated fadeInLeftBig');
			$('#failure_indicator').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
				$('.icon-feature').addClass('animated shake');
			});
	
		});
		
		
	}
	
	
	
	
});





" ,CClientScript::POS_END);



?>


<section class="slice" id="progress_indicator">
	<div class="w-section inverse">
        <div class="container">
        	<div class="row">
                <div class="col-xs-12">
                    <div class="aside-feature">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="icon-feature">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <h4><?php echo Yii::t("app", "Veuiller patienter"); ?></h4>
                                <p><?php echo Yii::t("app", "Votre paiement est présentement en train d'être traitée par Paypal. Ne quittez et ne rechargez pas cette page au risque de voir votre commande annulée ou chargée plus d'une fois."); ?></p>
								
								<p class="small"><?php echo Yii::t("app", "En cas de problème, contactez nous au <a href='mailto:{contact_email}'>{contact_email}</a> ou au {contact_phone}.", array("{contact_phone}"=>"1-844-276-3434 ext. " . Yii::app()->params['outbound_api_user'], "{contact_email}"=>Yii::app()->params['adminEmail']))?></p>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</section>


<section class="slice result-bar" id="success_indicator">
	<div class="w-section inverse">
        <div class="container">
        	<div class="row">
                <div class="col-xs-12">
                    <div class="aside-feature">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="icon-feature">
                                    <i class="fa fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <h4><?php echo Yii::t("app", "Votre commande a été reçue."); ?></h4>
                                <p><?php echo Yii::t("app", "Merci pour votre commande! Vous recevrez au cours des prochaines minutes un courriel de confirmation de la réception de votre commande. N'hésitez pas à répondre directement à ce courriel pour toute question concernant celle-ci."); ?></p>
								<button class="btn btn-one" id="continue_button"><?php echo Yii::t("app", "Continuer"); ?></button>

                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</section>

<section class="slice result-bar" id="failure_indicator">
	<div class="w-section inverse">
        <div class="container">
        	<div class="row">
                <div class="col-xs-12">
                    <div class="aside-feature">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="icon-feature">
                                    <i class="fa fa-exclamation-triangle"></i>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <h4><?php echo Yii::t("app", "Oups...une erreur est survenue!"); ?></h4>
								<p id="error_message"></p>
								<p class="small"><?php echo Yii::t("app", "Certaines situations peuvent entrainer un rejet initial de votre commande par Paypal. Dans un tel cas, vous recevriez un courriel de Paypal et de notre magasin au cours des prochaines minutes. Si le problème persiste et aucune confirmation de commande ne vous parvient, contactez nous au <a href='mailto:{contact_email}'>{contact_email}</a> ou au {contact_phone}.", array("{contact_phone}"=>"1-844-276-3434 ext. " . Yii::app()->params['outbound_api_user'], "{contact_email}"=>Yii::app()->params['adminEmail']))?></p>
								
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</section>
