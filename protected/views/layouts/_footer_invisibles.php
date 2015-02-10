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
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://analytics.kem.guru/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', <?php echo Yii::app()->params['kem_analytics_id']; ?>]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//analytics.kem.guru/piwik.php?idsite=<?php echo Yii::app()->params['__KEM_ANALYTICS_ID__']; ?>" style="border:0;" alt="" /></p></noscript>
<?php if (isset(Yii::app()->params["google_analytics_tracking_id"]) && Yii::app()->params["google_analytics_tracking_id"] !== null): ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo Yii::app()->params["google_analytics_tracking_id"]; ?>', 'auto');
  ga('send', 'pageview');
  <?php if (!Yii::app()->user->isGuest): ?>ga('set', '&uid', "<?php echo Yii::app()->user->user->id; ?>");<?php endif; ?>
</script>
<?php endif; ?>