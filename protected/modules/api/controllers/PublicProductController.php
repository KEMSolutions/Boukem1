<?php

class PublicProductController extends APIController
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
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->renderJSON($model->getStructuredProductArray());
		
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the POST payload.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param array $payload the entire request payload
	 * @return Product the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		
		
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	
}