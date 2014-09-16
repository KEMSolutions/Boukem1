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
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		
		$product = Product::model()->findByPk(52);
		
		
		$this->renderJSON($product->getStructuredProductArray());

	}
	
	
	
}