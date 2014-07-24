<?php

class RebateController extends APIController
{
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'postOnly + create', // we only allow deletion via POST request
			'postOnly + delete', // we only allow deletion via POST request
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
		
		$rebate = new ProductRebate;
		
		$rebate->product_id = $payload->product_id;
		$rebate->price = $payload->price;
		$rebate->valid_from = $payload->starts;
		$rebate->valid_until = $payload->ends;
		$rebate->save();
		
		
		
		$this->renderJSON($rebate);
		
	}

	public function actionDelete()
	{
		
		$payload = $this->extractJSON();
		
		$rebate = ProductRebate::model()->find("product_id=:product_id AND valid_from=:valid_from AND valid_until=:valid_until", array(":product_id"=>$payload->product_id, ":valid_from"=>$payload->starts, ":valid_until"=>$payload->ends));
		
		$rebate->delete();
		
	}


	
}