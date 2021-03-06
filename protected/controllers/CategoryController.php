<?php

class CategoryController extends WebController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * Displays a particular model.
	 * @param str $slug the 'slug' identifier of the model to be displayed
	 */
	public function actionView($slug)
	{
        
		// Retrieve the model via it's slug
		$model_localization = $this->loadLocalizationModelSlug($slug);
		
		$model = $model_localization->category;

		
		if (!$model->visible)
			throw new CHttpException(404,Yii::t('app', 'La page demandée n\'existe pas.'));
		
		$this->pageTitle = $model_localization->name . " - " . Yii::app()->name;
		
		$alternatives = array();
		foreach ($model->categoryLocalizations as $localization){
			$alternatives[$localization->locale_id] = $this->createAbsoluteUrl("view", array("slug"=>$localization->slug, "language"=>$localization->locale_id));
		}
		$this->alternatives = $alternatives;
		
		// Generate the subcategories to display in the sidebar.
		$children_cache_id = Yii::app()->request->hostInfo . " CategoryController:[children_cats_for_cat] " . $model->id;
		$cache_duration = 300;
		$menu_array = Yii::app()->cache->get($children_cache_id);
		
		if (!$menu_array) {
			
			$menu_array = array();
			
			$children = new Category();
	        $children->unsetAttributes();
			$children->visible = 1;
			$children->id = $model->id;
			$category_data_provider = $children->searchChildren();
		
			foreach ($category_data_provider->getData() as $child){
	
				if ($this->isB2b()){
					// In a B2B store, we show a list of products so users can select many products at once
					$menu_array[] = array('label'=>$child->categoryLocalization->name, 'url'=>array('category/list', "slug"=>$child->categoryLocalization->slug));
				} else {
					$menu_array[] = array('label'=>$child->categoryLocalization->name, 'url'=>array('category/view', "slug"=>$child->categoryLocalization->slug));
				}
			}	
			
			Yii::app()->cache->set($children_cache_id, $menu_array, $cache_duration);
		}
		$this->menu = $menu_array;
		
		
		
		if ($model->parent_category){
			// This is a subcategory
			// Subcategories must display their products. They must also add their parents categories to the page's breadcrumbs
			
			// Display breadcrumbs in the right order (home >> root category >> subcategory 1 >> subcatory 2, etc.)
			$this->breadcrumbs = array();
			function appendMotherCatToBreadcrumbs($cat, &$breadarray){

                $locale_category = $cat->categoryLocalization;


				$breadarray[$locale_category->name] = array("category/view", "slug"=>$locale_category->slug);
				if ($cat->parent_category){
					appendMotherCatToBreadcrumbs($cat->parentCategory, $breadarray);
				}

			}


			if ($model->parent_category){
				appendMotherCatToBreadcrumbs($model->parentCategory, $this->breadcrumbs);
				// The array returned is reversed (top category at the end) we need to reverse it.
				$this->breadcrumbs = array_reverse($this->breadcrumbs);
			}
			
			// We're at the end of the run, just append our name
			$this->breadcrumbs[] = $model_localization->name;
			
			
			// Retrieve the order's products (with the correct localization)
			$current_locale = Yii::app()->language;

			$products_data_provider = null;

            $product = new Product();
            $product->unsetAttributes();
			$product->visible = 1;
			$product->discontinued = 0;
            $product->categoryId = $model->id;
			
			if ($model->is_brand) {
				$products_data_provider = $product->searchForBrand($model);
			} else {
				$products_data_provider = $product->search();
			}
			
			$products_data_provider->setPagination(array('pageSize' => 12));
			
			
            $children = new Category();
            $children->unsetAttributes();
			$children->visible = 1;
			$children->id = $model->id;
			$category_data_provider = $children->searchChildren();
			
			
			$this->render('view',array(
				'model'         => $model,
				'localization'  => $model_localization,
				'products'      => $products_data_provider,
			));
			
		} else {
			// We're dealing with a top category
			// Top categories will NOT display products but some static html invite to choose a subcategory
			
					
			$this->render('rootcat',array(
				'model'=>$model,
				'localization'=>$model_localization,
			));
		}
		
		
	}

	/**
	 * Displays a particular model's products as a long list.
	 * @param str $slug the 'slug' identifier of the model to be displayed
	 */
	public function actionList($slug)
	{
        // Retrieve the model via it's slug
		$model_localization = $this->loadLocalizationModelSlug($slug);
		
		$model = $model_localization->category;

		
		if (!$model->visible)
			throw new CHttpException(404,Yii::t('app', 'La page demandée n\'existe pas.'));
		
		$this->pageTitle = $model_localization->name . " - " . Yii::app()->name;
		
		$alternatives = array();
		foreach ($model->categoryLocalizations as $localization){
			$alternatives[$localization->locale_id] = $this->createAbsoluteUrl("view", array("slug"=>$localization->slug, "language"=>$localization->locale_id));
		}
		
		$this->alternatives = $alternatives;
		
		// Generate the subcategories to display in the sidebar.
		// Generate the subcategories to display in the sidebar.
		$children_cache_id = Yii::app()->request->hostInfo . " CategoryController:[children_cats_for_cat] " . $model->id;
		$cache_duration = 300;
		$menu_array = Yii::app()->cache->get($children_cache_id);
		
		if (!$menu_array) {
			
			$menu_array = array();
			
			$children = new Category();
	        $children->unsetAttributes();
			$children->visible = 1;
			$children->id = $model->id;
			$category_data_provider = $children->searchChildren();
		
			foreach ($category_data_provider->getData() as $child){
	
				if ($this->isB2b()){
					// In a B2B store, we show a list of products so users can select many products at once
					$menu_array[] = array('label'=>$child->categoryLocalization->name, 'url'=>array('category/list', "slug"=>$child->categoryLocalization->slug));
				} else {
					$menu_array[] = array('label'=>$child->categoryLocalization->name, 'url'=>array('category/view', "slug"=>$child->categoryLocalization->slug));
				}
			}
			
			Yii::app()->cache->set($children_cache_id, $menu_array, $cache_duration);
		}
		$this->menu = $menu_array;
		
		
		if ($model->parent_category){
			// This is a subcategory
			// Subcategories must display their products. They must also add their parents categories to the page's breadcrumbs
			
			// Display breadcrumbs in the right order (home >> root category >> subcategory 1 >> subcatory 2, etc.)
			$this->breadcrumbs = array();
			function appendMotherCatToBreadcrumbs($cat, &$breadarray, $locale){

                $locale_category = CategoryLocalization::model()->find("category_id = :category AND locale_id = :locale", array(":category"=>$cat->id, ":locale"=>$locale));


				$breadarray[$locale_category->name] = array("category/view", "slug"=>$locale_category->slug);
				if ($cat->parent_category){
					appendMotherCatToBreadcrumbs($cat->parentCategory, $breadarray, $locale);
				}

			}


			if ($model->parent_category){
				appendMotherCatToBreadcrumbs($model->parentCategory, $this->breadcrumbs, Yii::app()->language);
				// The array returned is reversed (top category at the end) we need to reverse it.
				$this->breadcrumbs = array_reverse($this->breadcrumbs);
			}
			// We're at the end of the run, just append our name
			$this->breadcrumbs[] = $model_localization->name;
			
			
			
			// Retrieve the order's products (with the correct localization)
			$products_data_provider = null;
			
            $product = new Product();
            $product->unsetAttributes();
			$product->visible = 1;
			$product->discontinued = 0;
			$product->categoryId = $model->id;
			
			$product->restrictScopeToCurrentLocale = false;
			
			if ($model->is_brand) {
				$products_data_provider = $product->searchForBrand($model);
			} else {
				$products_data_provider = $product->search();
			}
			
			$products_data_provider->setPagination(array('pageSize' => 100));
			
			$this->render('list',array(
				'model'         => $model,
				'localization'  => $model_localization,
				'products'      => $products_data_provider,
			));
			
		} else {
			throw new CHttpException(404,Yii::t('app', 'La page demandée n\'existe pas.'));
		}
		
		
	}

	


	/**
	 * Returns the data model based on the primary key (id) given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Category the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app', 'La page demandée n\'existe pas.'));
		return $model;
	}
	
	/**
	 * Returns the localization model based on the localization's slug key given in the GET variable.
	 * If the data model is not found, an HTTP exception of type 404 will be raised.
	 * @param str $slug the slug key of the model to be loaded
	 * @return CategoryLocalization the loaded model
	 * @throws CHttpException
	 */
	public function loadLocalizationModelSlug($slug)
	{
	    $model = CategoryLocalization::model()->findByAttributes(array('slug'=>$slug));
		
		// Check if model exists
	    if($model===null)
	        throw new CHttpException(404,Yii::t('app', 'La page demandée n\'existe pas.'));
		
		// If model exists, make sure it's in the same language as the site global variable
		if ($model->locale_id !== Yii::app()->language) {
			// Current slug doesn't exist in the appropriate language. Redirect the user to the appropriate language (if any)
			
			$appropriate_model = $model->category->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
			
			if ($appropriate_model){
				// Redirect to that localized model
				$redict_url = $this->createUrl(Yii::app()->controller->action->id, array('slug'=>$appropriate_model->slug, 'language'=>$appropriate_model->locale_id));
				$this->redirect($redict_url);
			}
			// This product doesn't have a localization in the current's site language
			throw new CHttpException(404,Yii::t('app', 'La page demandée n\'existe pas.'));
		}
		
	    
	    return $model;
	}
	
	
}
