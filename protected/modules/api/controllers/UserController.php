<?php

class UserController extends APIController
{
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	
	
	
	/**
	 * Retrieve order information.
	 * Will output a json dict of the order
	 */
	public function actionView(){
		$payload = $this->extractJSON();
		$customer = $this->loadModel($payload);
		
		$output = array();
		$output["id"] = $customer->id;
		$output["timestamp"] = $customer->timestamp;
		$output["email"] = $customer->email;
		$output["firstname"] = $customer->firstname;
		$output["lastname"] = $customer->lastname;
		$output["locale"] = $customer->locale_id;
		
		
		if ($customer->postcode){
			$output["postcode"] = $customer->postcode;
		} else {
			if (count($customer->addresses) > 0)
			$output["postcode"] = $customer->addresses[0]->postcode;
		}
		
		
		
		
		
		$this->renderJSON($output);
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the POST payload.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param array $payload the entire request payload
	 * @return Product the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($payload)
	{
		$model=User::model()->findByPk($payload->id);
		if($model===null)
			throw new CHttpException(404,'The requested order does not exist.');
		return $model;
	}
	
	
}