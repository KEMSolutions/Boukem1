<?php
$this->pageTitle = Yii::t("app", "Compte") . " - " . Yii::app()->name;
?>
<span class="title"><?php echo Yii::t('app', "Compte"); ?></span>

<div class="list-group">
  <a href="<?php echo $this->createUrl("updatePassword"); ?>" class="list-group-item">
    <span class="badge"><i class="fa fa-key"></i></span><?php echo Yii::t('app', "Changer de mot de passe"); ?>
  </a>
 
</div>