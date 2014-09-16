<?php

class PublicLayoutController extends APIController
{
	
	protected $public_api = true;
	protected $require_authentification = false;
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			
		);
	}
	
	
	/**
	 * View a particular product, with localizations and images associated.
	 */
	public function actionIndex()
	{
		
		
		if (Yii::app()->user->isGuest){
			$cache_id = Yii::app()->request->hostInfo . " Api/LayoutController:[indexForLanguageGuest] " . Yii::app()->language;
			$cache_duration = 600;//10800;
		} else {
			$cache_id = Yii::app()->request->hostInfo . " Api/LayoutController:[indexForLanguageUser] " . Yii::app()->language . " - " . Yii::app()->user->user->id;
			$cache_duration = 1600;
		}
		
		$layout_array = Yii::app()->cache->get($cache_id);
		
		if (!$layout_array){
			
			$layout_parameters = array('storeid'=>Yii::app()->params['outbound_api_user'], 'storekey'=>Yii::app()->params['outbound_api_secret'], 'locale'=>Yii::app()->language . "_CA", 'layout_type'=>Yii::app()->params['mainPageLayout']);
			
			if (!Yii::app()->user->isGuest){
				$layout_parameters["email"] = Yii::app()->user->user->email;
			}
			
			$output = Yii::app()->curl->get("https://kle-en-main.com/CloudServices/index.php/Layout/boukem/mobileIndex", $layout_parameters);
			
			
			$base_dict = json_decode($output);
			
			
			$layout_array = array();
			foreach ($base_dict->promoted as $promoted_id){
				$product = Product::model()->findByPk($promoted_id);
				
				if ($product && $product->visible == 1 && $product->productLocalization){
					$layout_array[] = $product->getStructuredProductArray();
				}
				
			}
			
			
			
			Yii::app()->cache->set($cache_id, $layout_array, $cache_duration);
		}
		
		
		
		
		$this->renderJSON($layout_array);
		
	}
	
	
	
}