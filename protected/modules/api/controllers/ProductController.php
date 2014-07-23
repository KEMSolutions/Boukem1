<?php

class ProductController extends APIController
{
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'postOnly + create', // we only allow deletion via POST request
			'postOnly + delete', // we only allow deletion via POST request
			'postOnly + update', // we only allow deletion via POST request
		);
	}
	
	
	protected function updateProductFromPayload($product, $payload){
		$product->sku = $payload->sku;
		$product->barcode = $payload->barcode;
		
		$product->brand_id = $payload->brand; // We use the actual brand id as is
		$product->discontinued = $payload->discontinued;
		$product->visible = $payload->enabled; // Pay attention: small name change here
		$product->taxable = $payload->taxable;
		
		$product->price = $payload->price;
		$product->weight = $payload->weight;
		$product->parent_product_id = $payload->parent_product_id;
		$product->save();
		
		
		// We insert the images before the localization so we can save the localizations with an image for quick elasticsearch reference
		// Clean up all previous images
		foreach ($product->productImages as $image){
			$image->delete();
		}
		foreach ($payload->images as $image){
			
			
			
			$productimg = new ProductImage;
			$productimg->product_id = $product->id;
			$productimg->extension = $image->extension;
			$productimg->identifier = $image->id;
			$productimg->position = $image->position;
			$productimg->locale_id = Locale::localeIdFromLongCode($image->locale);
			$productimg->save();
		}
		
		
		// Clean up all previous localizations
		foreach ($product->productLocalizations as $localization){
			$localization->delete();
		}
		foreach ($payload->localizations as $localization) {
			
			
			
			$productLocalization = new ProductLocalization;
			$productLocalization->product_id = $product->id;
			$productLocalization->locale_id = Locale::localeIdFromLongCode($localization->locale);
			
			$productLocalization->name = $localization->name;
			$productLocalization->short_description = $localization->short_description;
			$productLocalization->long_description = $localization->long_description;
			$productLocalization->visible = $localization->enabled;
			
			$productLocalization->save();
			
		}
		
		
		$previousRelationships = ProductHasCategory::model()->findAll("product_id=:product_id", array(':product_id'=>$product->id));
		foreach ($previousRelationships as $relat){
			$relat->delete();
		}
		
		foreach ($payload->categories as $category){
			
			
			// Check for existing relationships... we encounter some duplicates sometimes
			$existingRelationship = ProductHasCategory::model()->find("product_id=:product_id AND category_id=:category_id", array(':product_id'=>$product->id, ':category_id'=>$category));
			
			if ($existingRelationship === null){
				$catrel = new ProductHasCategory;
				$catrel->product_id = $product->id;
				$catrel->category_id = $category;
				$catrel->save();
				
			}
			
			
			
		}
		
		
		
		return $product;
	}
	
	/**
	 * Create a new product.
	 * Takes a json encoded model object
	 * if the new model save's succeeds, will output the JSON encoded model including it's newly assigned ID.
	 * @param str $client API user name. The request
	 */
	public function actionCreate()
	{
		
		$payload = $this->extractJSON();
		
		$product = new Product;
		
		$product = $this->updateProductFromPayload($product, $payload);
		
		$this->renderJSON($product);
		
	}

	public function actionDelete()
	{
		
		$payload = $this->extractJSON();
		$model = $this->loadModel($payload);
		$model->delete();
	}

	/**
	 * Updates a particular product. Takes a json payload with a mandatory ID.
	 */
	public function actionUpdate()
	{
		
		$payload = $this->extractJSON();
		$product = $this->loadModel($payload);
		
		$product = $this->updateProductFromPayload($product, $payload);
		
		$this->renderJSON($product);
		
		
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