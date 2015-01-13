<div id="modal_cart"></div>
<div id="cart-container">
	<div class="proceed btn-group btn-group-justified">
		<a class="btn btn-two btn-lg" id="back"><?php echo Yii::t("app", "Continuer le magasinage"); ?></a>
		<?php echo CHtml::link(Yii::t("app", "Passer à la caisse"), "/cart/index", array('class'=>'btn btn-three btn-lg', 'id'=>'checkout')); ?>
	</div>
	<div id="cart-items">
		<ul class="cart-items-list">            
		</ul>
	</div>
</div>

<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://kle-en-main.com/CloudAnalytics/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', <?php echo Yii::app()->params['kem_analytics_id']; ?>]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="http://kle-en-main.com/CloudAnalytics/piwik.php?idsite=<?php echo Yii::app()->params['__KEM_ANALYTICS_ID__']; ?>" style="border:0;" alt="" /></p></noscript>