<?php

class PublicProductController extends APIController
{
	
	protected $public_api = false;
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
	public function actionView()
	{

		$payload = $this->extractJSON();
		$product = $this->loadModel($payload);

		$product_dict = array("id"=>$product->id, "sku"=>$product->sku, "barcode"=>$product->barcode, "brand_id"=>$product->brand_id, "discontinued"=>$product->discontinued, "visible"=>$product->visible, "taxable"=>$product->taxable, "price"=>$product->price, "weight"=>$product->weight, "parent_product_id"=>$product->parent_product_id);

		$product_dict["localizations"] = array();

		foreach ($product->productLocalizations as $productLocalization) {

			$product_dict["localizations"][$productLocalization->locale_id] = array("id"=>$productLocalization->id, "name"=>$productLocalization->name, "long_description"=>$productLocalization->long_description, "short_description"=>$productLocalization->short_description, "slug"=>$productLocalization->slug);
		
		}


		$this->renderJSON($product_dict);

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
		
		
		$model=Product::model()->findByPk($payload->id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	
}