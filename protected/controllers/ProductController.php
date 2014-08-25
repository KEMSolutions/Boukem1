<?php

class ProductController extends WebController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete, thumbnails', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view', 'search', 'thumbnails'),
				'users'=>array('*'),
			),
			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($slug)
	{
		$modelLocalization = $this->loadProductModelSlug($slug);
		$model = $modelLocalization->product;
		
		if (!$model->visible)
			throw new CHttpException(404,Yii::t('app', 'La page demandée n\'existe pas.'));
		
		$localized_brand = $model->brand->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
		
		$this->breadcrumbs = array(
			$localized_brand->name => array("category/view", "slug"=>$localized_brand->slug),
			$modelLocalization->name,
		);
		
		$this->pageTitle = $modelLocalization->name;
		
		$localized_categories[] = array();
		foreach ($model->categories as $category){
			$localized_cat = $category->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
			$localized_categories[] = $localized_cat;
		}
		
		$alternatives = array();
		foreach ($model->productLocalizations as $localization){
			$alternatives[$localization->locale_id] = $this->createAbsoluteUrl("view", array("slug"=>$localization->slug, "language"=>$localization->locale_id));
		}
		$this->alternatives = $alternatives;
				
		$this->render('view',array(
			'model'=>$modelLocalization->product,
			'localization'=>$modelLocalization,
			'brand'=>$localized_brand,
			'localized_categories' => $localized_categories,
		));
	}

	
	/**
	 * Search in all models with elastic search.
	 */
	public function actionSearch($q="")
	{
		if ($q==""){
			$this->redirect("/");
		}
		
		$search = new \YiiElasticSearch\Search;
		
		$search->query = array(
		    "query_string" => array('query'=>$q),
		);
		
		$search->filter = array(
			"term" => array("locale"=>Yii::app()->language, "visible"=>1),
		);
		
		
		
		$dataProvider = new \YiiElasticSearch\DataProvider(ProductLocalization::model(), array(
		        'search' => $search,
		));
		$dataProvider->setPagination(array('pageSize' => 48));
		
		$this->render('search',array(
			'dataProvider'=>$dataProvider,
			'q'=>$q,
		));
	}
	
	/**
	 * Returns the localization model based on the localization's slug key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param str $slug the slug key of the model to be loaded
	 * @return ProductLocalization the loaded model
	 * @throws CHttpException
	 */
	public function loadProductModelSlug($slug)
	{
	    $model = ProductLocalization::model()->findByAttributes(array('slug'=>$slug));
		
	    if($model===null)
	        throw new CHttpException(404,Yii::t('app', 'La page demandée n\'existe pas.'));
		
		if ($model->locale_id !== Yii::app()->language) {
			// Current slug doesn't exist in the appropriate language. Redirect the user to the appropriate language
			
			$appropriate_model = $model->product->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
			
			if ($appropriate_model){
				// Redirect to that localized model
				$redict_url = $this->createUrl(Yii::app()->controller->action->id, array('slug'=>$appropriate_model->slug, 'language'=>$appropriate_model->locale_id));
				$this->redirect($redict_url);
			}
			throw new CHttpException(404,Yii::t('app', 'La page demandée n\'existe pas.'));
		}
		
	    
	    return $model;
	}
	
	/**
	 * Renders a list of formatted html boxes from a posted json array of product ID
	 * Non existing products id will fail silently. Non existing localizations for current language will return alternative language.
	 */
	public function actionThumbnails(){
		
		$raw_product_ids = Yii::app()->request->getPost("products", "[]");
		$limit = Yii::app()->request->getPost("limit", 4);
		$product_ids = json_decode($raw_product_ids);
		
		
		$array_of_valid_products = array();
		$counter = 0;
		foreach ($product_ids as $product_id) {
			
			
			$product = Product::model()->findByPk($product_id);
			if ($product){
				$array_of_valid_products[] = $product;
			}
			$counter++;

			if ($counter >= $limit)
				break;

		}
		
		$this->renderPartial('_product_thumbnail', array("items"=>$array_of_valid_products, 'style'=>"large"));
		
		
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Product the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app', 'La page demandée n\'existe pas.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Product $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
