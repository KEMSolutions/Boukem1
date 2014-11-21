<?php
/* @var $this SiteController */

$this->pageTitle = Yii::t('app', 'Conditions d\'utilisation');


$cache_id = Yii::app()->request->hostInfo . " SiteController:[contract]terms " . Yii::app()->language;
$cache_duration = 1800;

$layout_html = Yii::app()->cache->get($cache_id);

if (!$layout_html){
	$layout_html = Yii::app()->curl->post("https://kle-en-main.com/CloudServices/index.php/BoukemAPI/contract/terms", array('locale'=>Yii::app()->language . "_CA", 'store_id'=>Yii::app()->params['outbound_api_user'], 'store_key'=>Yii::app()->params['outbound_api_secret']));
	Yii::app()->cache->set($cache_id, $layout_html, $cache_duration);
}

echo $layout_html;

?>