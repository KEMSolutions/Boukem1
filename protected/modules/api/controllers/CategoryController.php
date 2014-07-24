<?php

class CategoryController extends APIController
{
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'postOnly + batchcreate', // we only allow deletion via POST request
			'postOnly + delete', // we only allow deletion via POST request
			'postOnly + update', // we only allow deletion via POST request
			'postOnly + create', // we only allow deletion via POST request
		);
	}
	
	
	protected function updateCategoryFromPayload($category, $payload){
		$category->parent_category = $payload->parent_id;
		$category->visible = $payload->visible;
		$category->is_brand = $payload->is_brand;
		
		$category->save();
		
		foreach ($payload->localizations as $localization){
			$loc = new CategoryLocalization;
			$loc->locale_id = Locale::localeIdFromLongCode($localization->locale);
			
			$loc->category_id = $category->id;
			$loc->name = $localization->name;
			$loc->visible = $localization->visible;
			$loc->save();
			
		}
		
		return $category;
		
	}
	
	public function actionCreate(){
		
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		
		
		$payload = $this->extractJSON();
		
		$cat = new Category;
		
		$cat = $this->updateCategoryFromPayload($cat, $payload);
		
		$this->renderJSON($cat);
		
		
	}
	
	public function actionDelete()
	{
		
		$payload = $this->extractJSON();
		
		
	}

	/**
	 * Updates a particular product. Takes a json payload with a mandatory ID.
	 */
	public function actionUpdate()
	{
		
		$payload = $this->extractJSON();
		$cat = $this->loadModel($payload);
		
		$cat = $this->updateCategoryFromPayload($cat, $payload);
		
		$this->renderJSON($cat);
		
		
	}
	
	
	/**
	 * Create new categories.
	 * Takes a json encoded array of categories.
	 * Will output an json array of key pairs ["provided id":"saved category id", ]
	 */
	public function actionBatchCreate()
	{
		// We set our output array as global so we can use it in the saveCategory function
		global $output_array;
		
		
		/**
		 * Save new categories based on the received array.
		 * Takes a json encoded category.
		 * Will append a json array of key pairs ["provided id":"saved category id", ] to the $output_array
		 * @param array $category the json to array category
		 * @param int $parent_id the parent ID of the category to save (the one in OUR database, not Kem's central one)
		 */
		function saveCategory($category, $parent_id){
			
			
			$cat = new Category;
			$cat->parent_category = $parent_id;
			$cat->visible = $category->visible;
			$cat->is_brand = $category->is_brand;
			
			$cat->save();
			
			foreach ($category->localizations as $localization){
				$loc = new CategoryLocalization;
				$loc->locale_id = Locale::localeIdFromLongCode($localization->locale);
				
				$loc->category_id = $cat->id;
				$loc->name = $localization->name;
				$loc->visible = $localization->visible;
				$loc->save();
				
			}
			
			
			$GLOBALS['output_array'][$category->id] = $cat->id;
			
			// Think of the the children
			foreach ($category->children as $child){
				saveCategory($child, $cat->id);
			}
			
			
		}
		
		
		$payload = $this->extractJSON();
		
		// We need to proceed recursively so we save parents before their children
		foreach ($payload as $category){
			saveCategory($category, null);
		}
		
		$this->renderJSON($output_array);
		
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
		
		
		$model=Category::model()->findByPk($payload->id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	
}