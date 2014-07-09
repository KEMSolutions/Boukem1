<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo Yii::t('app', 'Fermer'); ?></span></button>
        <h4 class="modal-title" id="cartModalLabel"><?php echo Yii::t('app', 'Panier'); ?></h4>
      </div>
      <div class="modal-body">
		<ul class="media-list" id="cart_modal_items">
		</ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('app', 'Continuer les achats'); ?></button>
        <a href="<?php echo $this->createUrl("Cart/index"); ?>" type="button" class="btn btn-primary"><?php echo Yii::t('app', 'Passer à la caisse'); ?></a>
      </div>
    </div>
  </div>
</div>