<?php

class OrderController extends APIController
{
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'postOnly + delete, refreshStatus', // we only allow deletion via POST request
		);
	}
	
	
	
	
	/**
	 * Retrieve order information.
	 * Will output a json dict of the order
	 */
	public function actionView(){
		$payload = $this->extractJSON();
		$order = $this->loadModel($payload);
		
		$output = $order->frontendData();
		
		$this->renderJSON($output);
	}
	
	/**
	 * Calling this function will update the order's balance and status according to info found on server.
	 */
	public function actionRefreshStatus(){
		
		$payload = $this->extractJSON();
		$order = $this->loadModel($payload);
		
		$order->cart = 0;
		
		
		$output = Yii::app()->curl->post("https://kle-en-main.com/CloudServices/index.php/BoukemAPI/default/balanceForOrder", array('order_id'=>$order->id, 'store_id'=>Yii::app()->params['outbound_api_user'], 'store_key'=>Yii::app()->params['outbound_api_secret']));
		
		
		$payload = json_decode($output);
		
		$order->status = $payload->status;
		
		$order->orderDetails->balance = $payload->balance;
		
		$order->orderDetails->save();
		$order->save();
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
		$model=Order::model()->findByPk($payload->id);
		if($model===null)
			throw new CHttpException(404,'The requested order does not exist.');
		return $model;
	}
	
	
}